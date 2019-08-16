<?php

/**
 * Component that handles global variables
 */
class WannabeComponent extends Component {

	var $event = array(
		'id' => 0,
		'reference' => null,
		'disable' => false,
		'urlmode' => 'path'
	);
	var $menu = array();
	var $user = array();
	var $lang;
	var $searchAccess = false;

	public function initialize(&$controller) {
		if(isset($controller->request->params['eventPrefix'])) {
			if($controller->request->params['eventPrefix'] != CakeSession::read('last_event_reference')) {
				$controller->changedEvent = true;
			}
			CakeSession::write('last_event_reference', $controller->request->params['eventPrefix']);
			$events = Cache::read('events');
			if(!$events) {
				App::import('Model', 'Event');
				$eventInstance = new Event();
				$events = $eventInstance->find('all');
				Cache::write('events', $events);
			}
			$event = array();
			foreach($events as $current) {
				if($current['Event']['reference'] == $controller->request->params['eventPrefix']) {
					$event = $current;
				}
			}
			if(!empty($event)) {
				$this->event = $event['Event'];
				WB::$event = $this->event;
			} else {
				$controller->Flash->error(__('The page “%s” does not exist.', $controller->here));
				$controller->redirect('/');
			}
		}
		$this->event = (object)$this->event;
		WB::$event = (object)WB::$event;
	}
}
