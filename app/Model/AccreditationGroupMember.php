<?php
/**
 * IrcChannelKeyCrew Model
 *
 */
class AccreditationGroupMember extends AppModel {

    public function beforeValidate() {
        $this->validate = array(
            'user_id' => array(
                'notempty' => array(
                    'rule' => array('notBlank'),
                    'message' => __("Cannot be empty")
                ),
                'exists' => array(
                    'rule' => array('userExists'),
                    'message' => __("Must be a valid user id")
                ),
                'numeric' => array(
                    'rule' => array('numeric'),
                    'message' => __("Must be a valid user id")
                )
            ),
        );
    }

    public function userExists($check) {
        $db = $this->getDataSource();
        return $this->query("SELECT id FROM {$db->fullTableName('users')} WHERE id='{$check['user_id']}'");
    }

    /**
     * Delete a crew from a channel
     *
     */
    public function deleteMember($group_id, $member_id) {
        $db = $this->getDataSource();
        return !$this->query("DELETE FROM {$db->fullTableName(accreditation_group_members)} where accreditation_group_id={$group_id} AND user_id={$member_id}");
    }
}

?>
