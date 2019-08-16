<?php

class TimesController extends CleanupAppController {

    public function index() {
        $my_position = $this->CleanupPosition->getPositionForUser($this->Wannabe->user['User']['id']);
        $my_crews = $this->Wannabe->user['Crew'];
        $related_positions = array();
        $cleanup_positions = $this->CleanupPosition->find('all', array(
                'conditions' => array(
                    'CleanupPosition.cleanup_id' => $my_position['CleanupPosition']['cleanup_id'],
                )
            )
        );

        foreach ($my_crews as $crew) {
            foreach ($this->User->getMembers($crew['id']) as $user) {
                if ($user['User']['id'] == $this->Wannabe->user['User']['id']) continue;

                $position = $this->CleanupPosition->getPositionForUser($user['User']['id']);
                if (!empty($position)) {
                    $position['Crew'] = $crew;
                    array_push($related_positions, $position);
                }
            }
        }

        $this->set('my_position', $my_position);
        $this->set('related_positions', $related_positions);
        $this->set('title_for_layout', __('Cleanup times'));
    }

}
