<?php

class CleanupExemptCrew extends CleanupAppModel {



    var $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'exempted_by'
        ),
        'Crew',
    );

    public function getExemptedCrewsForEvent() {
        return $this->find('all', array('conditions' => array('CleanupExemptCrew.event_id' => WB::$event->id)));
    }

    public function getExemptedCrew($crew_id) {
        if($crew_id != null && is_numeric($crew_id)) {
            return $this->find('first', array('conditions' => array('CleanupExemptCrew.event_id' => WB::$event->id, 'CleanupExemptCrew.crew_id' => $crew_id)));
        }
        return false;
    }

    public function removeExemptedCrew($crew_id) {
        if($crew_id != null && is_numeric($crew_id)) {
            $exempted = $this->find('first', array('conditions' => array('CleanupExemptCrew.event_id' => WB::$event->id, 'CleanupExemptCrew.crew_id' => $crew_id)));
            if(!empty($exempted)) {
                return $this->delete($exempted['CleanupExemptCrew']['id']);
            }
        }
        return false;
    }

}
