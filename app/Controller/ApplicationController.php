<?php
/**
 * Application Controller
 *
 */
class ApplicationController extends AppController {

	public $uses = array('ApplicationField', 'ApplicationChoice', 'ApplicationAvailablefield', 'ApplicationPage', 'ApplicationFieldType', 'ApplicationDocument', 'Crew', 'ApplicationSetting');
	var $layout = 'responsive-default';

	public function index($current_page=0) {
		if (!$this->Wannabe->event->can_apply_for_crew) {
			throw new BadRequestException(__("This event is not open for crew applications."));
		}

		$settings = $this->ApplicationSetting->getSettings();

		$current_page = (int)$current_page;

		$pages = $this->ApplicationPage->getPages();

		$this->data = $this->ApplicationDocument->findDocument($this->Wannabe->user['User']['id']);
		if (empty($this->data)) {
			$this->ApplicationDocument->save(array('event_id'=>$this->Wannabe->event->id, 'user_id'=>$this->Wannabe->user['User']['id']));
			$this->data = $this->ApplicationDocument->findDocument($this->Wannabe->user['User']['id']);
		} else {
			CakeSession::write('application_editing_existing', true);
		}

        $data = $this->data;
        $sorting = false;
		foreach ($data['ApplicationField'] as $index => $field) {

			if ($field['crew_id']) {
				$field['value'] = htmlspecialchars_decode($field['value']);
				$data['ApplicationField']['crew'.$field['crew_id'].'-'.$field['application_availablefield_id']] = $field;
				unset($data['ApplicationField'][$index]);
            } else {
                $field['value'] = htmlspecialchars_decode($field['value']);
                $data['ApplicationField'][0] = $field;
			}
            /*if ($field['application_availablefield_id'] == '213') {
                unset($data['ApplicationField'][$index]);
                $data['ApplicationField'][0] = $field;
                $sorting = true;
            }*/
        }
        if($sorting) {
            $this->aasort($data['ApplicationField'],"application_availablefield_id");
        }
        $this->data = $data;

		// get the current page.
		if (isset($pages[$current_page])) {
			$page = & $pages[$current_page];
		} else {
			throw new BadRequestException(__("There has been an error, please try again."));
		}
		if($this->Wannabe->user['User']['language'] == 'eng') {
			$this->Flash->info(__("Currently, the application process is only available in Norwegian. For assistance contact co@gathering.org"));
		}

		$this->set('data', $data);
		$this->set('readonly', $this->isReadOnly($this->data));
		$this->set('pages', $pages);
		$this->set('page', $page);
		$this->set('current_page', $current_page);
		$this->set('totalpages', count($pages));
		$this->set('crews', $this->Crew->getAllCrews(true, 0, true));
		$this->set('open_crews', $this->Crew->getOpenCrews(true));
		$this->set('fieldtypes', $this->ApplicationFieldType->getFieldTypes());
		$this->set('settings', $settings);
		$this->set('title_for_layout', __("Crew application"));
		$this->set('desc_for_layout', __("Applying for crew for %s", $this->Wannabe->event->name));
		$this->render('index');
	}

	public function step($current_page=0) {
		return $this->index($current_page);
	}

	public function save() {
		$pages = $this->ApplicationPage->getPages();

		// fetch the saved crew application
		$document = $this->ApplicationDocument->findDocument($this->Wannabe->user['User']['id']);
		if (!$document || empty($document)) {
			throw new BadRequestException(__("No application for your user found, please start over."));
		}

		$readonly = $this->isReadOnly($document);

		$draft = 1;
		$num_pages = count($pages);
		$current_page = (int)$this->data['Application']['current_page'];


		// find a page to redirect to.
		if (isset($this->data['Application']['next'])) {
			$current_page ++;
		} elseif (isset($this->data['Application']['previous'])) {
			$current_page --;
		} elseif (isset($this->data['Application']['gotopage'])) {
			$current_page = (int)$this->data['Application']['gotopage'];
		}


		// if we are done, remove the flag that says that this is a draft.
		if ($current_page >= $num_pages || (CakeSession::read('application_editing_existing') && !$document['ApplicationDocument']['draft'])) {
			$draft = 0;
		}


		// save the document.
		if (!$readonly && isset($this->data['ApplicationDocument']) && is_array($this->data['ApplicationDocument'])) {
			$savedocument = $this->data['ApplicationDocument'];
			$savedocument['event_id'] = $this->Wannabe->event->id;
			$savedocument['user_id'] = $this->Wannabe->user['User']['id'];
			$savedocument['draft'] = $draft;
			$savedocument['handled'] = '0000-00-00 00:00:00';
			$this->ApplicationDocument->save($savedocument);
		}
		// save all the crew choices.
        if(isset($this->request->data['ApplicationDocument']['applyingopen']) && $this->request->data['ApplicationDocument']['applyingopen']) {
		    $settings = $this->ApplicationSetting->getSettings();
            $this->request->data['ApplicationChoice'] = array(
                '0' => array(
                    'crew_id' => $settings['ApplicationSetting']['open']
                )
            );
        }
		if (!$readonly && isset($this->data['ApplicationChoice']) && is_array($this->data['ApplicationChoice'])) {
            $no_choice = true;
            $open_crews = $this->Crew->getOpenCrews(true);
            $this->ApplicationChoice->query('DELETE FROM wb4_application_choices where handled="0000-00-00 00:00:00" and accepted=0 and denied=0 and waiting=0 and disabled is null and application_document_id='.$document['ApplicationDocument']['id']);

            // Check if any crews are selected, if not return to page
            if(isset($this->data['ApplicationChoice'])) {
                $choices = array();
                foreach($this->data['ApplicationChoice'] as $choice) {
                    $choices[] = $choice['crew_id'];
                }
                if(strlen(implode($choices)) == 0) {
                    $this->Flash->info(__("Please select at least one crew"));
                    $this->redirectEvent('/Application/step/'.(int)$this->data['Application']['current_page'].'?'.rand(10000,99999));
                }
            }

            $used = array();
			foreach ($this->request->data['ApplicationChoice'] as $index => &$choice) {
                if($choice['crew_id']) {
                    $no_choice = false;
                    $valid_choice = false;
                    if(isset($this->request->data['ApplicationDocument']['applyingopen']) && $this->request->data['ApplicationDocument']['applyingopen']) {
                        $valid_choice = true;
                    } else {
                        foreach($open_crews as $oc => $oc_name) {
                            if($choice['crew_id'] == $oc)
                                $valid_choice = true;
                        }
                    }
                    if(!$valid_choice && isset($document['ApplicationChoice']) && is_array($document['ApplicationChoice'])) {
                        foreach($document['ApplicationChoice'] as $past_choice) {
                            if($choice['crew_id'] == $past_choice['crew_id'])
                                $valid_choice = true;
                        }
                    }
                    if($valid_choice) {
                        foreach($used as $c) {
                            if($choice['crew_id'] == $c)
                                continue 2;
                        }
                        $used[] = $choice['crew_id'];
                        $choice['application_document_id'] = $document['ApplicationDocument']['id'];
                        $choice['event_id'] = $this->Wannabe->event->id;
                        $choice['draft'] = 0;
                        $choice['priority'] = $index;
                        $this->ApplicationChoice->save($choice);
                    } else {
                        throw new BadRequestException(__("Application processing error. Try again."));
                    }
                }
            }
            if($no_choice) {
                throw new BadRequestException(__("You must choose at least one crew to apply for."));
            }
		}


		// save the fields.
		if (!$readonly && isset($this->data['ApplicationField']) && is_array($this->data['ApplicationField'])) {
			foreach ($this->data['ApplicationField'] as $field) {
				$field['application_document_id'] = $document['ApplicationDocument']['id'];
				$field['draft'] = $draft;
                $this->ApplicationField->id = $field['id'];
				$this->ApplicationField->save($field);
			}
		}


		if ($current_page >= $num_pages) {
			// we are done, redirect to the page that says the user is done.
			CakeSession::write('application_document_id', $document['ApplicationDocument']['id']);
			$this->redirectEvent('/Application/done?'.rand(10000,99999));
		} else {
			// make sure that the page we are redirecting to exists.
			if ($current_page < 0) {
				$current_page = (int)$this->data['Application']['current_page'];
			}
			$this->redirectEvent('/Application/step/'.$current_page.'?'.rand(10000,99999));
		}
	}

	public function done() {
		if (!CakeSession::check('application_document_id')) {
			throw new CakeException(__("You reached this page in the wrong way."));
		}

		$document_id = CakeSession::read('application_document_id');
		CakeSession::delete('application_document_id');
		CakeSession::delete('application_editing_existing');

		$document = $this->ApplicationDocument->findDocument($this->Wannabe->user['User']['id']);
		if (!$document || empty($document) || $document['ApplicationDocument']['id'] != $document_id) {
			throw new CakeException(__("You came here by an error, please start over."));
		}

		$readonly = $this->isReadOnly($document);
		if ($readonly) {
			throw new CakeException(__("You can not save this crew application as it has already been accepted (it's in read only mode)."));
		}

		$pages = $this->ApplicationPage->getPages();
		$application_settings = $this->ApplicationSetting->getSettings();
		$crews = $this->Crew->getAllCrews(true);

		$email = new CakeEmail('default');
		$email->viewVars(array(
			'page' => $pages,
			'wannabe' => $this->Wannabe,
			'crews' => $crews,
			'settings' => $application_settings,
			'document' => $document
		));
		$email->template('application_recieved', 'plain')
			->emailFormat('text')
			->subject(__("%s — your application has been recieved!", $this->Wannabe->event->name))
			->to($this->Wannabe->user['User']['email'])
			->send();
		$this->Flash->success(__("Your application was successfully saved. An email has been sent to “%s”, confirming the details", $this->Wannabe->user['User']['email']));

		$this->set('settings', $application_settings);
		$this->set('name', $this->Wannabe->user['User']['realname']);
		$this->set('crews', $crews);
		$this->set('page', $pages);
		$this->set('document', $document);
		$this->set('title_for_layout', __("Congratulations!"));
		$this->set('desc_for_layout', __("Application submitted"));
	}

	private function isReadOnly($document) {
		$handled = $document['ApplicationDocument']['handled'] != '0000-00-00 00:00:00';
		if (!$handled) {
			return false;
		}

		// We know that the crew application is handled, but it isn't read only if the application
		// has been denied. Check for that.
		$isAccepted = false;
		foreach ($document['ApplicationChoice'] as $choice) {
			if ($choice['accepted']) {
				$isAccepted = true;
			}
		}

		if ($isAccepted) {
			return true;
		}

		return false;
    }
    private function aasort (&$array, $key) {
        $sorter=array();
        $ret=array();
        reset($array);
        foreach ($array as $ii => $va) {
            $sorter[$ii]=$va[$key];
        }
        asort($sorter);
        foreach ($sorter as $ii => $va) {
            $ret[$ii]=$array[$ii];
        }
        $array=$ret;
    }

}
?>
