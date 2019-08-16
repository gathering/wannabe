<?php
/**
 * UserTerm Model
 *
 */
class UserTerm extends AppModel {
/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'user_id';

    public function acceptTerms($user_id, $terms_id) {
        $db = $this->getDataSource();
        $terms = $this->loadTerms($user_id, $terms_id);
        if (is_array($terms) && !empty($terms)) {
            $this->query("UPDATE {$db->fullTableName($this)} SET accepted = CURRENT_TIMESTAMP WHERE user_id = {$user_id} and terms_id = {$terms_id}");
        } else {
            $this->query("INSERT INTO {$db->fullTableName($this)} (user_id, terms_id, accepted, event_id) VALUES ({$user_id}, {$terms_id}, CURRENT_TIMESTAMP, ".WB::$event->id.")");
        }
        return true;
    }
    public function loadEventTerms($user_id) {
        $term = $this->find('first', array(
            'conditions' => array(
                'UserTerm.user_id' => $user_id,
                'UserTerm.event_id' => WB::$event->id
            )
        ));
        return $term;
    }
    public function loadTerms($user_id, $terms_id) {
        $term = $this->find('first', array(
            'conditions' => array(
                'UserTerm.user_id' => $user_id,
                'UserTerm.terms_id' => $terms_id
            )
        ));
        return $term;
    }
}
