<?php
class StorageController extends LogisticAppController {
    var $uses = array('Logistic.LogisticStorage', 'Logistic.LogisticLocation', 'Logistic.LogisticTransaction', 'Crew');
    var $layout = 'responsive-default';

	public function index() {
		$this->set('title_for_layout', __("Storage units"));
		$this->set('units', $this->LogisticStorage->find('all', array(
			'conditions' => array(
                'LogisticStorage.logistic_location_id' => $this->Session->read('logisticLocationID')
			)
		)));
        $this->set('crews', $this->Crew->getAllCrews());
	}
	public function create() {
		if($this->request->is('post')) {
			$this->request->data['LogisticStorage']['logistic_location_id'] = $this->Session->read('logisticLocationID');
            $exists = $this->LogisticStorage->find('first', array(
                'conditions' => array(
                    'LogisticStorage.logistic_location_id' => $this->Session->read('logisticLocationID'),
                    'LogisticStorage.name' => $this->request->data['LogisticStorage']['name']
                )
            ));
            if(is_array($exists) && !empty($exists)) {
                $this->LogisticStorage->invalidate('LogisticStorage.name', __("Storage unit already exists"));
            }
			$this->LogisticStorage->set($this->request->data);
			if($this->LogisticStorage->validates()) {
			    $this->LogisticStorage->save($this->request->data);
				$this->Flash->success(__("%s was created", $this->request->data['LogisticStorage']['name']));
                $this->redirectEvent('/logistic/storage');
			} else {
				$this->set('validateErrors', $this->LogisticStorage->invalidFields());
				$this->validateErrors($this->LogisticStorage);
				$this->Flash->error(__("You have field errors. Please correct them and continue."));
			}
		}
		$this->set('title_for_layout', __("Create new storage unit"));
	}
	public function edit($id=0) {
		if($this->request->is('post')) {
			$this->request->data['LogisticStorage']['logistic_location_id'] = $this->Session->read('logisticLocationID');
            $exists = $this->LogisticStorage->find('first', array(
                'conditions' => array(
                    'LogisticStorage.logistic_location_id' => $this->Session->read('logisticLocationID'),
                    'LogisticStorage.name' => $this->request->data['LogisticStorage']['name'],
                    'LogisticStorage.id !=' => $this->request->data['LogisticStorage']['id']
                )
            ));
            if(is_array($exists) && !empty($exists)) {
                $this->LogisticStorage->invalidate('LogisticStorage.name', __("Storage unit already exists"));
            }
			$this->LogisticStorage->set($this->request->data);
			if($this->LogisticStorage->validates()) {
			    $this->LogisticStorage->save($this->request->data);
				$this->Flash->success(__("%s was saved", $this->request->data['LogisticStorage']['name']));
                $this->redirectEvent('/logistic/storage');
			} else {
				$this->set('validateErrors', $this->LogisticStorage->invalidFields());
				$this->validateErrors($this->LogisticStorage);
				$this->Flash->error(__("You have field errors. Please correct them and continue."));
			}
		}
		if(!$id) {
			$this->Flash->warning(__("Select storage unit to edit"));
            $this->redirectEvent('/logistic/storage');
		}
		$unit = $this->LogisticStorage->find('first', array(
			'conditions' => array(
				'LogisticStorage.id' => $id,
                'LogisticStorage.logistic_location_id' => $this->Session->read('logisticLocationID')
			)
		));
		if(!is_array($unit)) {
			throw new BadRequestException(__("No such storage unit"));
		}
		$this->set('unit', $unit);
		$this->set('title_for_layout', __("Edit storage unit"));
		$this->set('desc_for_layout', $unit['LogisticStorage']['name']);
	}
	public function delete($id) {
		if($this->request->is('post')) {
			if($this->LogisticStorage->delete($this->request->data['LogisticStorage']['id'])) {
				$this->Flash->success(__("Storage unit deleted"));
                $this->redirectEvent('/logistic/storage');
			}
		}
		if(!$id) {
			$this->Flash->warning(__("Select storage unit to delete"));
            $this->redirectEvent('/logistic/storage');
		}
		$unit = $this->LogisticStorage->find('first', array(
			'conditions' => array(
				'LogisticStorage.id' => $id,
                'LogisticStorage.logistic_location_id' => $this->Session->read('logisticLocationID')
			)
		));
		if(!is_array($unit)) {
			throw new BadRequestException(__("No such storage unit"));
		}
		$this->set('unit', $unit);
		$this->set('title_for_layout', __("Delete storage unit"));
		$this->set('desc_for_layout', $unit['LogisticStorage']['name']);
	}
}
