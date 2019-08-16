<?php

class AclobjectsCrew extends AppModel {

	var $validate = array(
		'crew_id' => array(
			'rule' => array('checkDuplicates', 1),
			'message' => 'Crew already exists in this path'
		)
	);

	function checkDuplicates($check, $limit) {
		$db = $this->getDataSource();
		$crew_id = $this->data['AclobjectsCrew']['crew_id'];
		$acl_id = $this->data['AclobjectsCrew']['aclobject_id'];

		$query = "SELECT
			COUNT(*) as count
		FROM
			{$db->fullTableName('aclobjects_crews')} AclobjectsCrew
		WHERE
			AclobjectsCrew.crew_id = $crew_id AND
			AclobjectsCrew.aclobject_id = $acl_id";

		$count = $this->query($query);

		return $count[0][0]['count'] < $limit;
	}

}
