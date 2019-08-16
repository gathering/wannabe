<?

class HandleController extends CfadAppController {

    public $uses = array(
        'Cfad.CfadApplicationField',
        'Cfad.CfadApplicationChoice',
        'Cfad.CfadApplicationAvailablefield',
        'Cfad.CfadApplicationPage',
        'ApplicationFieldType',
        'Cfad.CfadApplicationDocument',
        'Crew',
        'Cfad.CfadCrew',
        'Cfad.CfadApplicationSetting',
        'User',
        'Phonetype',
        'Improtocol'
    );

	public function view($user_id) {
		$this->set('title_for_layout', __("View application"));
		$this->CfadApplicationAvailablefield->unbindModel(array(
			'belongsTo' => array(
				'CreatedBy'
			)
		));
		$this->CfadApplicationAvailablefield->unbindModel(array(
			'belongsTo' => array(
				'CfadApplicationFieldtype'
			)
		));

		$document = $this->CfadApplicationDocument->findDocumentNotDraft($user_id);

		if(empty($document)) {
			throw new BadRequestException("No application for user.");
		}

		foreach ($document['CfadApplicationChoice'] as $index => $choice) {
			if (0 == $choice['crew_id']) {
				unset($document['CfadApplicationChoice'][$index]);
			}
		}

		$this->set('output', $this->User->find('first', array(
			'conditions' => array(
				'User.id' => $user_id
			)
		)));
		$this->set('document', $document);
		$page = $this->CfadApplicationPage->find('all', array(
			'conditions' => array(
				'CfadApplicationPage.event_id' => $this->Wannabe->event->id
			)
		));
		$this->set('page', $page);

		$this->set('settings', $this->CfadApplicationSetting->find('first', array(
			'conditions' => array(
				'CfadApplicationSetting.event_id'=> $this->Wannabe->event->id
			)
		)));
		$crews = $this->Crew->getAllCrews(true, 0, true);
		$this->set('crews', $crews);
		$this->set('phonetypes', $this->Phonetype->find('list'));
		$this->set('improtocols', $this->Improtocol->find('list'));
	}

	public function accept() {
		$document = $this->CfadApplicationDocument->find('first', array(
			'conditions' => array(
				'CfadApplicationDocument.id' => $this->request->query['document_id']
			)
		));
		$choice = $this->CfadApplicationChoice->find('first', array(
			'conditions' => array(
				'CfadApplicationChoice.id' => $this->request->query['choice_id']
			)
		));

		if (!$document || !$choice) {
			throw new BadRequestException(__('The document or choice does not exists.'));
		}

		if (isset($this->request->query['confirmed']) && $this->request->query['confirmed'] && isset($this->request->data['day']) && $this->request->data['day']) {
			$this->CfadApplicationDocument->accept($document, $choice, $this->request->data['day']);
			$this->Flash->success(__("CfadApplication has now been accepted."));
			$this->redirectEvent(isset($this->data['return_to']) ? $this->data['return_to'] : '/cfad/Handle/view/'.$document['CfadApplicationDocument']['user_id']);
        }
		else {
            if(isset($this->request->data['day']) && !$this->request->data['day'])
                $this->set('invaliddate', true);
			$crew = $this->Crew->find('first', array(
				'conditions' => array(
					'Crew.id' => $choice['CfadApplicationChoice']['crew_id']
				)
			));
			$this->set('crews', $this->Crew->getAllCrews(true, 0, true));
			$this->set('title_for_layout', __("Accepting %s's application for", $document['User']['realname']));
			$this->set('desc_for_layout', __("%s of %s", $crew['Crew']['name'], $this->Wannabe->event->name));
			$this->set('document', $document);
			$this->set('choice', $choice);
			$this->set('action', 'accept');
            $this->set('dates', $this->dates());
			$this->render('manage-confirm');
		}
	}

	public function deny() {
		$document = $this->CfadApplicationDocument->find('first', array(
			'conditions' => array(
				'CfadApplicationDocument.id' => $this->request->query['document_id']
			)
		));
		$choice = $this->CfadApplicationChoice->find('first', array(
			'conditions' => array(
				'CfadApplicationChoice.id' => $this->request->query['choice_id']
			)
		));

		if (!$document || !$choice) {
			throw new BadRequestException(__('The document or choice does not exists.'));
		}

		if (isset($this->request->query['confirmed']) && $this->request->query['confirmed']) {
			if(!empty($this->data['denialmessage'])) {
				$denialmessage = $this->request->data['denialmessage']."\n";
            } else {
				$denialmessage = "";
            }
			$this->CfadApplicationDocument->deny($document, $choice, $denialmessage);
			$this->Flash->info(__("Application has now been denied."));
			$this->redirectEvent(isset($this->data['return_to']) ? $this->data['return_to'] : '/cfad/Handle/view/'.$document['CfadApplicationDocument']['user_id']);
		} else {
			$crew = $this->Crew->find('first', array(
				'conditions' => array(
					'Crew.id' => $choice['CfadApplicationChoice']['crew_id']
				)
			));
			$this->set('crews', $this->Crew->getAllCrews(true, 0, true));
			$this->set('title_for_layout', __("Denying %s's application for", $document['User']['realname']));
			$this->set('desc_for_layout', __("%s of %s", $crew['Crew']['name'], $this->Wannabe->event->name));
			$this->set('document', $document);
			$this->set('choice', $choice);
			$this->set('action', 'deny');
			$this->render('manage-confirm');
		}
	}

    private function dates() {
        // Calculate possible dates and prepare for view
        $start = strtotime(substr($this->Wannabe->event->show_time, 0, 10) . ' 00:00:00');
        $end = strtotime(substr($this->Wannabe->event->end, 0, 10) . ' 00:00:00');
        $dates = array();
        do $dates[date('Y-m-d H:i:s', $start)] = date('l, M j', $start);
        while ($start < $end && $start += 86400);
        return $dates;
    }

	private function unbindModels() {
		$this->User->loadExtras = false;
		$this->User->unbindModel(
			array(
				'hasMany' => array('Userphone', 'Userim', 'Userhistory')
			)
		);
		$this->CfadApplicationDocument->unbindModel(
			array(
				'hasMany' => array('CfadApplicationField')
			)
		);
	}
}
