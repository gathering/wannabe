<?php
/**
 * Application Controller
 *
 */
class CfadApplicationController extends CfadAppController {

    public $uses = array(
        'Cfad.CfadApplicationField',
        'Cfad.CfadApplicationChoice',
        'Cfad.CfadApplicationAvailablefield',
        'Cfad.CfadApplicationPage',
        'ApplicationFieldType',
        'Cfad.CfadApplicationDocument',
        'Crew',
        'Cfad.CfadCrew',
        'Cfad.CfadApplicationSetting'
    );

	public function index($current_page=0) {
		$settings = $this->CfadApplicationSetting->getSettings();

		if (!$settings['CfadApplicationSetting']['can_apply']) {
			throw new BadRequestException(__("This event is not open for crew for a day applications."));
		}

		$current_page = (int)$current_page;

		$pages = $this->CfadApplicationPage->getPages();

		$this->data = $this->CfadApplicationDocument->findDocument($this->Wannabe->user['User']['id']);
		if (empty($this->data)) {
			$this->CfadApplicationDocument->save(array('event_id'=>$this->Wannabe->event->id, 'user_id'=>$this->Wannabe->user['User']['id']));
			$this->data = $this->CfadApplicationDocument->findDocument($this->Wannabe->user['User']['id']);
		} else {
			CakeSession::write('application_editing_existing', true);
		}

        $data = $this->data;
        $sorting = false;
		foreach ($data['CfadApplicationField'] as $index => $field) {
			if ($field['crew_id']) {
				$data['CfadApplicationField']['crew'.$field['crew_id'].'-'.$field['application_availablefield_id']] = $field;
				unset($data['CfadApplicationField'][$index]);
            }
        }
        if($sorting) {
            $this->aasort($data['CfadApplicationField'],"application_availablefield_id");
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
		$this->set('pages', $pages);
		$this->set('page', $page);
		$this->set('current_page', $current_page);
		$this->set('crews', $this->Crew->getAllCrews(true, 0, true));
		$this->set('open_crews', $this->CfadCrew->getCrews());
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
		$pages = $this->CfadApplicationPage->getPages();

		// fetch the saved crew application
		$document = $this->CfadApplicationDocument->findDocument($this->Wannabe->user['User']['id']);
		if (!$document || empty($document)) {
			throw new BadRequestException(__("No application for your user found, please start over."));
		}

		$draft = 1;
		$num_pages = count($pages);
		$current_page = (int)$this->data['CfadApplication']['current_page'];

		// find a page to redirect to.
		if (isset($this->data['CfadApplication']['next'])) {
			$current_page ++;
		} elseif (isset($this->data['CfadApplication']['previous'])) {
			$current_page --;
		} elseif (isset($this->data['CfadApplication']['gotopage'])) {
			$current_page = (int)$this->data['CfadApplication']['gotopage'];
		}


		// if we are done, remove the flag that says that this is a draft.
		if ($current_page >= $num_pages || (CakeSession::read('application_editing_existing') && !$document['CfadApplicationDocument']['draft'])) {
			$draft = 0;
		}


		// save the document.
		if (isset($this->data['CfadApplicationDocument']) && is_array($this->data['CfadApplicationDocument'])) {
			$savedocument = $this->data['CfadApplicationDocument'];
			$savedocument['event_id'] = $this->Wannabe->event->id;
			$savedocument['user_id'] = $this->Wannabe->user['User']['id'];
			$savedocument['draft'] = $draft;
			$savedocument['handled'] = '0000-00-00 00:00:00';
			$this->CfadApplicationDocument->save($savedocument);
		}
		// save all the crew choices.
		if (isset($this->data['CfadApplicationChoice']) && is_array($this->data['CfadApplicationChoice'])) {
            $no_choice = true;
            $open_crews = $this->CfadCrew->getCrews();
            $this->CfadApplicationChoice->query('DELETE FROM wb4_cfad_application_choices where handled="0000-00-00 00:00:00" and accepted=0 and denied=0 and application_document_id='.$document['CfadApplicationDocument']['id']);
			$used = array();
			foreach ($this->request->data['CfadApplicationChoice'] as $index => &$choice) {
                if($choice['crew_id']) {
                    $no_choice = false;
                    $valid_choice = false;
                    foreach($open_crews as $oc => $oc_name) {
                        if($choice['crew_id'] == $oc)
                            $valid_choice = true;
                    }
                    if(!$valid_choice && isset($document['CfadApplicationChoice']) && is_array($document['CfadApplicationChoice'])) {
                        foreach($document['CfadApplicationChoice'] as $past_choice) {
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
                        $choice['application_document_id'] = $document['CfadApplicationDocument']['id'];
                        $choice['event_id'] = $this->Wannabe->event->id;
                        $choice['draft'] = 0;
                        $choice['priority'] = $index;
                        $this->CfadApplicationChoice->save($choice);
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
		if (isset($this->data['CfadApplicationField']) && is_array($this->data['CfadApplicationField'])) {
			foreach ($this->data['CfadApplicationField'] as $field) {
				$field['application_document_id'] = $document['CfadApplicationDocument']['id'];
				$field['draft'] = $draft;
                $this->CfadApplicationField->id = $field['id'];
				$this->CfadApplicationField->save($field);
			}
		}


		if ($current_page >= $num_pages) {
			// we are done, redirect to the page that says the user is done.
			CakeSession::write('application_document_id', $document['CfadApplicationDocument']['id']);
			$this->redirectEvent('/cfad/CfadApplication/done?'.rand(10000,99999));
		} else {
			// make sure that the page we are redirecting to exists.
			if ($current_page < 0) {
				$current_page = (int)$this->data['CfadApplication']['current_page'];
			}
			$this->redirectEvent('/cfad/CfadApplication/step/'.$current_page.'?'.rand(10000,99999));
		}
	}

	public function done() {
		if (!CakeSession::check('application_document_id')) {
			throw new CakeException(__("You reached this page in the wrong way."));
		}

		$document_id = CakeSession::read('application_document_id');
		CakeSession::delete('application_document_id');
		CakeSession::delete('application_editing_existing');



		$document = $this->CfadApplicationDocument->findDocument($this->Wannabe->user['User']['id']);
		if (!$document || empty($document) || $document['CfadApplicationDocument']['id'] != $document_id) {
			throw new CakeException(__("You came here by an error, please start over."));
		}



		$pages = $this->CfadApplicationPage->getPages();
		$application_settings = $this->CfadApplicationSetting->getSettings();
		$crews = $this->Crew->getAllCrews(true, 0, true);

		$email = new CakeEmail('default');
		$email->viewVars(array(
			'page' => $pages,
			'wannabe' => $this->Wannabe,
			'crews' => $crews,
			'settings' => $application_settings,
			'document' => $document
		));
		$email->template('cfad_application_recieved', 'plain')
			->emailFormat('text')
			->subject(__("%s — your crew for a day application has been recieved!", $this->Wannabe->event->name))
			->to($this->Wannabe->user['User']['email'])
			->send();
		$this->Flash->success(__("Your crew for a day application was successfully saved. An email has been sent to “%s”, confirming the details", $this->Wannabe->user['User']['email']));

		$this->set('settings', $application_settings);
		$this->set('name', $this->Wannabe->user['User']['realname']);
		$this->set('crews', $crews);
		$this->set('page', $pages);
		$this->set('document', $document);
		$this->set('title_for_layout', __("Congratulations!"));
		$this->set('desc_for_layout', __("Crew for a day application submitted"));
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
