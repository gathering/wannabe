<?
App::uses('HttpSocket', 'Network/Http');

class EnrollController extends AppController {

	var $uses = array('EnrollSetting', 'ApplicationDocument', 'ApplicationComment', 'ApplicationTag', 'ApplicationChoice', 'User', 'Crew', 'Phonetype', 'Improtocol', 'ApplicationAvailablefield', 'ApplicationPage', 'ApplicationField', 'ApplicationSetting', 'EnrollMail');

	public function index() {
		$this->set('title_for_layout', __("View applications"));
		$settings = $this->_getEnrollActiveSettings();

		$filter = CakeSession::read('filter');
		if ($filter && isset($this->request->query['crew_id']) && !empty($this->request->query['crew_id'])) {
			return $this->redirect($filter);
		}

		$this->unbindModels();

		$documents = $this->ApplicationDocument->find('all', array(
			'conditions' => array(
				'ApplicationDocument.event_id'=>$this->Wannabe->event->id,
				'ApplicationDocument.draft'=>0,
				'ApplicationDocument.handled'=>'0000-00-00 00:00:00'
			),
			'order' => 'ApplicationDocument.updated DESC'
		));
		foreach($documents as $dindex => $document) {
            $waiting = 0;
			foreach($document['ApplicationChoice'] as $cindex => $choice) {
                if($choice['waiting']) $waiting++;
				$documents[$dindex]['ApplicationChoice'][$cindex]['acceptable'] = $this->canAccept($choice, $document, $this->Wannabe->user);
            }
            if($waiting == count($document['ApplicationChoice'])) unset($documents[$dindex]);
		}
        $manageable_crews = array();
        $crews = $this->Crew->getAllCrews(true, 0, true);
		foreach ($crews as $crew_id => $crew_name){
            $manageable_crews[$crew_id] = false;
        }
        if ($this->Acl->hasAccess('superuser', $this->Wannabe->user, '/'.$this->Wannabe->event->reference.'/Enroll')) {
            foreach ($this->Crew->find('all', array('conditions' => array('Crew.event_id' => WB::$event->id))) as $crew2){
                $manageable_crews[$crew2['Crew']['id']] = true;
            }
        } else {
            # Get the users crews
            foreach ($this->Wannabe->user['Crew'] as $usercrew) {
                if (2 <= $usercrew['CrewsUser']['leader']) {
                    $manageable_crews[$usercrew['id']] = true;
                    $crews2 = $this->Crew->query("SELECT id, crew_id, name FROM (SELECT id, crew_id, name FROM wb4_crews order by crew_id, id) Crew, (SELECT @pv := '" . $usercrew['id'] . "') initialisation WHERE find_in_set(crew_id, @pv) > 0 AND @pv := concat(@pv, ',', id) ORDER BY name");
                    foreach ($crews2 as $crew2) {
                        $manageable_crews[$crew2['Crew']['id']] = true;
                    }
                }
            }
        }
		$this->set('manageable_crews', $manageable_crews);
		$this->set('enrollsetting', $settings);
		$this->set('crews', $crews);
		$this->set('documents', $documents);
		$this->set('count', count($documents));
		$this->set('tags', $this->ApplicationDocument->getUsedTags());
	}


    public function _getEnrollActiveSettings() {
		$settings = $this->EnrollSetting->find('first', array(
			'conditions' => array(
				'EnrollSetting.event_id'=> $this->Wannabe->event->id
			)
		));

		if(empty($settings) || !$settings['EnrollSetting']['enrollactive'])
			throw new BadRequestException(__("Enrollment not active for this event"));

        return $settings;
    }

	public function filter() {
		$this->set('title_for_layout', __("View applications"));
		// save filter to session
		if (empty($this->request->query)) {
			$filter = CakeSession::read('filter');
			if ($filter) {
				return $this->redirect($filter);
			}
		} else {
			CakeSession::write('filter', $_SERVER['REQUEST_URI']);
		}

        $settings = $this->_getEnrollActiveSettings();

      	$crew_filter = array();
				$documents = array();
				$user_id = $this->Wannabe->user['User']['id'];

        $request_denied = isset($this->request->query['denied']) ? $this->request->query['denied'] : false;
        $request_waiting = isset($this->request->query['waiting']) ? $this->request->query['waiting'] : false;
        $request_crew_id = isset($this->request->query['crew_id']) ? $this->request->query['crew_id'] : false;
        $request_tag = isset($this->request->query['tag']) ? $this->request->query['tag'] : false;
        $deniedwaiting = $this->_getFilterSQL($request_denied, $request_waiting);


        //If however a tag is specified

        //If crew_id AND tag is specified
		if ($request_crew_id && $request_tag && !empty($request_tag)) {
			$applicationDocumentIds = $this->ApplicationDocument->query('SELECT DISTINCT ApplicationTag.application_document_id FROM wb4_application_tags AS ApplicationTag JOIN wb4_application_choices AS ApplicationChoice ON ApplicationChoice.application_document_id=ApplicationTag.application_document_id WHERE ApplicationChoice.crew_id='.(int)$request_crew_id.' '.$deniedwaiting.' AND ApplicationTag.user_id = '.$user_id.' AND ApplicationTag.tag = \''.addslashes($request_tag).'\'');

			foreach ($applicationDocumentIds as $applicationDocumentId) {
				$documents[] = $applicationDocumentId['ApplicationTag']['application_document_id'];
			}
		}
        //Else, of crew_id is specified
		else if ($request_crew_id) {

			$applicationDocumentIds = $this->ApplicationDocument->query('SELECT DISTINCT application_document_id FROM wb4_application_choices ApplicationChoice WHERE crew_id='.(int)$request_crew_id.$deniedwaiting);

			foreach ($applicationDocumentIds as $applicationDocumentId) {
				$documents[] = $applicationDocumentId['ApplicationChoice']['application_document_id'];
			}
		}
        //Else, if tag is specified
		else if ($request_tag && !empty($request_tag)) {
			$applicationDocumentIds = $this->ApplicationDocument->query('SELECT DISTINCT application_document_id FROM wb4_application_tags AS ApplicationTag WHERE user_id = '.$user_id.' AND tag = \''.addslashes($request_tag).'\'');
			foreach ($applicationDocumentIds as $applicationDocumentId) {
				$documents[] = $applicationDocumentId['ApplicationTag']['application_document_id'];
			}
		}
        else {
            $this->redirectEvent('/Enroll');
        }

        if(sizeof($documents) == 0) {
            $this->render('index');
        }

		$this->unbindModels();

		$documents = $this->ApplicationDocument->find('all', array(
			'conditions' => array(
				'ApplicationDocument.draft' => 0,
				'ApplicationDocument.id' => $documents
			),
			'order' => 'ApplicationDocument.orderedchoices DESC'
		));

        foreach($documents as $dindex => $document) {
            $waiting = 0;

			foreach($document['ApplicationChoice'] as $cindex => $choice) {
				if(($choice['waiting'] == 1 && !$request_waiting) ||
					($choice['accepted'] == 1) ||
					($choice['denied'] == 1 && !$request_denied) ||
					($choice['disabled'] == 1)) {
					$waiting++;
				}
				$documents[$dindex]['ApplicationChoice'][$cindex]['acceptable'] = $this->canAccept($choice, $document, $this->Wannabe->user);
			}
			if($waiting == count($document['ApplicationChoice'])) {
				// All choices have been handled(?)
				unset($documents[$dindex]);
			}
		}

        $manageable_crews = array();
        $crews = $this->Crew->getAllCrews(true, 0, true);
        foreach ($crews as $crew_id => $crew_name){
            $manageable_crews[$crew_id] = false;
        }
        if ($this->Acl->hasAccess('superuser', $this->Wannabe->user, '/'.$this->Wannabe->event->reference.'/Enroll')) {
            foreach ($this->Crew->find('all', array('conditions' => array('Crew.event_id' => WB::$event->id))) as $crew2){
                $manageable_crews[$crew2['Crew']['id']] = true;
            }
        } else {
            # Get the users crews
            foreach ($this->Wannabe->user['Crew'] as $usercrew) {
                if (2 <= $usercrew['CrewsUser']['leader']) {
                    $manageable_crews[$usercrew['id']] = true;
                    $crews2 = $this->Crew->query("SELECT id, crew_id, name FROM (SELECT id, crew_id, name FROM wb4_crews order by crew_id, id) Crew, (SELECT @pv := '" . $usercrew['id'] . "') initialisation WHERE find_in_set(crew_id, @pv) > 0 AND @pv := concat(@pv, ',', id) ORDER BY name");
                    foreach ($crews2 as $crew2) {
                        $manageable_crews[$crew2['Crew']['id']] = true;
                    }
                }
            }
        }

		$this->set('manageable_crews', $manageable_crews);
		$this->set('enrollsetting', $settings);
		$this->set('crews', $crews);
		$this->set('documents', $documents);
		$this->set('count', count($documents));
		$this->set('tags', $this->ApplicationDocument->getUsedTags());
		$this->render('index');
	}

    public function _getFilterSQL($request_denied, $request_waiting) {

        $denied = '';

        if($request_denied && $request_waiting) {
            $deniedwaiting = ' AND (ApplicationChoice.denied=1 OR ApplicationChoice.waiting=1)';
        }
        elseif($request_denied) {
            $deniedwaiting = ' AND (ApplicationChoice.denied=1 AND ApplicationChoice.waiting=0)';
        }
        elseif($request_waiting) {
            $deniedwaiting = ' AND (ApplicationChoice.denied=0 AND ApplicationChoice.waiting=1)';
        }
        else {
            $deniedwaiting = ' AND (ApplicationChoice.denied=0 AND ApplicationChoice.waiting=0)';
        }

        return $deniedwaiting;
    }

	public function view($user_id) {
		$this->set('title_for_layout', __("View application"));
		$settings = $this->EnrollSetting->find('first', array(
			'conditions' => array(
				'EnrollSetting.event_id'=> $this->Wannabe->event->id
			)
		));
		if(empty($settings) || !$settings['EnrollSetting']['enrollactive']) {
			throw new BadRequestException(__("Enrollment not active for this event"));
		}
		if(!$settings['EnrollSetting']['enrollaccept']) {
			$this->Flash->info(__("Accepting and denying is currently disabled"));
		}
		$this->ApplicationAvailablefield->unbindModel(array(
			'belongsTo' => array(
				'CreatedBy'
			)
		));
		$this->ApplicationAvailablefield->unbindModel(array(
			'belongsTo' => array(
				'ApplicationFieldtype'
			)
		));

		$document = $this->ApplicationDocument->findDocumentNotDraft($user_id);

		if(empty($document)) {
			throw new BadRequestException("No application for user.");
		}

		foreach ($document['ApplicationChoice'] as $index => $choice) {
			if (0 == $choice['crew_id']) {
				unset($document['ApplicationChoice'][$index]);
			}
		}

		$this->set('output', $this->User->find('first', array(
			'conditions' => array(
				'User.id' => $user_id
			)
		)));
		foreach($document['ApplicationChoice'] as $cindex => $choice) {
			$document['ApplicationChoice'][$cindex]['acceptable'] = $this->canAccept($choice, $document, $this->Wannabe->user);
			$document['ApplicationChoice'][$cindex]['deniable'] = $this->canDeny($choice, $document, $this->Wannabe->user);
			$document['ApplicationChoice'][$cindex]['waitable'] = $this->canAccept($choice, $document, $this->Wannabe->user) && !$choice['waiting'];
			$document['ApplicationChoice'][$cindex]['disableable'] = $this->canDisable($choice, $document, $this->Wannabe->user);
		}
		$this->set('document', $document);
		$page = $this->ApplicationPage->find('all', array(
			'conditions' => array(
				'ApplicationPage.event_id' => $this->Wannabe->event->id
			)
		));
		$this->set('page', $page);

		$this->set('settings', $this->ApplicationSetting->find('first', array(
			'conditions' => array(
				'ApplicationSetting.event_id'=> $this->Wannabe->event->id
			)
		)));
		$this->set('enrollsetting', $this->EnrollSetting->find('first', array(
			'conditions' => array(
				'EnrollSetting.event_id' => $this->Wannabe->event->id
			)
		)));
		$this->set('tags', $this->ApplicationDocument->getTags($document['ApplicationDocument']['id']));
		$this->set('comments', $this->ApplicationComment->getComments($document['ApplicationDocument']['id']));
		$this->set('superuser', $this->Acl->hasAccess('superuser'));
        $manageable_crews = array();
        $crews = $this->Crew->getAllCrews(true, 0, true);
        foreach ($crews as $crew_id => $crew_name){
            $manageable_crews[$crew_id] = false;
        }
        if ($this->Acl->hasAccess('superuser', $this->Wannabe->user, '/'.$this->Wannabe->event->reference.'/Enroll')) {
            foreach ($this->Crew->find('all', array('conditions' => array('Crew.event_id' => WB::$event->id))) as $crew2){
                $manageable_crews[$crew2['Crew']['id']] = true;
            }
        } else {
            # Get the users crews
            foreach ($this->Wannabe->user['Crew'] as $usercrew) {
                if (2 <= $usercrew['CrewsUser']['leader']) {
                    $manageable_crews[$usercrew['id']] = true;
                    $crews2 = $this->Crew->query("SELECT id, crew_id, name FROM (SELECT id, crew_id, name FROM wb4_crews ORDER BY crew_id, id) Crew, (SELECT @pv := '" . $usercrew['id'] . "') initialisation WHERE find_in_set(crew_id, @pv) > 0 AND @pv := concat(@pv, ',', id) ORDER BY name");
                    foreach ($crews2 as $crew2) {
                        $manageable_crews[$crew2['Crew']['id']] = true;
                    }
                }
            }
        }
		$this->set('manageable_crews', $manageable_crews);

		$this->set('crews', $crews);
		$this->set('phonetypes', $this->Phonetype->find('list'));
		$this->set('improtocols', $this->Improtocol->find('list'));
	}

	public function savetags($document_id) {
		$this->ApplicationDocument->setTags($document_id, $this->data['tags']);
		$document = $this->ApplicationDocument->find('first', array(
			'conditions' => array(
				'ApplicationDocument.id' => $document_id
			)
		));
		$this->redirectEvent('/Enroll/view/'.$document['User']['id']);
	}

	public function addcomment($document_id) {
		$this->ApplicationComment->addComment($document_id, $this->data['comment']);
		$document = $this->ApplicationDocument->find('first', array(
			'conditions' => array(
				'ApplicationDocument.id' => $document_id
			)
		));
		$this->redirectEvent('/Enroll/view/'.$document['User']['id']);
	}

	public function savepriority($document_id) {
		$this->ApplicationDocument->setPriority($document_id, $this->data['priority']);
		$document = $this->ApplicationDocument->find('first', array(
			'conditions' => array(
				'ApplicationDocument.id' => $document_id
			)
		));
		$this->redirectEvent('/Enroll/view/'.$document['User']['id']);
	}

	public function accept() {
		$settings = $this->EnrollSetting->find('first', array(
			'conditions' => array(
				'EnrollSetting.event_id'=> $this->Wannabe->event->id
			)
		));
		if(empty($settings) || !$settings['EnrollSetting']['enrollactive']) {
			throw new BadRequestException(__("Enrollment not active for this event"));
		}
		$document = $this->ApplicationDocument->find('first', array(
			'conditions' => array(
				'ApplicationDocument.id' => $this->request->query['document_id']
			)
		));
		$choice = $this->ApplicationChoice->find('first', array(
			'conditions' => array(
				'ApplicationChoice.id' => $this->request->query['choice_id']
			)
		));

		if (!$document || !$choice) {
			throw new BadRequestException(__('The document or choice does not exists.'));
		}

		if (!$this->canAccept($choice['ApplicationChoice'], $document, $this->Wannabe->user)) {
			throw new BadRequestException(__('You do not have access to accept this choice.'));
		}

		if (isset($this->request->query['confirmed']) && $this->request->query['confirmed']) {
			$settings = $this->EnrollSetting->find('first', array(
				'conditions' => array(
					'EnrollSetting.event_id' => $this->Wannabe->event->id
				)
			));
			$acceptmail = $this->EnrollMail->find('first', array(
				'conditions' => array(
					'EnrollMail.enroll_setting_id' => $settings['EnrollSetting']['id'],
					'EnrollMail.type' => 'accepted'
				)
			));
			$this->ApplicationDocument->accept($document, $choice,0,0, $acceptmail);

			if ($this->request->data['leader']) {
				$this->Crew->setUserRole($choice['ApplicationChoice']['crew_id'], $document['User']['id'], (int)$this->request->data['leader']);
			}

			if(Configure::check('Slack.token')) {
				$this->sendSlackInvite($document['User']['email'], $document['User']['realname']);
			}

			$this->Flash->success(__("Application has now been accepted."));
			$this->redirectEvent(isset($this->data['return_to']) ? $this->data['return_to'] : '/enroll/application/view/'.$document['ApplicationDocument']['user_id']);
		}
		else {
			$userroles = $this->Crew->getUserRoles();
			$crew = $this->Crew->find('first', array(
				'conditions' => array(
					'Crew.id' => $choice['ApplicationChoice']['crew_id']
				)
			));
			$userrole = $this->Crew->getMemberUserRole($crew, $this->Wannabe->user);
			$superuser = $this->Acl->hasAccess('superuser');
			foreach($userroles as $index => $roles) {
				if($index >= $userrole && !$superuser) {
					unset($userroles[$index]);
				}
			}
			$this->set('userroles', $userroles);
			$this->set('crews', $this->Crew->getAllCrews(true));
			$this->set('title_for_layout', __("Accepting %s's application for", $document['User']['realname']));
			$this->set('desc_for_layout', __("%s of %s", $crew['Crew']['name'], $this->Wannabe->event->name));
			$this->set('document', $document);
			$this->set('choice', $choice);
			$this->set('action', 'accept');

			$this->render('manage-confirm');
		}
	}

	public function sendSlackInvite($email, $name = null) {
		/**
		 * This is a quick and dirty hack to automatically send a Slack invite when accepting a crew member.
		 */


		if(Configure::check('Slack.token')) {
			// Slack token is set in configuration, lets go!
			// TODO: Implement check against event settings

			$settings = $this->EnrollSetting->find('first', array(
				'conditions' => array(
					'EnrollSetting.event_id'=> $this->Wannabe->event->id
				)
			));
			if(empty($settings) || !$settings['EnrollSetting']['slackactive']) {
				return false;
			}

			$slack_token = Configure::read('Slack.token');

			$HttpSocket = new HttpSocket();
			try{
				$results = $HttpSocket->post(
					'https://slack.com/api/users.admin.invite',
					'token='.$slack_token.'&email='.$email.'&real_name='.$name
				);
				$body = json_decode($results->body, true);
				if($body["ok"] != "true"){
					$this->Flash->warning(__("Slack invite failed to send to user. User might already be in workspace, or user needs to be manually activated. Please contact support."));
					return false;
				} else {
					$this->Flash->success(__("Slack invite to sent to user."));
					return true;
				}
			} catch (Exception $e) {
				// Failed to invite user..
				$this->Flash->error(__("Slack invite failed to send to user."));
				return false;
			}
		}
	}

	public function wait() {
		$settings = $this->EnrollSetting->find('first', array(
			'conditions' => array(
				'EnrollSetting.event_id'=> $this->Wannabe->event->id
			)
		));
		if(empty($settings) || !$settings['EnrollSetting']['enrollactive']) {
			throw new BadRequestException(__("Enrollment not active for this event"));
		}
		$document = $this->ApplicationDocument->find('first', array(
			'conditions' => array(
				'ApplicationDocument.id' => $this->request->query['document_id']
			)
		));
		$choice = $this->ApplicationChoice->find('first', array(
			'conditions' => array(
				'ApplicationChoice.id' => $this->request->query['choice_id']
			)
		));

		if (!$document || !$choice) {
			throw new BadRequestException(__('The document or choice does not exists.'));
		}

		if (!$this->canAccept($choice['ApplicationChoice'], $document, $this->Wannabe->user)) {
			throw new BadRequestException(__('You do not have access to set this choice on waiting list.'));
		}

		if (isset($this->request->query['confirmed']) && $this->request->query['confirmed']) {
			if(!empty($this->request->data['waitmessage'])) {
				$crewname = $this->ApplicationChoice->query("SELECT wb4_crews.name FROM wb4_crews, wb4_application_choices WHERE wb4_crews.id = wb4_application_choices.crew_id AND wb4_application_choices.id = ".$choice['ApplicationChoice']['id']);
				$message = __("From")." ".$crewname[0]['wb4_crews']['name']."\n".$this->request->data['waitmessage']."\n";
            } else {
                $message = "";
            }
			$settings = $this->EnrollSetting->find('first', array(
				'conditions' => array(
					'EnrollSetting.event_id' => $this->Wannabe->event->id
				)
			));
			$waitmail = $this->EnrollMail->find('first', array(
				'conditions' => array(
					'EnrollMail.enroll_setting_id' => $settings['EnrollSetting']['id'],
					'EnrollMail.type' => 'waiting'
				)
			));
			$this->ApplicationDocument->wait($document, $choice, $waitmail, $message);

			$this->Flash->success(__("Application has now been placed on waiting list."));
			$this->redirectEvent(isset($this->data['return_to']) ? $this->data['return_to'] : '/Enroll/view/'.$document['ApplicationDocument']['user_id']);
		} else {
			$userroles = $this->Crew->getUserRoles();
			$crew = $this->Crew->find('first', array(
				'conditions' => array(
					'Crew.id' => $choice['ApplicationChoice']['crew_id']
				)
			));
			$userrole = $this->Crew->getMemberUserRole($crew, $this->Wannabe->user);
			$superuser = $this->Acl->hasAccess('superuser');
			foreach($userroles as $index => $roles) {
				if($index >= $userrole && !$superuser) {
					unset($userroles[$index]);
				}
			}
			$this->set('userroles', $userroles);
			$this->set('crews', $this->Crew->getAllCrews(true, 0, true));
			$this->set('title_for_layout', __("Setting %s's application on waiting list", $document['User']['realname']));
			$this->set('desc_for_layout', __("%s of %s", $crew['Crew']['name'], $this->Wannabe->event->name));
			$this->set('document', $document);
			$this->set('choice', $choice);
			$this->set('action', 'waiting');
			$this->render('manage-confirm');
		}
	}

	public function deny() {
		$settings = $this->EnrollSetting->find('first', array(
			'conditions' => array(
				'EnrollSetting.event_id'=> $this->Wannabe->event->id
			)
		));
		if((empty($settings) || !$settings['EnrollSetting']['enrollaccept']) && !$this->Acl->hasAccess('superuser')) {
			throw new BadRequestException(__("Enrollment processing not active for this event"));
		}
		$document = $this->ApplicationDocument->find('first', array(
			'conditions' => array(
				'ApplicationDocument.id' => $this->request->query['document_id']
			)
		));
		$choice = $this->ApplicationChoice->find('first', array(
			'conditions' => array(
				'ApplicationChoice.id' => $this->request->query['choice_id']
			)
		));

		if (!$document || !$choice) {
			throw new BadRequestException(__('The document or choice does not exists.'));
		}

		if (!$this->canDeny($choice['ApplicationChoice'], $document, $this->Wannabe->user)) {
			throw new BadRequestException(__('You do not have access to deny this choice.'));
		}

		if (isset($this->request->query['confirmed']) && $this->request->query['confirmed']) {
			if(!empty($this->data['denialmessage'])) {
				$crewname = $this->ApplicationChoice->query("SELECT wb4_crews.name FROM wb4_crews, wb4_application_choices WHERE wb4_crews.id = wb4_application_choices.crew_id AND wb4_application_choices.id = ".$choice['ApplicationChoice']['id']);
				$denialmessage = __("From")." ".$crewname[0]['wb4_crews']['name']."\n".$this->request->data['denialmessage']."\n";
            } else {
				$denialmessage = "";
            }
			$settings = $this->EnrollSetting->find('first', array(
				'conditions' => array(
					'EnrollSetting.event_id' => $this->Wannabe->event->id
				)
			));
			$pendingmail = $this->EnrollMail->find('first', array(
				'conditions' => array(
					'EnrollMail.enroll_setting_id' => $settings['EnrollSetting']['id'],
					'EnrollMail.type' => 'pending'
				)
			));
			$deniedmail = $this->EnrollMail->find('first', array(
				'conditions' => array(
					'EnrollMail.enroll_setting_id' => $settings['EnrollSetting']['id'],
					'EnrollMail.type' => 'denied'
				)
			));
			$this->ApplicationDocument->deny($document, $choice, $deniedmail, $pendingmail, $denialmessage);
			$this->Flash->info(__("Application has now been denied."));
			$this->redirectEvent(isset($this->data['return_to']) ? $this->data['return_to'] : '/Enroll/view/'.$document['ApplicationDocument']['user_id']);
		} else {
			$userroles = $this->Crew->getUserRoles();
			$crew = $this->Crew->find('first', array(
				'conditions' => array(
					'Crew.id' => $choice['ApplicationChoice']['crew_id']
				)
			));
			$userrole = $this->Crew->getMemberUserRole($crew, $this->Wannabe->user);
			foreach($userroles as $index => $roles) {
				if($index >= $userrole) {
					unset($userroles[$index]);
				}
			}
			$this->set('userroles', $userroles);
			$this->set('crews', $this->Crew->getAllCrews(true, 0, true));
			$this->set('title_for_layout', __("Denying %s's application for", $document['User']['realname']));
			$this->set('desc_for_layout', __("%s of %s", $crew['Crew']['name'], $this->Wannabe->event->name));
			$this->set('document', $document);
			$this->set('choice', $choice);
			$this->set('action', 'deny');

			$this->render('manage-confirm');
		}
	}

	// Disabling an application, essentially removing it without any notifications
	public function disable() {
		// Mostly copied from denied

		$settings = $this->EnrollSetting->find('first', array(
			'conditions' => array(
				'EnrollSetting.event_id'=> $this->Wannabe->event->id
			)
		));
		if((empty($settings) || !$settings['EnrollSetting']['enrollaccept']) && !$this->Acl->hasAccess('superuser')) {
			throw new BadRequestException(__("Enrollment processing not active for this event"));
		}
		$document = $this->ApplicationDocument->find('first', array(
			'conditions' => array(
				'ApplicationDocument.id' => $this->request->query['document_id']
			)
		));
		$choice = $this->ApplicationChoice->find('first', array(
			'conditions' => array(
				'ApplicationChoice.id' => $this->request->query['choice_id']
			)
		));

		if (!$document || !$choice) {
			throw new BadRequestException(__('The document or choice does not exists.'));
		}

		if (!$this->canDisable($choice['ApplicationChoice'], $document, $this->Wannabe->user)) {
			throw new BadRequestException(__('You do not have access to deny this choice.'));
		}

		// Form post
		if (isset($this->request->query['confirmed']) && $this->request->query['confirmed']) {
			$this->ApplicationDocument->disable($document, $choice);
			$this->Flash->info(__("Application has now been denied."));
			$this->redirectEvent(isset($this->data['return_to']) ? $this->data['return_to'] : '/Enroll/view/'.$document['ApplicationDocument']['user_id']);
		// Show confirm form
		} else {
			$userroles = $this->Crew->getUserRoles();
			$crew = $this->Crew->find('first', array(
				'conditions' => array(
					'Crew.id' => $choice['ApplicationChoice']['crew_id']
				)
			));
			$userrole = $this->Crew->getMemberUserRole($crew, $this->Wannabe->user);
			foreach($userroles as $index => $roles) {
				if($index >= $userrole) {
					unset($userroles[$index]);
				}
			}
			$this->set('userroles', $userroles);
			$this->set('crews', $this->Crew->getAllCrews(true, 0, true));
			$this->set('title_for_layout', __("Removing %s's application for", $document['User']['realname']));
			$this->set('desc_for_layout', __("%s of %s", $crew['Crew']['name'], $this->Wannabe->event->name));
			$this->set('document', $document);
			$this->set('choice', $choice);
			$this->set('action', 'disable');

			$this->render('manage-confirm');
		}
	}

	private function unbindModels() {
		$this->User->loadExtras = false;
		$this->User->unbindModel(
			array(
				'hasMany' => array('Userphone', 'Userim', 'Userhistory')
			)
		);
		$this->ApplicationDocument->unbindModel(
			array(
				'hasMany' => array('ApplicationField')
			)
		);
	}

	private function canAccept($choice, $document, $user) {
		if ($choice['accepted'] || $choice['denied'] || $choice['disabled'])
			return false;

        $settings = $this->ApplicationSetting->find('first', array(
            'conditions' => array(
                'ApplicationSetting.event_id' => $this->Wannabe->event->id
            )
        ));

        if(isset($document['ApplicationDocument']['applyingopen']) && $document['ApplicationDocument']['applyingopen'] && $choice['crew_id'] == $settings['ApplicationSetting']['open']) {
          return false;
				}

		// 1. Check that the choice we are going to accept is "on top" and that the list is ordered.
		//    Also check that the application is not accepted (if so we are not allowed to handle it).
        foreach ($document['ApplicationChoice'] as $application_choice) {
			if ($application_choice['waiting'] || $application_choice['denied']) // dnied choices is not relevant
				continue;

			if ($application_choice['accepted']) // the application is accepted, can't handle.
				return false;

			if ($document['ApplicationDocument']['orderedchoices'] && $application_choice['priority'] < $choice['priority']) {
				if($application_choice['crew_id'])
					return false;
			}
		}

		$usercrews = $this->getCrewsForUser($user, 0); // 2 == co-chief

		// 2. Check that the user is member of the crew in question
		if (in_array($choice['crew_id'], $usercrews) && $this->Acl->hasAccess('manage', $this->Wannabe->user, '/'.$this->Wannabe->event->reference.'/Enroll'))
			return true;

		// 3. Check that the user is member of a crew above the crew in question.
		if ($this->isParentcrewMember($usercrews, $choice['crew_id']))
			return true;

		// 4. Check that the user is superuser.
		if ($this->Acl->hasAccess('superuser', $this->Wannabe->user, '/'.$this->Wannabe->event->reference.'/Enroll'))
			return true;

		return false;
	}

	private function canDeny($choice, $document, $user) {
		if ($choice['accepted'] || $choice['denied'] || $choice['disabled'])
			return false;

		// 1. Check if the application is handled.
		foreach ($document['ApplicationChoice'] as $application_choice) {
			if ($application_choice['accepted'])
				return false;
		}

		$usercrews = $this->getCrewsForUser($user, 0); // 2 == co-chief

		// 2. Check that the user is member of the crew in question.
		if (in_array($choice['crew_id'], $usercrews) && $this->Acl->hasAccess('manage', $this->Wannabe->user, '/'.$this->Wannabe->event->reference.'/Enroll'))
			return true;

		// 3. Check that the user is member of a crew above the crew in question.
		if ($this->isParentcrewMember($usercrews, $choice['crew_id']))
			return true;

		// 3. Check that the user is superuser.
		if ($this->Acl->hasAccess('superuser', $this->Wannabe->user, '/'.$this->Wannabe->event->reference.'/Enroll'))
			return true;

		return false;
	}


	private function canDisable($choice, $document, $user) {
		if ($choice['accepted'] || $choice['denied'] || $choice['disabled'])
			return false;

		// 1. Check if the application is handled.
		foreach ($document['ApplicationChoice'] as $application_choice) {
			if ($application_choice['accepted'])
				return false;
		}
		// 2. Check that the user is superuser.
		if ($this->Acl->hasAccess('superuser', $this->Wannabe->user, '/'.$this->Wannabe->event->reference.'/Enroll'))
			return true;

		return false;
	}

	private function isParentcrewMember($usercrews, $crew_id) {
	    # This is bad and makes me sad, something should be done to prevent it from needing the run this sql for every applicant
        foreach ($usercrews as $usercrew) {
                $crews2 = $this->Crew->query("SELECT id, crew_id FROM (SELECT id, crew_id, name FROM wb4_crews WHERE event_id = '"WB::$event->id"' order by crew_id, id) Crew, (SELECT @pv := '".$usercrew."') initialisation WHERE find_in_set(crew_id, @pv) > 0 AND @pv := concat(@pv, ',', id) ORDER BY name");
                foreach ($crews2 as $crew2){
                    if($crew2['Crew']['id'] == $crew_id){
                        return true;
                    }
                }
        }

		return false;
	}

	private function canManage($crew_id, $user) {
		$usercrews = $this->getCrewsForUser($user, 0); // 2 == co-chief

		foreach ($usercrews as $available_crew_id) {
			if ($available_crew_id == $crew_id)
				return true;
		}

		if ($this->isParentcrewMember($usercrews, $crew_id))
			return true;

		if ($this->Acl->hasAccess('superuser', $this->Wannabe->user, '/'.$this->Wannabe->event->reference.'/Enroll'))
			return true;

		return false;
	}
}
