<?php
class CheckinController extends AppController {

        public $uses = array('');

	public function index() {
		$this->render('index', 'ajax');
	}
}
