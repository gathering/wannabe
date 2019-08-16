<?php

class CleanupController extends CleanupAppController {

    public $uses = array('User', 'Crew', 'Cleanup.Cleanup', 'Cleanup.CleanupPosition');

    public function index() {
        $crews = $this->getCrewList();
        $member_count = 0;
        foreach($crews as $id => $name) {
            $member_count += $this->User->getMembers($id, true);
        }
        $this->set('member_count', $member_count);
        $this->set('cleanup_count', $this->CleanupPosition->find('count', array(
            'conditions' => array(
                'Cleanup.event_id' => $this->Wannabe->event->id
            )
        )));
        $this->set('cleanup_completed_count', $this->CleanupPosition->find('count', array(
            'conditions' => array(
                'Cleanup.event_id' => $this->Wannabe->event->id,
                'CleanupPosition.completed' => 1
            )
        )));
        $this->set('cleanups', $this->Cleanup->getCleanupsForEvent());
        $this->set('crews', $crews);
        $this->set('title_for_layout', __('Cleanup registration'));
    }

}
