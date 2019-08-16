<?php
class LocationController extends LogisticAppController {

	public $uses = array('Logistic.LogisticStorage', 'Logistic.LogisticLocation', 'Logistic.LogisticTransaction', 'User', 'Logistic.LogisticTag', 'Logistic.LogisticStatus', 'Crew', 'Logistic.LogisticSupplier', 'Logistic.LogisticItem', 'Logistic.LogisticBulk');

	public function create() {
		if(count($this->request->data) > 0){
			$this->LogisticLocation->create();
			$this->LogisticLocation->save($this->request->data);
			$this->redirectEvent('/logistic/');
		}
	}

	public function setLocation($locID) {
		$this->Session->write('logisticLocationID', (int)$locID);
		$this->redirectEvent('/logistic');
	}
}
