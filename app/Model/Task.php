<?php
/**
 * Task Model
 *
 */
class Task extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

	public $actsAs = array(
		'Translate' => array(
            'name',
			'message'
		)
	);

	public function getTasks() {
        if(isset(WB::$event->id)) {
            $tasks = $this->find('all',array(
                'conditions' => array(
                    'Task.event_id' => WB::$event->id,
                    'Task.enabled' => 1
                )
            ));
            return $tasks;
        } else
            return array();
	}

    public function getTask($id=null) {
        if(!$id)
            return false;
		$task = $this->find('first',array(
			'conditions' => array(
				'Task.id' => $id,
                'Task.enabled' => 1
			)
		));
		return $task;
	}
}
