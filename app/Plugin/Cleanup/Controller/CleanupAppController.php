<?php

App::uses('AppController', 'Controller');

class CleanupAppController extends AppController {

    public $uses = array('User', 'Crew', 'Cleanup.Cleanup', 'Cleanup.CleanupPosition', 'Cleanup.CleanupExemptCrew',);

    public function getCrew($crew_id) {
        $exempted = $this->CleanupExemptCrew->getExemptedCrew($crew_id);
        if(empty($exempted)) {
            $crew = $this->Crew->find('first', array(
                'conditions' => array(
                    'Crew.id' => $crew_id,
                    'Crew.event_id' => $this->Wannabe->event->id
                )
            ));
            if(!empty($crew))
                return $crew;
        }
        return false;
    }
    public function getMembers($crew_id) {
        $members = $this->User->getMembers($crew_id);
        foreach ($members as &$member) {
            $member = array_merge($member, $this->CleanupPosition->getPositionForUser($member['User']['id']));
        }
        usort($members, array($this, 'memberSort'));
        return $members;
    }

    public function memberSort($a, $b) {
        $aComp = isset($a['CleanupPosition']['completed']);
        $bComp = isset($b['CleanupPosition']['completed']);
        if(!$aComp && !$bComp)
            return 0;
        if($aComp && !$bComp)
            return 1;
        if(!$aComp && $bComp)
            return -1;
        $aComp = $a['CleanupPosition']['completed'];
        $bComp = $b['CleanupPosition']['completed'];
        if($aComp && !$bComp)
            return 1;
        if(!$aComp && $bComp)
            return -1;
        return ($a['Cleanup']['unixtime'] < $b['Cleanup']['unixtime']) ? -1 : 1;
    }

    public function getCrewList() {
        $crews = $this->Crew->getAllCrews(true, 0, false);
        $exempted_crews = $this->CleanupExemptCrew->find('list', array(
            'joins' => array(
                array(
                    'table' => 'crews',
                    'alias' => 'Crew',
                    'type' => 'INNER',
                    'conditions' => array(
                        'CleanupExemptCrew.crew_id = Crew.id'
                    )
                )
            ),
            'conditions' => array(
                'CleanupExemptCrew.event_id' => $this->Wannabe->event->id
            ),
            'fields' => array(
                'Crew.id',
                'Crew.name'
            )
        ));
        return array_diff($crews, $exempted_crews);
    }

}
