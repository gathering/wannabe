<?php
class SmsBudgetAdminController extends AppController {
    public $uses = array('User', 'SmsBudget',);

/**
 * function index
 *
 * @return void
 */
    public function index() {
        if ($this->request->is('post')) {
            if ($this->SmsBudget->save($this->request->data)) {
                $this->Flash->success(__("Budget was successfully updated."));
            }
            else {
                $this->Flash->success(__("Budget was not updated."));
            }

            $this->redirectEvent('/SmsBudgetAdmin');
        }

        $this->set('budgets', $this->SmsBudget->getBudgetsForEvent());
        $this->set('title_for_layout', 'Manage SMS budgets');
    }

    public function add() {
        if ($this->request->is('post')) {
            if ($this->SmsBudget->getBudgetForUser($this->request->data['user_id'])) {
                $this->Flash->error(__("User already has a budget."));
            }
            else {
                $this->request->data['event_id'] = $this->Wannabe->event->id;
                $this->request->data['sms_sent'] = 0;

                if ($this->SmsBudget->save($this->request->data)) {
                    $this->Flash->success(__("Budget was successfully added."));
                }
                else {
                    $this->Flash->error(__("Budget could not be added."));
                }
            }
        }

        $this->redirectEvent('/SmsBudgetAdmin');
    }
}
