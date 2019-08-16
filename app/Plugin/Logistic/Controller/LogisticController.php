<?php
class LogisticController extends LogisticAppController {

	public $uses = array('Logistic.LogisticStorage', 'Logistic.LogisticLocation', 'Logistic.LogisticTransaction', 'User', 'Logistic.LogisticTag', 'Logistic.LogisticStatus', 'Crew', 'Logistic.LogisticSupplier', 'Logistic.LogisticItem', 'Logistic.LogisticBulk');

    var $layout = 'responsive-default';

	public function index() {
        $locations = $this->LogisticLocation->find('all');
        if(count($locations) === 1) {
            $this->Session->write('logisticLocationID', (int)$locations[0]['LogisticLocation']['id']);
        }
		if($this->Session->check('logisticLocationID')) {
            $this->location = $this->LogisticLocation->findById($this->Session->read('logisticLocationID'));
            if(CakeSession::check('LogisticTab')) {
                $tab = CakeSession::read('LogisticTab');
                CakeSession::delete('LogisticTab');
            } else {
                $tab = 'search';
            }
            $this->set('location', $this->location);
            $this->set('title_for_layout', __("Logistics"));
            $this->set('tab', $tab);
			$this->render('main');
		}
		$this->set('locations', $locations);
		$this->set('title_for_layout', __("Select location"));
		CakeSession::write('LogisticTab', 'search');
	}

	public function setLocation($locID) {
		$this->Session->write('logisticLocationID', (int)$locID);
		$this->redirectEvent('/logistic/Storage');
	}
}
