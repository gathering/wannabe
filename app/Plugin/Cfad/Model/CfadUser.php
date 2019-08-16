<?php
class CfadUser extends CfadAppModel {
	public function getMembers($crew_id, $date) {
        $db = $this->getDataSource();
        $members = $this->query("
            SELECT
                User.id,
                User.username,
                User.address,
                User.postcode,
                User.town,
                User.countrycode,
                User.nickname,
                User.realname,
                User.sexe,
                User.image,
                User.birth,
                User.email,
                Crew.id,
                Crew.crew_id,
                Crew.event_id,
                Crew.name,
                CfadUser.id,
                CfadUser.crew_id,
                CfadUser.assigned,
                CfadUser.date
            FROM
                {$db->fullTableName('users')} User,
                {$db->fullTableName('cfad_users')} CfadUser,
                {$db->fullTableName('crews')} Crew
            WHERE
                CfadUser.crew_id='{$crew_id}'
                AND CfadUser.date='{$date}'
                AND User.id=CfadUser.user_id
                AND NOT User.deleted
                AND Crew.id=CfadUser.crew_id
                AND NOT Crew.deleted
            ORDER BY
                User.realname ASC"
        );
        foreach ( $members as & $result ) {
            // Userphone
            $result['Userphone'] = array();

            $userphones = $this->query("SELECT * FROM wb4_userphones Userphone WHERE user_id='".$result['User']['id']."'");
            if($userphones && count($userphones)) foreach($userphones as $index => $userphone) {
                $result['Userphone'][$index] = $userphone['Userphone'];
            }
            // Userim
            $result['Userim'] = array();

            $userims = $this->query("SELECT * FROM wb4_userims Userim WHERE user_id='".$result['User']['id']."'");
            if($userims && count($userims)) foreach($userims as $index => $userim) {
                $result['Userim'][$index] = $userim['Userim'];
            }
        }

		App::import('Model', 'User');
		$userModel = new User();

        $members = $userModel->afterFind($members);

		return $members;
	}

	public function getAllMembers() {
        $db = $this->getDataSource();
        $members = $this->query("
            SELECT
                User.id,
                User.username,
                User.address,
                User.postcode,
                User.town,
                User.countrycode,
                User.nickname,
                User.realname,
                User.sexe,
                User.image,
                User.birth,
                User.email,
                Crew.id,
                Crew.crew_id,
                Crew.event_id,
                Crew.name,
                CfadUser.id,
                CfadUser.crew_id,
                CfadUser.assigned,
                CfadUser.date
            FROM
                {$db->fullTableName('users')} User,
                {$db->fullTableName('cfad_users')} CfadUser,
                {$db->fullTableName('crews')} Crew
            WHERE
                User.id=CfadUser.user_id
                AND NOT User.deleted
                AND Crew.id=CfadUser.crew_id
                AND NOT Crew.deleted
                AND Crew.event_id=".WB::$event->id."
            ORDER BY
                CfadUser.date ASC,
                Crew.name ASC,
                User.realname ASC"
        );

        foreach ( $members as & $result ) {
            // Userphone
            $result['Userphone'] = array();

            $userphones = $this->query("SELECT * FROM wb4_userphones Userphone WHERE user_id='".$result['User']['id']."'");
            if($userphones && count($userphones)) foreach($userphones as $index => $userphone) {
                $result['Userphone'][$index] = $userphone['Userphone'];
            }
            // Userim
            $result['Userim'] = array();

            $userims = $this->query("SELECT * FROM wb4_userims Userim WHERE user_id='".$result['User']['id']."'");
            if($userims && count($userims)) foreach($userims as $index => $userim) {
                $result['Userim'][$index] = $userim['Userim'];
            }
        }

		App::import('Model', 'User');
		$userModel = new User();

        $members = $userModel->afterFind($members);

		return $members;
	}
}
