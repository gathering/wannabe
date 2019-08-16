<?php

    class SleepingPlacesController extends AppController {

        public $uses = array('SleepingPlaces');

        public function index() {
            $this->set('sleepingplaces', $this->SleepingPlaces->find('all'));
        }

        public function updateStatus($section, $status) {
            $this->SleepingPlaces->updateStatus($section, $status);
            $this->set('section', $section);
            $this->set('status', $status);
            $this->render('updatestatus');
        }
    }

?>
