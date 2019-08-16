<?php
/**
 * IrcChannelKey Model
 *
 */
class AccreditationGroup extends AppModel {
    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';

    public $hasMany = array(
        'AccreditationGroupMember' => array(
            'className'     => 'AccreditationGroupMember',
            'foreignKey'    => 'accreditation_group_id',
            'dependent'     => true
        )
    );

    /**
     * Validation rules
     *
     * @var array
     */
    public function beforeValidate() {
        $this->validate = array(
            'event_id' => array(
                'notempty' => array(
                    'rule' => array('notBlank'),
                    'message' => __("Cannot be empty")
                ),
            ),
            'name' => array(
                'notempty' => array(
                    'rule' => array('notBlank'),
                    'message' => __("Cannot be empty")
                ),
                'maxlength' => array(
                    'rule' => array('maxlength', 50),
                    'message' => __("Max length is 50")
                ),
                'unique' => array(
                    'rule' => array('isEventUnique'),
                    'message' => __('A user group with that name already exists for this event.')
                )
            ),
        );
     }

    public function deleteGroup($id, $event_id) {

        $db = $this->getDataSource();
        $db->query("DELETE FROM
                        {$db->fullTableName('accreditation_groups')}
                    WHERE
                        {$db->fullTableName('accreditation_groups')}.id
                    =
                        '{$id}'
                    AND
                        {$db->fullTableName('accreditation_groups')}.event_id
                    =
                        '{$event_id}'
                   ");
        $db->query("DELETE FROM
                        {$db->fullTableName('accreditation_accesses')}
                    WHERE
                        {$db->fullTableName('accreditation_accesses')}.accreditation_group_id
                    =
                        '{$id}'
                   ");
        $db->query("DELETE FROM
                        {$db->fullTableName('accreditation_group_members')}
                    WHERE
                        {$db->fullTableName('accreditation_group_members')}.accreditation_group_id
                    =
                        '{$id}'
                    ");
        return true;
    }
}

?>
