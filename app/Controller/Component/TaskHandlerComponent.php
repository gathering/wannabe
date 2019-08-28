<?php

/**
 * Component that handles task redirection
 * @Author Roy Viggo Larsen
 */
class TaskHandlerComponent extends Component {

    var $task = array();
    var $task_button = false;

	public function initialize(Controller $controller) {
        if(!isset($controller->Wannabe->user['User']) ||
           !$controller->Wannabe->event->reference ||
           $controller->Wannabe->user['User']['registered'] != 'done' ||
           !$controller->Acl->hasMembershipToEvent($controller->Wannabe->user) ||
           !$controller->requireLogin) {
			return true;
        }
        $tasks = $this->checkForUpdatedTasks($controller);
        if($tasks) {
            if(isset($controller->Wannabe->user['UserTask'])) {
                foreach($controller->Wannabe->user['UserTask'] as $userTask) {
                    if($userTask['completed']) {
                        continue;
                    }
                    foreach($tasks as $task) {
                        if($task['Task']['id'] == $userTask['task_id']) {
                            if($task['Task']['condition'] != '') {
                                $result = false;
                                eval($task['Task']['condition']);
                                if(is_array($result) && !empty($result)) {
                                    App::import('Model', 'UserTask');
                                    $userTaskModel = new UserTask();
                                    $userTaskModel->query('UPDATE wb4_user_tasks SET completed = 1 WHERE user_id='.$controller->Wannabe->user['User']['id'].' AND task_id='.$task['Task']['id'].' AND event_id='.$controller->Wannabe->event->id);
                                    $controller->Auth->reloadUserLogin($controller->Wannabe->user['User']['id']);
                                } else {
                                    $this->task = $task;
                                    break 2;
                                }
                            } else if($task['Task']['complete_with_model']) {
                                $this->task = $task;
                                break 2;
                            }
                        }
                    }
                }
            }
            if(!empty($this->task)) {
                if(strpos($controller->here, '/'.$controller->Wannabe->event->reference.'/TaskAdmin') !== false ||
                   strpos($controller->here, '/'.$controller->Wannabe->event->reference.'/User') !== false ||
                   strpos($controller->here, '/'.$controller->Wannabe->event->reference.'/Task') !== false ||
                   strpos($controller->here, '/'.$controller->Wannabe->event->reference.'/Files') !== false ||
                   strpos($controller->here, '/'.$controller->Wannabe->event->reference.'/Term') !== false) {
                    return true;
                }

                $this->task_button = $this->task['Task']['skip_button'];
                if($this->task['Task']['allow_sub']) {
                    if(strpos($controller->here, '/'.$controller->Wannabe->event->reference.$this->task['Task']['redirect']) !== false) {
                        return true;
                    } else {
                        if($this->task_button) {
                            CakeSession::write('taskRedir', $controller->here);
                        }
                    }
                } else {
                    if($controller->here == '/'.$controller->Wannabe->event->reference.$this->task['Task']['redirect']) {
                        return true;
                    } else {
                        if($this->task_button) {
                            CakeSession::write('taskRedir', $controller->here);
                        }
                    }
                }
                $controller->Flash->info($this->task['Task']['message']);
                if($this->task['Task']['condition']) {
                    $result = false;
                    eval($this->task['Task']['condition']);
                    if(!is_array($result) || empty($result)) {
                        $controller->redirectEvent($this->task['Task']['redirect']);
                        return true;
                    } else {
                        return true;
                    }
                } else {
                    $controller->redirectEvent($this->task['Task']['redirect']);
                }
                return true;
            } else {
                return true;
            }
        } else {
            return true;
        }
	}

    private function checkForUpdatedTasks(&$controller) {
        $user = $controller->Wannabe->user;
        App::import('Model', 'Task');
        $taskModel = new Task();
        $tasks = $taskModel->getTasks();
        $return = $tasks;
        if (is_array($tasks) && !empty($tasks)) {
            foreach($tasks as $index => $task) {
                if (isset($user['UserTask']) && is_array($user['UserTask']) && !empty($user['UserTask'])) {
                    foreach($user['UserTask'] as $userTask) {
                        if($task['Task']['id'] == $userTask['task_id']) {
                            unset($tasks[$index]);
                        }
                    }
                }
            }
        }
        if (is_array($tasks) && !empty($tasks)) {
            $controller->Auth->reloadUserLogin($user['User']['id']);
        }
        return $return;
    }
}
