<?php
class EventController extends AppController {

	public $requireLogin = false;

	/**
	 * List all events
	 */
	function index() {
		$this->Session->delete('was');
                $events = $this->Event->find('all', array('conditions'=>array('hide'=>0, 'disable'=>0), array('order'=>array('start'=>'asc'))));
		$this->set('title_for_layout', __("Event"));
                $this->set('events', $events);
		$this->layout = 'front-generic';
        if($this->request->is('ajax')) {
			$this->layout = 'modal';
		}
	}

	/**
	 * Change event for logged in user
	 */
	function change() {
		$events = $this->Event->find('all', array('conditions'=>array('hide'=>0, 'disable'=>0), array('order'=>array('start'=>'asc'))));
		$this->set('title_for_layout', __("Change events"));
		$this->set('desc_for_layout', __("Please select desired event"));
		$this->set('events', $events);
		$this->render('index');
	}

	/**
	 * Redirects user to the newest active event
	 */
	function redirectToLatest() {
		$event = $this->Event->find('first', array('conditions'=>array('hide'=>0, 'disable'=>0),'order'=>array('start'=>'DESC')));
		$this->redirect('/'.$event['Event']['reference'].'/');
	}
}
