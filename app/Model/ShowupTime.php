<?php
class ShowupTime extends AppModel {

    public $validate = array(
        'date' => array(
            'rule' => 'notBlank'
        ),
        'hour' => array(
            'rule' => 'notBlank'
        )
    );

	public function getAllShowups() {
        $db = $this->getDataSource();
        $members = $this->query("
            SELECT
                User.id,
                User.nickname,
                User.realname,
                Crew.id,
                Crew.name,
                ShowupTime.date,
                ShowupTime.hour,
                ShowupTime.approved
            FROM
                {$db->fullTableName('showup_times')} ShowupTime
            JOIN
                {$db->fullTableName('users')} User
            ON
                User.id = ShowupTime.user_id
            LEFT JOIN (
                {$db->fullTableName('crews_users')} CrewsUser
                CROSS JOIN
                    {$db->fullTableName('crews')} Crew
            )
            ON
                CrewsUser.user_id = User.id
                AND Crew.id = CrewsUser.crew_id
            WHERE
                Crew.event_id = '".WB::$event->id."'
                AND ShowupTime.event_id = '".WB::$event->id."'
                AND ShowupTime.approved != 1
            GROUP BY User.id
            ORDER BY
                ShowupTime.date ASC,
                ShowupTime.hour ASC,
                User.realname ASC"
        );
		return $members;
	}

}
?>
