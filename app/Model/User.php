<?php
class User extends AppModel {

	public $name = 'User';

	public $loadExtras = true;

	public $hasAndBelongsToMany = array(
		'Crew' => array(
			'className' => 'Crew'
		)
	);
	public $hasMany = array(
		'Userphone' => array(
			'className' => 'Userphone',
			'order' => 'Userphone.phonetype_id ASC',
			'dependent' => true
		),
		'Userim' => array(
			'className' => 'Userim',
			'order' => 'Userim.created DESC',
			'dependent' => true
		),
		'Userhistory' => array(
			'className' => 'Userhistory',
			'dependent' => false
		)
	);
    public $hasOne = array(
        'UserProfileHash' => array(
            'className' => 'UserProfileHash',
            'dependent' => true
        )
    );

	public function beforeValidate($options = []) {
		$this->validate = array(
			'username' => array(
				'username-rule-1' => array(
					'rule' => 'alphaNumeric',
					'message' => __("Username must be alphanumeric.")
				),
				'username-rule-2' => array(
					'rule' => 'isUnique',
					'message' => __("Username is already in use.")
				)
			),
			'newpassword1' => array(
				'rule' => array('minLength', '6'),
				'message' => __("Password must be 6 characters or more")
			),
			'newpassword2' => array(
				'rule' => array('identicalFieldValues', 'newpassword1'),
				'message' => __("Password do not match")
			),
			'realname' => array(
				'rule' => 'notBlank',
				'message' => __("Name cannot be empty")
			),
			'nickname' => array(
				'rule' => 'notBlank',
				'message' => __("Nick cannot be empty")
			),
			'town' => array(
				'rule' => 'notBlank',
				'message' => __("Town cannot be empty")
			),
			'countrycode' => array(
				'rule' => 'notBlank',
				'message' => __("County must be chosen")
			),
			'address' => array(
				'rule' => 'notBlank',
				'message' => __("Address cannot be empty")
			),
			'postcode' => array(
				'rule' => 'notBlank',
				'message' => __("Postcode cannot be empty")
			),
			'sexe' => array(
				'rule' => 'notBlank',
				'message' => __("Gender must be chosen")
			),
			'birth' => array(
				'rule' => 'notBlank',
				'message' => __("Birth must be chosen")
			),
		);
	}

	public function beforeFind($query) {
        if(isset(WB::$event->id)) {
            $this->hasAndBelongsToMany['Crew']['conditions'] = ' Crew.event_id='.(int)WB::$event->id;
        }
		return true;
	}

	public function afterFind($res, $primary = false) {
		$loadExtras = $this->loadExtras;
		foreach ( $res as & $result ) {
			// Calculate the age for the user.
			if(isset($result['User']) && is_array($result['User']) && isset($result['User']['birth'])) {
				$result['User']['age'] = $this->calculateAge($result['User']['birth']);
			}
			// prepare the User (i.e. check for MailUserprefs etc.)
			if($loadExtras) {
				$result = $this->prepareUser($result, WB::$event->id);
			}
		}
		if(!$loadExtras) {
			$this->loadExtras = true;
		}
		return $res;
	}
	public function afterSave($created, $options = []) {

	}

    public function updateLatestActivity($user_id) {
		$db = $this->getDataSource();
        return $this->query("UPDATE {$db->fullTableName($this)} SET lastactive = NOW() WHERE id={$user_id}");
    }

    public function getLatestActivity() {
        $this->loadExtras = false;
        $users = $this->find('all', array(
            'conditions' => array(
                'User.lastactive >' => date('Y-m-d H:i:s', strtotime("-10 minutes")),
                'User.id !=' => WB::$user['User']['id']
            ),
            'order' => 'User.lastactive DESC'
        ));
        foreach($users as $index => $user)
            if(!$this->isCrewForEvent($user, WB::$event->id))
                unset($users[$index]);
        return $users;
    }

	public function isCrewForEvent($user, $eventID) {
		foreach ($user['Crew'] as $crew) {
			if ($eventID == $crew['event_id']) {
				return true;
			}
		}

		return false;
	}

    public function getCfadForEvent($user_id, $event_id) {

        $db = $this->getDataSource();

        $user_id = $db->value($user_id);
        $event_id = $db->value($event_id);

        return $this->query( "
	        SELECT
	            cfad_users.id,
	            crews.name
	        FROM
	            {$db->fullTableName('cfad_users')} AS cfad_users
	        JOIN
	            {$db->fullTableName('crews')} AS crews ON cfad_users.crew_id = crews.id
	        WHERE
	            cfad_users.user_id = $user_id
	            AND crews.event_id = $event_id

	    ");

        return;
    }

	public function getMembers($crew_id, $count=false) {
        if($count) $count = 'count';
        else $count = '';
		$members = Cache::read(WB::$event->reference.'-crew-members-'.$crew_id.$count);
		if($members === false) {
            $db = $this->getDataSource();
            $query = "
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
					Team.id,
					Team.name,
					CrewsUser.crew_id,
					CrewsUser.team_id,
					CrewsUser.assigned,
					CrewsUser.title,
                    CrewsUser.leader ";
            if($count) $query = "SELECT COUNT(*) as count ";
			$members = $this->query($query . "
				FROM
					{$db->fullTableName($this)} User,
					{$db->fullTableName('crews_users')} CrewsUser,
					{$db->fullTableName('crews')} Crew,
					{$db->fullTablename('teams')} Team
				WHERE
					CrewsUser.crew_id='{$crew_id}'
					AND User.id=CrewsUser.user_id
					AND NOT User.deleted
					AND Crew.id=CrewsUser.crew_id
					AND NOT Crew.deleted
					AND Team.id=CrewsUser.team_id
				ORDER BY
					Team.id ASC,
					CrewsUser.leader DESC,
					CrewsUser.title ASC,
					User.realname ASC"
            );
            if(!$count) {
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
                $members = $this->afterFind($members);
            }

			Cache::write(WB::$event->reference.'-crew-members-'.$crew_id.$count, $members);
		}
        if($count) return $members[0][0]['count'];
		return $members;
	}

	public function getAllMembers($count=false) {
        $db = $this->getDataSource();
        $query = "
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
                Team.id,
                Team.name,
                CrewsUser.crew_id,
                CrewsUser.team_id,
                CrewsUser.assigned,
                CrewsUser.title,
                CrewsUser.leader ";
        if($count) $query = "SELECT COUNT(*) as count ";
        $members = $this->query($query . "
            FROM
                {$db->fullTableName($this)} User,
                {$db->fullTableName('crews_users')} CrewsUser,
                {$db->fullTableName('crews')} Crew,
                {$db->fullTablename('teams')} Team
            WHERE
                Crew.event_id = '".WB::$event->id."'
                AND User.id=CrewsUser.user_id
                AND NOT User.deleted
                AND Crew.id=CrewsUser.crew_id
                AND NOT Crew.deleted
                AND Team.id=CrewsUser.team_id
            GROUP BY User.id
            ORDER BY
                Team.id ASC,
                CrewsUser.leader DESC,
                CrewsUser.title ASC,
                User.realname ASC"
        );
        if(!$count) {
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
            $members = $this->afterFind($members);
        }
        if($count) return $members[0][0]['count'];
		return $members;
	}

	public function clearMemberCache($crew_id) {
		$members = Cache::read(WB::$event->reference.'-crew-members-'.$crew_id);
		if(is_array($members)) {
			Cache::delete(WB::$event->reference.'-crew-members-'.$crew_id);
		}
	}

	public function calculateAge($date) {
		$date = str_replace(' 00:00:00','',$date);
		list($year, $month, $day) = explode('-', $date);
		
		$year_diff = date('Y') - $year;
		$month_diff = date('m') - $month;
		$day_diff = date('d') - $day;

		if ( $month_diff < 0 || (($month_diff == 0) and ($day_diff < 0)) )
			$year_diff --;

		return($year_diff);
	}

	public function getTodaysBirthdays() {
		$sqlString = "
			SELECT
				User.id, User.sexe, User.nickname, User.realname, User.birth
			FROM
				wb4_users User, wb4_crews_users uc, wb4_crews Crew
			WHERE
				uc.user_id=User.id AND Crew.id=uc.crew_id AND Crew.event_id='".WB::$event->id."'
				AND DAY(birth)=DAY(NOW()) AND MONTH(birth)=MONTH(NOW())
			GROUP BY User.id
			";
		return $this->query($sqlString);
	}

	public function search($query, $crew_id=false, $assigned=false) {

        $db = $this->getDataSource();

        if (preg_match('/^(?:0047|\+47|47)?(\d{8})$/', $query, $matches)) {

			$sqlstring = "
				SELECT
					User.*
				FROM
					{$db->fullTableName($this)} User
				WHERE

					User.id IN (SELECT user_id FROM {$db->fullTableName('userphones')} WHERE number LIKE '%".$matches[1]."%')
				GROUP BY
					User.id
            ";
            return($this->query($sqlstring));
		}


		$s = addslashes($query);

		$where = 'AND (User.id='.(int)$query.' OR User.realname LIKE \'%'.$s.'%\' OR User.nickname LIKE \'%'.$s.'%\' OR User.town LIKE \'%'.$s.'%\' OR User.email LIKE \'%'.$s.'%\')';

		if($crew_id)
			$where .= 'AND Membership.crew_id='.(int)$crew_id;
		if($assigned)
			return($this->query("
				SELECT
					User.*,
					Membership.*
				FROM
					{$db->fullTableName($this)} User,
					{$db->fullTableName('crews_users')} Membership,
					{$db->fullTableName('crews')} Crew
				WHERE
					Membership.user_id=User.id
					AND Crew.id=Membership.crew_id
					AND Crew.event_id=".WB::$event->id." {$where}
				GROUP BY
					User.id
				ORDER BY
					User.realname ASC
			"));

        return($this->query("
            SELECT
                User.*,
                Membership.*,
                Crew.*
            FROM
                {$db->fullTableName($this)} User
            LEFT JOIN (
                {$db->fullTableName('crews_users')} Membership
            CROSS JOIN
                {$db->fullTableName('crews')} Crew
            )
            ON (
                Membership.user_id=User.id
                AND Crew.id=Membership.crew_id
                AND Crew.event_id=".WB::$event->id."
            )
            WHERE
                1
                {$where}
            GROUP BY
                User.id
            ORDER BY
                User.realname ASC
 		"));
	}
	/**
	 * Save the phonenumbers for a user.
	 */
	public function savePhoneNumbers($user_id, $phones) {
		$db = $this->getDataSource();
		$this->query("delete from {$db->fullTableName('userphones')} where user_id=".(int)$user_id);
		foreach ( $phones as $phone )
			if ( empty($phone['number']) == false )
				$this->query("insert into {$db->fullTableName('userphones')} (user_id,phonetype_id,number,created) values('".(int)$user_id."','".(int)$phone['phonetype_id']."','".addslashes($phone['number'])."',now())");
	}

	/**
	 * Save the IM-accounts for a user.
	 */
	public function saveImAccounts($user_id, $accounts) {
		$db = $this->getDataSource();
		$this->query("delete from {$db->fullTableName('userims')} where user_id=".(int)$user_id);
		foreach ( $accounts as $account )
			if ( empty($account['address']) == false )
				$this->query("insert into {$db->fullTableName('userims')} (user_id,improtocol_id,address,created) values('".(int)$user_id."','".(int)$account['improtocol_id']."','".addslashes($account['address'])."',now())");
	}
	function identicalFieldValues($field=array(), $compare_field=null) {
		foreach($field as $key => $value){
			$v1 = $value;
			$v2 = $this->data[$this->name][$compare_field];
			if($v1 !== $v2) {
				return FALSE;
			} else {
				continue;
			}
		}
		return TRUE;
	}
	public function prepareUser($user, $event_id) {
		if (isset($user['User']['id']) && is_numeric($user['User']['id']) && $user['User']['id'] > 0) {
             //Load ShowupTime
            App::import('Model', 'ShowupTime');
            $showupTimeModel = new ShowupTime();
            $showupTime = $showupTimeModel->find('first', array(
				'conditions' => array(
					'ShowupTime.user_id' => $user['User']['id'],
                    'ShowupTime.event_id' => WB::$event->id
                )
            ));
			if (is_array($showupTime) && !empty($showupTime))
               $user += $showupTime;

			// Load UserMailpref
			App::import('Model', 'UserMailpref');
			$mail = new UserMailpref();
			$mailprefs = $mail->find('all', array(
				'conditions' => array(
					'UserMailpref.user_id' => $user['User']['id'],
					'UserMailpref.event_id' => WB::$event->id
				)
			));
			App::import('Model', 'Mailinglist');
			$mailman = new Mailinglist();
			$optionals = $mailman->find('all', array(
				'conditions' => array(
					'Mailinglist.optional' => 1,
					'Mailinglist.event_id' => WB::$event->id
				)
			));
			$modified = false;
			foreach($optionals as $cur) {
				foreach($mailprefs as $pref) {
					if($pref['UserMailpref']['mailinglist_id'] == $cur['Mailinglist']['id'])
						continue 2;
				}
				$modified = true;
				$save['UserMailpref'] = array(
					'id' => 0,
					'user_id' => $user['User']['id'],
					'event_id' => WB::$event->id,
					'mailinglist_id' => $cur['Mailinglist']['id'],
					'subscribe' => 1
				);
				$mail->save($save);
			}
			if($modified) {
				$mailprefs = $mail->find('all', array(
					'conditions' => array(
						'UserMailpref.user_id' => $user['User']['id'],
						'UserMailpref.event_id' => WB::$event->id
					)
				));
			}
			if (is_array($mailprefs) && !empty($mailprefs)) {
                foreach($mailprefs as $index => $mailpref) {
                    $user['UserMailpref'][$index] = $mailpref['UserMailpref'];
                }
			}
            // Load privacy settings
            App::import('Model', 'UserPrivacy');
            $privacyModel = new UserPrivacy();
            $privacy = $privacyModel->find('first', array(
                'conditions' => array(
                    'UserPrivacy.user_id' => $user['User']['id']
                )
            ));
            if (is_array($privacy) && !empty($privacy)) {
                $user += $privacy;
            } else {
                $save['UserPrivacy'] = array(
                    'user_id' => $user['User']['id'],
                    'address' => 1,
                    'email' => 0,
                    'phone' => 1,
                    'birth' => 0,
                    'allow_crew' => 0
                );
                $privacyModel->save($save);
                $user += $save;
            }
            // Load picture approval
            App::import('Model', 'PictureApproval');
            $approvalModel = new PictureApproval();
            $picture = $approvalModel->find('first', array(
                'conditions' => array(
                    'PictureApproval.user_id' => $user['User']['id']
                )
            ));
            if (is_array($picture) && !empty($picture)) {
                $user += $picture;
            } else {
                $save['PictureApproval'] = array(
                    'user_id' => $user['User']['id'],
                    'approved' => 0
                );
                $approvalModel->save($save);
                $user += $save;
            }
            // Load tasks
            App::import('Model', 'Task');
            $taskModel = new Task();
            $tasks = $taskModel->getTasks();
            App::import('Model', 'UserTask');
            $userTaskModel = new UserTask();
            $userTasks = $userTaskModel->find('all', array(
                'conditions' => array(
                    'UserTask.user_id' => $user['User']['id'],
                    'UserTask.event_id' => WB::$event->id
                )
            ));
            if (is_array($tasks) && !empty($tasks)) {
                foreach($tasks as $index => $task) {
                    if (is_array($userTasks) && !empty($userTasks)) {
                        foreach($userTasks as $userTask) {
                            if($task['Task']['id'] == $userTask['UserTask']['task_id']) {
                                unset($tasks[$index]);
                            }
                        }
                    }
                }
            }
            if (is_array($tasks) && !empty($tasks)) {
                foreach($tasks as $task) {
                    $save['UserTask'] = array(
                        'user_id' => $user['User']['id'],
                        'task_id' => $task['Task']['id'],
                        'event_id' => WB::$event->id,
                        'completed' => 0
                    );
                    $userTaskModel->query('INSERT INTO wb4_user_tasks (user_id,task_id,event_id,completed) VALUES('.$user['User']['id'].','.$task['Task']['id'].','.WB::$event->id.',0)');
                    $userTasks[] = $save;
                }
            }
            if(is_array($userTasks) && !empty($userTasks)) {
                $user['UserTask'] = array();
                foreach($userTasks as $task) {
                    $user['UserTask'][] = $task['UserTask'];
                }
            }
            // Load terms
            App::import('Model', 'UserTerm');
            $termModel = new UserTerm();
            $user += $termModel->loadEventTerms($user['User']['id']);
		}
		return $user;
	}

    public function getUserHash($user) {
        App::import('Model', 'UserProfileHash');
        $hashModel = new UserProfileHash();
        return $hashModel->find('first', array(
            'conditions' => array(
                'user_id' => $user['User']['id']
            )
        ));
    }
    public function setUserHash($user) {
        App::import('Model', 'UserProfileHash');
        $hashModel = new UserProfileHash();
        $hash = md5($user['User']['id']*time());
        $save = array(
            'UserProfileHash' => array(
                'user_id' => $user['User']['id'],
                'hash' => $hash
            )
        );
        if($hashModel->save($save)) {
            return $hash;
        }
        return false;
    }

    public function getMembersWithApprovedPicture($crew_id){
        $members = $this->getMembers($crew_id);
        $return = array();
        foreach ($members as &$member) {
            if($member['PictureApproval']['approved'])
                $return[] = $member;
        }
        return $return;
    }

    public function correctPassword($user, $passwordGuess) {
        $existingPasswordHash = $user['User']['password'];

        if (
            // Modern password verification failed
            !password_verify($passwordGuess, $existingPasswordHash) and
            // Legacy md5 password verification failed
            $existingPasswordHash != md5($passwordGuess)
        ) {
            return false;
        }

        return true;
    }

    public function keepPasswordHashUpToDate($user, $passwordGuess) {
        if (!$this->correctPassword($user, $passwordGuess)) {
            return false;
        }

        // This works for both password_hash and legacy hashes, since
        // unrecognized hashes/variants returns true, triggering re-hash
        if (password_needs_rehash($user['User']['password'], PASSWORD_DEFAULT)) {
            return $this->setPassword($user, $passwordGuess);
        }

        return true;
    }

    public function setPassword($user, $newPassword) {
        $newPasswordHash = $this->getPasswordHash($newPassword);

        if ($newPasswordHash) {
            $this->id = $user['User']['id'];
            $this->saveField('password', $newPasswordHash);
            return true;
        }

        return false;
    }

    public function getPasswordHash($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}
