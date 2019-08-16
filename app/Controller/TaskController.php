<?php
class TaskController extends AppController {
    var $uses = array('Task', 'UserTask');
    public function complete($task=0) {
        if(isset($this->TaskHandler->task['Task']) && $task == $this->TaskHandler->task['Task']['id']) {
            if($this->TaskHandler->task['Task']['skip_button']) {
                $this->UserTask->query('UPDATE wb4_user_tasks SET completed = 1 WHERE user_id='.$this->Wannabe->user['User']['id'].' AND task_id='.$this->TaskHandler->task['Task']['id'].' AND event_id='.$this->Wannabe->event->id);
                $this->Auth->reloadUserLogin($this->Wannabe->user['User']['id']);
            }
        }
        if(CakeSession::check('taskRedir')){
            $this->redirect(CakeSession::read('taskRedir'));
        } else {
            $this->redirectEvent('/');
        }
    }
}
