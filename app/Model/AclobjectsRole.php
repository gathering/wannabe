<?php

class AclobjectsRole extends AppModel {

	public function getRoles() {
		$db = $this->getDataSource();

		$query = "SELECT
			Role.role,
			Role.read,
			Role.write,
			Role.manage,
			Role.superuser,
			Role.aclobject_id,
			ACLObject.path
		FROM
			{$db->fullTableName('aclobjects_roles')} Role
		JOIN
			{$db->fullTableName('aclobjects')} ACLObject
		ON
			Role.aclobject_id = ACLObject.id
        WHERE
            ACLObject.path LIKE '/".WB::$event->reference."/%'
		ORDER BY Role.role, ACLObject.path ASC";

		return $this->query($query);
	}

}
