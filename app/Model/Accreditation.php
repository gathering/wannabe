<?php
/**
 * Accredation
 *
 */
class Accreditation extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'id';

    public function beforeValidate() {

        $this->validate = array(
            'company_name' => array(
                'notempty' => array(
                    'rule' => array('notBlank'),
                    'message' => __("Cannot be empty"),
                ),
            ),
            'realname' => array(
                'notempty' => array(
                    'rule' => array('notBlank'),
                    'message' => __("Cannot be empty"),
                ),
            ),
            'email' => array(
                'notempty' => array(
                    'rule' => array('notBlank'),
                    'message' => __("Cannot be empty"),
                ),
                'email' => array(
                    'rule' => array('email'),
                    'message' => __("Must be a valid e-mail"),
                ),
            ),
            'phonenumber' => array(
                'notempty' => array(
                    'rule' => array('notBlank'),
                    'message' => __("Cannot be empty"),
                ),
                'phone' => array(
                    'rule' => array('phone', '/^\+\d{1,3}\d{6,14}$/', 'all'),
                    'message' => __("Must be a valid phone number. Example: +4712345678"),
                ),
            ),
            'numpersons' => array(
                'notempty' => array(
                    'rule' => array('notBlank'),
                    'message' => __("Cannot be empty"),
                ),
                'numeric' => array(
                    'rule' => array('numeric'),
                    'message' => __("Must be a number"),
                ),
                'minimum' => array(
                    'rule' => array('atLeastOne'),
                    'message' => __("Must be at least one person"),
                ),
            ),
            'arrivaldate' => array(
                'notempty' => array(
                    'rule' => array('notBlank'),
                    'message' => __("Cannot be empty"),
                ),
                'date' => array(
                    'rule' => array('date', 'ymd'),
                    'message' => __("Must be a valid date in the DD-MM-YYYY format"),
                ),
            ),
            'departuredate' => array(
                'notempty' => array(
                    'rule' => array('notBlank'),
                    'message' => __("Cannot be empty"),
                ),
                'date' => array(
                    'rule' => array('date', 'ymd'),
                    'message' => __("Must be a valid date in the DD-MM-YYYY format"),
                ),
            ),
            'badge_id' => array(
                'notempty' => array(
                    'rule' => array('notBlank'),
                    'message' => __("Cannot be empty"),
                ),
            ),
        );
    }

    public function atLeastOne($check) {
        return $check['numpersons']['minimum'] > 0;
    }

    public function getAccessGroupsWithNames($accreditation_id, $event_id) {
        $db = $this->getDataSource();

        return $this->query(
                "SELECT
                Access.accreditation_id,
                Access.accreditation_group_id,
                Groups.name
                FROM
                {$db->fullTableName('accreditation_accesses')} Access,
                {$db->fullTableName('accreditation_groups')} Groups
                WHERE
                Access.accreditation_group_id
                =
                Groups.id
                AND
                Groups.event_id
                =
                '{$event_id}'
                AND
                Access.accreditation_id
                =
                '{$accreditation_id}'"
        );
    }

    public function getAccreditationsForGroup($group_id) {
        $db = $this->getDataSource();

        $accreditation_ids = $db->query("
                SELECT
                    Access.accreditation_id
                FROM
                    {$db->fullTableName('accreditation_accesses')} Access
                WHERE
                    Access.accreditation_group_id
                =
                    {$group_id}");

        $ids = array();

        foreach($accreditation_ids as $id) {
            array_push($ids, $id['Access']['accreditation_id']);
        }

        if(count($ids) == 0) return array();

        return $db->query("
                SELECT
                    *
                FROM
                    {$db->fullTableName('accreditations')}
                WHERE
                    {$db->fullTableName('accreditations')}.id
                IN
                    (" . join(',', $ids) . ")");
    }

    public function deleteAccreditation($id) {
        $db = $this->getDataSource();

        $db->query("DELETE FROM
                        {$db->fullTableName('accreditations')}
                    WHERE
                        {$db->fullTableName('accreditations')}.id
                    =
                        '{$id}'");
        $db->query("DELETE FROM
                        {$db->fullTableName('accreditation_accesses')}
                    WHERE
                        {$db->fullTableName('accreditation_accesses')}.accreditation_id
                    =
                        '{$id}'");
        return true;
    }

    public function acceptAccreditation($id) {
        $db = $this->getDataSource();

        $db->query("UPDATE
                        {$db->fullTableName('accreditations')}
                    SET
                        {$db->fullTableName('accreditations')}.accepted
                    =
                        2
                    WHERE
                        {$db->fullTableName('accreditations')}.id
                    =
                        '{$id}'");
    }

    public function declineAccreditation($id) {
        $db = $this->getDataSource();

        $db->query("UPDATE
                        {$db->fullTableName('accreditations')}
                    SET
                        {$db->fullTableName('accreditations')}.accepted
                    =
                        1
                    WHERE
                        {$db->fullTableName('accreditations')}.id
                    =
                        '{$id}'");
    }

    public function getPhoneFromAcceptedAccreditations($event_id) {

        $db = $this->getDataSource();

        $objects = $db->query("SELECT
                {$db->fullTableName('accreditations')}.phonenumber
            FROM
                {$db->fullTableName('accreditations')}
            WHERE
                {$db->fullTableName('accreditations')}.event_id = $event_id
            AND
                {$db->fullTableName('accreditations')}.accepted = 2
            ");

        $numbers = array();
        foreach($objects as $number)
            array_push($numbers, $number['wb4_accreditations']['phonenumber']);
        return $numbers;
    }

    public function getPhoneFromAcceptedAccreditationsWithSmsAlerts($event_id) {

        $db = $this->getDataSource();

        $objects = $db->query("SELECT
                {$db->fullTableName('accreditations')}.phonenumber
            FROM
                {$db->fullTableName('accreditations')}
            WHERE
                {$db->fullTableName('accreditations')}.event_id = $event_id
            AND
                {$db->fullTableName('accreditations')}.smsalert = 1
            AND
                {$db->fullTableName('accreditations')}.accepted = 2
            ");

        $numbers = array();
        foreach($objects as $number)
            array_push($numbers, $number['wb4_accreditations']['phonenumber']);
        return $numbers;
    }
}

?>
