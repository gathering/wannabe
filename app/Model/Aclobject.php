<?php
class Aclobject extends AppModel {
    public $name = 'Aclobject';

    public function beforeFind($queryData) {
        if(isset(WB::$event->reference))
            $queryData['conditions']['Aclobject.path LIKE'] = '/'.WB::$event->reference.'/%';
        return $queryData;
    }

	public function findAllForUserEvent($user, $event) {

		$crewIDs = array('0');
		$userRoles = array();
		foreach($user['Crew'] as $crew) {
			$crewIDs[] = $crew['id'];
			$userRoles[] = $crew['CrewsUser']['leader'];
			/*if($crew['crew_id'] > 0) {
				$crewIDs = array_merge($crewIDs, $this->getRecursiveCrewIDs($crew['crew_id']));
            }*/
		}
		if(empty($userRoles)) {
			$userRoles[] = -1;
		}

		$usedACLIDs = array();
		$aclobjectsTmp = $this->query("SELECT id FROM wb4_aclobjects WHERE path LIKE '/{$event->reference}/%'");
		foreach($aclobjectsTmp as $t) {
			$usedACLIDs[] = $t['wb4_aclobjects']['id'];
		}

		//Load ACLs for crew
		$crewACLs = $this->query("SELECT c.*, a.path FROM wb4_aclobjects_crews c, wb4_aclobjects a
					WHERE c.crew_id IN (".implode(",", $crewIDs).") AND c.aclobject_id IN (".implode(",", $usedACLIDs).") AND a.id = c.aclobject_id");

		//Load ACLs for user
		$userACLs = $this->query("SELECT c.*, a.path FROM wb4_aclobjects_users c, wb4_aclobjects a
					WHERE c.user_id = {$user['User']['id']} AND c.aclobject_id IN (".implode(",", $usedACLIDs).") AND a.id = c.aclobject_id");

		//Load ACLs for roles
		$roleACLs =  $this->query("SELECT c.*, a.path FROM wb4_aclobjects_roles c, wb4_aclobjects a
					WHERE c.role <= ".max($userRoles)." AND c.aclobject_id IN (".implode(",", $usedACLIDs).") AND a.id = c.aclobject_id");


		//Merge data into one acl object
		$data = array();
		foreach($crewACLs as $crew) {
			$row = $crew['c'];
			$row['path'] = $crew['a']['path'];
			$data[] = $row;
		}

		foreach($userACLs as $user) {
			$row = $user['c'];
			$row['path'] = $user['a']['path'];
			$data[] = $row;
		}

		foreach($roleACLs as $role) {
			$row = $role['c'];
			$row['path'] = $role['a']['path'];
			$data[] = $row;
		}

		return $data;
	}

	/**
	 * Load all crew IDs needed to get ACLS for(from)
	 */
	private function getRecursiveCrewIDs($cid) {
		$data = array();
		$tmp = $this->query("SELECT id, crew_id FROM wb4_crews WHERE id='{$cid}'");
		foreach($tmp as $t) {
			$t = $t['wb4_crews'];
			$data[] = $t['id'];
			if($t['crew_id'] > 0) {
				$data = array_merge($data, $this->getRecursiveCrewIDs($t['crew_id']));
			}
		}
		return $data;
	}

	/**
	 * Delete all the things!
	 * Delete ACL Object + users and crews (could try hasmany with strange primary keys and multiple )
	 */
	public function deleteRecords($aclobject_id)
	{
		$queries = array(
			"DELETE FROM wb4_aclobjects WHERE id=$aclobject_id",
			"DELETE FROM wb4_aclobjects_users WHERE aclobject_id=$aclobject_id",
			"DELETE FROM wb4_aclobjects_crews WHERE aclobject_id=$aclobject_id",
			"DELETE FROM wb4_aclobjects_roles WHERE aclobject_id=$aclobject_id");

		foreach ($queries as $query)
			$this->query($query);
	}
}
