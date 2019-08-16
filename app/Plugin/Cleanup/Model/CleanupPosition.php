<?php

class CleanupPosition extends CleanupAppModel {

    var $belongsTo = array(
        'Cleanup' => array(
            'className' => 'Cleanup.Cleanup',
            'foreignKey' => 'cleanup_id',
            'counterCache' => array(
                'cleanup_positions_upcoming' => array('CleanupPosition.completed' => 0),
                'cleanup_positions_completed' => array('CleanupPosition.completed' => 1)
            )
        ),
        'User'
    );

    public function getPositionForUser($user_id) {
        return $this->find('first', array('conditions' => array('Cleanup.event_id' => WB::$event->id, 'CleanupPosition.user_id' => $user_id)));
    }

    public function removePositionForUser($user_id) {
        $cleanup =  $this->find('first', array('conditions' => array('Cleanup.event_id' => WB::$event->id, 'CleanupPosition.user_id' => $user_id)));
        if(!empty($cleanup)) {
            return $this->delete($cleanup['CleanupPosition']['id']);
        }
        return false;
    }

    public function getCleaners($cleanup_id) {
        return $this->find('all', array('conditions' => array('Cleanup.event_id' => WB::$event->id, 'CleanupPosition.cleanup_id' => $cleanup_id)));
    }

    public function getNumberOfCleaners($cleanup_id) {
        return $this->find('count', array('conditions' => array('Cleanup.event_id' => WB::$event->id, 'CleanupPosition.cleanup_id' => $cleanup_id)));
    }

    public function getCrewSummary() {
        return $this->find();
    }

}
