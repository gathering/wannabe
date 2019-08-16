<?php

class TaskAdminController extends AppController {
	var $uses = array('Task', 'User');

	public function index() {
		$this->set('title_for_layout', __("Administer tasks"));
		$this->set('tasks', $this->Task->find('all', array(
			'conditions' => array(
				'Task.event_id' => $this->Wannabe->event->id
			)
		)));
	}
	public function create() {
        $this->set('langs', $this->Language->localeMap);
		if($this->request->is('post')) {
            $this->request->data['Task']['event_id'] = $this->Wannabe->event->id;
            $saveall = true;
            foreach($this->Language->localeMap as $lang => $locale) {
                $this->Task->locale = $lang;
                $task = array(
                    'Task' => $this->request->data['Task']
                );
                $task['Task'] += $this->request->data['Task'][$lang];
                if(!$this->Task->save($task)) {
                    $saveall = false;
                }
            }
            if ($saveall) {
                $this->Flash->success(__("%s was created", $this->request->data['Task']['name']));
                $this->redirectEvent('/TaskAdmin');
			}
		}
		$this->set('title_for_layout', __("Create new task"));
	}
	public function edit($id=0) {
        $this->set('langs', $this->Language->localeMap);
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['Task']['event_id'] = $this->Wannabe->event->id;
            $saveall = true;
            foreach($this->Language->localeMap as $lang => $locale) {
                $this->Task->locale = $lang;
                $task = array(
                    'Task' => $this->request->data['Task']
                );
                $task['Task'] += $this->request->data['Task'][$lang];
                if(!$this->Task->save($task)) {
                    $saveall = false;
                }
            }
            if ($saveall) {
                $this->Flash->success(__("%s was saved", $this->request->data['Task']['eng']['name']));
                $this->redirectEvent('/TaskAdmin');
			}
		}
		if(!$id) {
			$this->Flash->warning(__("Select task to edit"));
			$this->redirectEvent('/TaskAdmin');
		}
        $this->Task->bindTranslation(array(
            'message' => 'messageTranslation'
        ));
        $this->Task->bindTranslation(array(
            'name' => 'nameTranslation'
        ));
        $this->Task->recursive = 1;
		$task = $this->Task->find('first', array(
			'conditions' => array(
				'Task.id' => $id,
				'Task.event_id' => $this->Wannabe->event->id
			)
		));
		if(!is_array($task)) {
			throw new BadRequestException(__("No such task"));
		}
		$this->set('task', $task);
		$this->set('title_for_layout', __("Edit task"));
		$this->set('desc_for_layout', $task['Task']['name']);
	}
	public function delete($id) {
		if($this->request->is('post')) {
			if($this->Task->delete($this->request->data['Task']['id'])) {
				$task_id = $this->request->data['Task']['id'];
				$this->Flash->success(__("Task deleted"));
				$this->redirectEvent('/TaskAdmin');
			}
		}
		if(!$id) {
			$this->Flash->warning(__("Select task to delete"));
			$this->redirectEvent('/TaskAdmin');
		}
		$task = $this->Task->find('first', array(
			'conditions' => array(
				'Task.id' => $id,
				'Task.event_id' => $this->Wannabe->event->id
			)
		));
		if(!is_array($task)) {
			throw new BadRequestException(__("No such task"));
		}
		$this->set('task', $task);
		$this->set('title_for_layout', __("Delete task"));
		$this->set('desc_for_layout', $task['Task']['name']);
	}
}
