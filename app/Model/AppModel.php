<?php

App::uses('Model', 'Model');
class AppModel extends Model {

    public function isEventUnique($check) {

        $check['event_id'] = WB::$event->id;
        $exists_field = $this->find('count', array(
            'conditions' => $check,
            'recursive' => -1
            ));
        return !$exists_field;
    }

    public function beforeSave($options = array()) {
        if($this->alias != 'Task') {
            App::import('Model', 'Task');
            $taskModel = new Task();
            $tasks = $taskModel->getTasks();
            $active = false;
            foreach($tasks as $index => $task) {
                if($task['Task']['model'] == $this->alias) {
                    $active = $task;
                }
            }
            if($active && $active['Task']['complete_with_model']) {
                App::import('Model', 'UserTask');
                $userTaskModel = new UserTask();
                $userTaskModel->query('UPDATE wb4_user_tasks SET completed = 1 WHERE user_id='.WB::$user['User']['id'].' AND task_id='.$active['Task']['id'].' AND event_id='.WB::$event->id);
                App::import('Model', 'User');
                $userModel = new User();
                $userModel->setUserHash(WB::$user);
            }
        }
        return true;
    }
}
