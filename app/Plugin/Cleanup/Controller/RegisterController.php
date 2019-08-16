<?php

class RegisterController extends CleanupAppController {

    public $uses = array('User', 'Crew', 'Cleanup.Cleanup', 'Cleanup.CleanupPosition', 'Cleanup.CleanupExemptCrew',);

    public function view() {
        if (!isset($this->params['named']['cleanup'])) {
            $this->Flash->error(__("Received no cleanup ID."));
            $this->redirectEvent('/Cleanup');
        } else {
            if ($this->request->is('post')) {
                $completed = false;
                if (isset($this->request->data['completed'])) {
                    $completed = true;
                }

                $data = array(
                    'CleanupPosition' => array(
                        'id' => $this->request->data['CleanupPosition']['id'],
                        'comment' => $this->request->data['CleanupPosition']['comment'],
                        'completed' => $completed,
                    )
                );

                if ($this->CleanupPosition->save($data)) {
                    $this->Flash->success(__("Paticipation updated."));
                } else {
                    $this->Flash->error(__("Could not save."));
                }
            }
            $cleanup = $this->Cleanup->find('first', array(
                'conditions' => array(
                    'Cleanup.id' => $this->params['named']['cleanup'],
                    'Cleanup.event_id' => $this->Wannabe->event->id
                )
            ));
            if(!empty($cleanup)) {
                $this->set('cleanup', $cleanup);
                $this->set('title_for_layout', __("Register cleanup, %s", '<span class="moment format">' . $cleanup['Cleanup']['unixtime'] . '</span>'));
                $upcoming = $cleanup['Cleanup']['cleanup_positions_upcoming'];
                $completed = $cleanup['Cleanup']['cleanup_positions_completed'];
                $total = $upcoming + $completed;
                $this->set('desc_for_layout', __("Total assigned: %s, upcoming: %s, completed: %s", $total, $upcoming, $completed));
                $this->set('cleaners', $this->CleanupPosition->getCleaners($this->params['named']['cleanup']));
            } else {
                throw new NotFoundExeption();
            }
        }
    }

}
