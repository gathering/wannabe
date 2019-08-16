<?php

class Cleanup extends CleanupAppModel {

    var $hasMany = array(
        'CleanupPosition' => array(
            'className' => 'Cleanup.CleanupPosition',
            'dependent' => true,
        )
    );
    public $displayField = 'time';

    public $virtualFields = array(
        'unixtime' => 'UNIX_TIMESTAMP(Cleanup.time)',
        'cleanup_positions_total' => '(Cleanup.cleanup_positions_completed + Cleanup.cleanup_positions_upcoming)'
    );

    public function getCleanupsForEvent() {
        return $this->find('all', array(
            'conditions' => array(
                'Cleanup.event_id' => WB::$event->id
            ),
            'order' => array(
                'Cleanup.time ASC'
            )
        ));
    }

    public function getCleanup($cleanup_id) {
        return $this->find('first', array(
            'conditions' => array(
                'Cleanup.event_id' => WB::$event->id,
                'Cleanup.id' => $cleanup_id
            )
        ));
    }

    public function isFull($cleanup_id) {
        $cleanup =  $this->find('first', array(
            'conditions' => array(
                'Cleanup.event_id' => WB::$event->id,
                'Cleanup.id' => $cleanup_id
            )
        ));
        if(!empty($cleanup)) {
            if($cleanup['Cleanup']['maximum'] <= $cleanup['Cleanup']['cleanup_positions_total']) {
                return true;
            }
            return false;
        }
        return true;
    }

}
