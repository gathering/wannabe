<?php

class Needs extends AppModel {

	public $primaryKey = 'user_id';

	public function afterSave(){
       $user_id = $this->data['Needs']['user_id'];
       $this->query("UPDATE  `wannabe`.`wb4_needs` SET  `updated_on` =  NOW() WHERE  `wb4_needs`.`user_id` = $user_id;");
    }

	
	public function getNeeds($need = null) {
		if ($need != null) {
			$query = "";
			$db = $this->getDataSource();
			
			switch($need){
				case "nutritionalneeds":
				$query = "
					SELECT 
						Crew.id,
						Crew.name,
						Needs.nutritionalneeds,
						Needs.allergies,
						User.id,
						User.nickname,
						User.realname,
						User.sexe,
						User.username,
						Needs.updated_on
					FROM
						{$db->fullTableName('needs')} Needs
					JOIN
						{$db->fullTableName('users')} User
					ON
						User.id = Needs.user_id
					LEFT JOIN (
						{$db->fullTableName('crews_users')} Membership
						CROSS JOIN
							{$db->fullTableName('crews')} Crew
					)
					ON
						Membership.user_id = User.id
						AND Crew.id = Membership.crew_id
					WHERE
						Crew.event_id = '".WB::$event->id."'
						AND (Needs.nutritionalneeds != '' 
						OR Needs.allergies != '')
					GROUP BY User.id
					ORDER BY Needs.updated_on DESC, User.realname	
					";
				break;
				
				case "medicalneeds":
				$query = "
					SELECT 
						Crew.id,
						Crew.name,
						Needs.medicalneeds,
						User.id,
						User.nickname,
						User.realname,
						User.sexe,
						User.username,
						Needs.updated_on
					FROM
						{$db->fullTableName('needs')} Needs
					JOIN
						{$db->fullTableName('users')} User
					ON
						User.id = Needs.user_id
					LEFT JOIN (
						{$db->fullTableName('crews_users')} Membership
						CROSS JOIN
							{$db->fullTableName('crews')} Crew
					)
					ON
						Membership.user_id = User.id
						AND Crew.id = Membership.crew_id
					WHERE
						Crew.event_id = '".WB::$event->id."'
						AND Needs.medicalneeds != ''
					GROUP BY User.id
					ORDER BY Needs.updated_on DESC, User.realname
					";
				break;
			}

			return ($this->query($query));
		}
	}

	public function getNeedForUser($need = null, $user=0) {
		if ($need != null) {
			$query = "";
			$db = $this->getDataSource();
			
			switch($need){
				case "nutritionalneeds":
				$query = "
					SELECT 
						Crew.id,
						Crew.name,
						Needs.nutritionalneeds,
						Needs.allergies,
						User.id,
						User.nickname,
						User.realname,
						User.sexe,
						User.username
					FROM
						{$db->fullTableName('needs')} Needs
					JOIN
						{$db->fullTableName('users')} User
					ON
						User.id = Needs.user_id
					LEFT JOIN (
						{$db->fullTableName('crews_users')} Membership
						CROSS JOIN
							{$db->fullTableName('crews')} Crew
					)
					ON
						Membership.user_id = User.id
						AND Crew.id = Membership.crew_id
					WHERE
						User.id = ".$user."
						AND (Needs.nutritionalneeds != '' 
						OR Needs.allergies != '')
					GROUP BY User.id
				";
				break;
				
				case "medicalneeds":
				$query = "
					SELECT 
						Crew.id,
						Crew.name,
						Needs.medicalneeds,
						User.id,
						User.nickname,
						User.realname,
						User.sexe,
						User.username
					FROM
						{$db->fullTableName('needs')} Needs
					JOIN
						{$db->fullTableName('users')} User
					ON
						User.id = Needs.user_id
					LEFT JOIN (
						{$db->fullTableName('crews_users')} Membership
						CROSS JOIN
							{$db->fullTableName('crews')} Crew
					)
					ON
						Membership.user_id = User.id
						AND Crew.id = Membership.crew_id
					WHERE
						User.id = ".$user."
						AND Needs.medicalneeds != ''
					GROUP BY User.id
				";
				break;
			}

			return ($this->query($query));
		}
	}

}
