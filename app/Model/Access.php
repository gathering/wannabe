<?php

class Access extends AppModel
{
	var $useTable = false;

	public function getCrews($aclobject_id) {
		$db = $this->getDataSource();

		$query = "SELECT
			Crew.id,
			Crew.name,
			AclobjectsCrew.aclobject_id,
			AclobjectsCrew.read,
			AclobjectsCrew.write,
			AclobjectsCrew.manage,
			AclobjectsCrew.superuser
		FROM
			{$db->fullTableName('crews')} Crew,
			{$db->fullTableName('aclobjects_crews')} AclobjectsCrew
		WHERE
			AclobjectsCrew.aclobject_id = {$aclobject_id} AND
			Crew.id = AclobjectsCrew.crew_id";

		return $this->query($query);
	}

	public function getUsers($aclobject_id) {
		$db = $this->getDataSource();

		$query = "SELECT
			User.id,
			User.username,
			User.realname,
			AclobjectsUser.aclobject_id,
			AclobjectsUser.read,
			AclobjectsUser.write,
			AclobjectsUser.manage,
			AclobjectsUser.superuser
		FROM
			{$db->fullTableName('users')} User,
			{$db->fullTableName('aclobjects_users')} AclobjectsUser
		WHERE
			AclobjectsUser.aclobject_id = $aclobject_id AND
			User.id = AclobjectsUser.user_id";

		return $this->query($query);
	}

}
