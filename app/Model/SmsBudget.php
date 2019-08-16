<?php

class SmsBudget extends AppModel {

    var $belongsTo = array('User');

    public function getSmsLimitForUser($userid) {
        if($userid != null && is_numeric($userid)) {
            $budget = $this->find('first', array('conditions' => array('SmsBudget.event_id' => WB::$event->id, 'SmsBudget.user_id' => $userid)));
            return $budget['SmsBudget']['sms_limit'];
        }
    }

    public function getBudgetForUser($userid) {
        if($userid != null && is_numeric($userid)) {
            return $this->find('first', array('conditions' => array('SmsBudget.event_id' => WB::$event->id, 'SmsBudget.user_id' => $userid)));
        }
    }

    public function getBudgetsForEvent() {
        return $this->find('all', array('conditions' => array('SmsBudget.event_id' => WB::$event->id)));
    }
}
