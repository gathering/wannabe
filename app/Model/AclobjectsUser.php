<?php

class AclobjectsUser extends AppModel {

	var $validate = array(
		'user_id' => array(
			'rule' => array('checkDuplicates', 1),
			'message' => 'User already exists in this path'
		)
	);

	function checkDuplicates($check, $limit) {
		$db = $this->getDataSource();
		$user_id = $this->data['AclobjectsUser']['user_id'];
		$acl_id = $this->data['AclobjectsUser']['aclobject_id'];

		$query = "SELECT
			COUNT(*) as count
		FROM
			{$db->fullTableName('aclobjects_users')} AclobjectsUser
		WHERE
			AclobjectsUser.user_id = $user_id AND
			AclobjectsUser.aclobject_id = $acl_id";

		$count = $this->query($query);

		return $count[0][0]['count'] < $limit;
	}
}
