<?php
class Carplate extends AppModel
{

	public $primaryKey = 'user_id';

	/*

	var $validate = array(
		'carplate' => array(
			'rule' => array('checkDuplicates', 1),
			'message' => 'Carplate exists'
		)
	);

	function checkDuplicates($check, $limit)
	{
		$count_submiteed_carplate = $this->find('count', array('conditions' => $check, 'recursive' => -1));
		return $count_submiteed_carplate < $limit;
	}
	*/

	public function getCarplates()
	{
		$db = $this->getDataSource();

		$query = "SELECT
			Carplate.user_id,
			Carplate.carplate,
			Crew.name,
			User.id,
			User.nickname,
			User.realname,
			User.sexe,
			User.username
		FROM
			{$db->fullTableName('carplates')} Carplate
		JOIN
			{$db->fullTableName('users')} User
		ON
			User.id = Carplate.user_id
		LEFT JOIN
			(
				{$db->fullTableName('crews_users')} Membership
				CROSS JOIN
				{$db->fullTableName('crews')} Crew
			)
		ON
			Membership.user_id = User.id
		AND
			Crew.id = Membership.crew_id
		WHERE Carplate.carplate != ''
		AND Crew.event_id = '".WB::$event->id."'
		GROUP BY user_id, carplate";

		return $this->query($query);
	}


}
