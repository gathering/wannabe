<?php
/**
 * IrcChannelKey Model
 *
 */
class AccreditationAccess extends AppModel {
    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'accreditationaccess';

    /**
     * Validation rules
     *
     * @var array
     */
    public function beforeValidate() {
        $this->validate = array(
            'accreditation_id' => array(
                'notempty' => array(
                    'rule' => array('notBlank'),
                    'message' => __("Cannot be empty")
                ),
                'numeric' => array(
                    'rule' => array('numeric'),
                    'message' => __("Must be a number")
                ),
            ),
            'accreditation_group_id' => array(
                'notempty' => array(
                    'rule' => array('notBlank'),
                    'message' => __("Cannot be empty")
                ),
                'numeric' => array(
                    'rule' => array('numeric'),
                    'message' => __("Must be a number")
                ),
            ),
        );
     }

    public function deleteGroupFromAccreditation($id, $group_id) {
        $db = $this->getDataSource();
        return !$db->query("DELETE FROM {$db->fullTableName('accreditation_accesses')} WHERE accreditation_id={$id} AND accreditation_group_id={$group_id}");
    }

    public function getGroupAccess($user_id, $event_id) {
        $db = $this->getDataSource();
        return $db->query("SELECT id, event_id, name

                           FROM
                                {$db->fullTableName('accreditation_groups')} Groups,
                                {$db->fullTableName('accreditation_group_members')} Members
                           WHERE
                                Groups.id
                                =
                                Members.accreditation_group_id
                           AND
                                Members.user_id
                                =
                                '{$user_id}'
                           AND
                                event_id
                                =
                                '{$event_id}'");
    }

    public function hasAccessToGroup($user_id, $group_id) {
        $db = $this->getDataSource();

        return $db->query("SELECT * FROM
                                {$db->fullTableName('accreditation_group_members')}
                           WHERE
                                accreditation_group_id
                                =
                                '$group_id'
                           AND
                                user_id
                                =
                                '$user_id'");
    }
}

?>
