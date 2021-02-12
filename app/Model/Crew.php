<?php
App::uses('WbLog', 'Lib');
class Crew extends AppModel {
	public $name = 'Crew';

	public $belongsTo = array(
		'Parentcrew' => array(
			'className' => 'Crew',
			'foreignKey' => 'crew_id',
			'dependent' => false,
			'finderQuery' => 'SELECT Parentcrew.* FROM crews AS Parentcrew WHERE Parentcrew.id={$__cakeForeignKey__$}'
		)
	);

	public $hasMany = array(
		'Team' => array(
			'className' => 'Team',
			'foreignKey' => 'crew_id',
			'fields' => 'Team.id, Team.name, Team.locked',
			'unique' => true
		)
	);

	public function beforeValidate($options = []) {
		$this->validate = array(
			'name' => array(
				'special-characters' => array(
					'rule' => '/^[a-zæÆøØåÅ0-9:\-\& ]*$/i',
					'message' => __("Crew name can only contain letters, numbers and colons"),
					'last' => false,
				),
				'min-length' => array(
					'rule' => array('minLength', '4'),
					'message' => __("Crew name must be 4 characters or more")
				)
			)
		);
	}


	public function beforeSave($options = []) {
		/*if($this->data['Crew']['crew_id'] == NULL) {
			$this->data['Crew']['crew_id'] = 0;
        }*/
		return true;
	}

	public function getOpenCrews($selectTag=false, $crew_id=0) {
		$type = 'all';

		if($selectTag) {
			$type = 'list';
		}

		$crews = $this->find($type, array(
			'conditions' => array(
				'hidden' => 0,
				'canapply' => 1,
				'event_id' => WB::$event->id
			),
			'fields' => array(
				'id',
				'name'
			),
			'order' => 'name ASC',
			'recursive' => -1
		));

		return($crews);
	}

	public function getTeamList() {
		$crews = $this->getAllCrews(true, 0, true);
		App::import('Model', 'Team');
		$teamModel = new Team();
		$teams = array();
		foreach($crews as $crew_id => $crew_name) {
			$tempTeams = $teamModel->find('list', array(
				'conditions' => array(
					'Team.crew_id' => $crew_id
				),
				'order' => 'Team.name ASC'
			));
			foreach($tempTeams as $index => $name) {
				$teams[$index] = $crew_name.' – '.$name;
			}
		}
		return $teams;
	}

	public function getAllCrews($selectTag=false, $crew_id=0, $hidden=false) {
		$type = 'all';

		if($selectTag) {
			$type = 'list';
		}
		$hiddentext = '';
		if($hidden) {
			$hiddentext = '-hidden';
		}
		$crews = Cache::read(WB::$event->reference.'-crews-'.$type.$hiddentext);
		if($crews === false) {
			$conditions = array('event_id' => WB::$event->id);
			if(!$hidden) {
				$conditions['hidden'] = 0;
			}
			$crews = $this->find($type, array(
				'conditions' => $conditions,
				'fields' => array(
					'id',
					'name',
					'canapply',
					'crew_id'
				),
				'order' => 'name',
				'recursive' => -1
			));
			Cache::write(WB::$event->reference.'-crews-'.$type.$hiddentext, $crews);
		}
		return($crews);
	}

	public function bindEnroll() {
		$this->unbindModel(array(
			'hasMany' => array(
				'Team'
			)
		));
		$this->bindModel(array(
			'hasOne' => array(
				'EnrollGreeting' => array(
					'className' => 'EnrollGreeting'
				)
			)
		));
	}
	public function getCrewHierarchy($select=false, $excludeHidden=true) {
		$type = 'all';
		$hiddenCachePrefix = '';
		if(!$excludeHidden) {
			$hiddenCachePrefix = 'hidden';
		}

		if($select) {
			$type = 'list';
		}
		$crews = Cache::read(WB::$event->reference.'-crew-hierarchy-'.$type.$hiddenCachePrefix);
		if($crews === false) {
			$crews = array();
			if($excludeHidden) {
				$parents = $this->find($type, array(
					'conditions' => array(
						'Crew.crew_id' => 0,
						'Crew.event_id' => WB::$event->id,
						'Crew.hidden' => 0
					),
					'order' => 'Crew.sorted_weight, Crew.name'
				));
			} else {
				$parents = $this->find($type, array(
					'conditions' => array(
						'Crew.crew_id' => 0,
						'Crew.event_id' => WB::$event->id
					),
					'order' => 'Crew.sorted_weight, Crew.name'
				));
			}
			foreach($parents as $parent) {
				$crews[] = $parent;
				$childs = $this->getChildCrews($parent['Crew']['id'], $select, $excludeHidden);
				if(!empty($childs)) {
					foreach($childs as $child) {
						$crews[] = $child;
					}
				}
			}
			Cache::write(WB::$event->reference.'-crew-hierarchy-'.$type.$hiddenCachePrefix, $crews);
		}
		return $crews;
	}

	public function getChildCrews($parent_id, $select=false, $excludeHidden=true) {
		$type = 'all';
		$hiddenCachePrefix = '';
		if(!$excludeHidden) {
			$hiddenCachePrefix = 'hidden';
		}

		if($select) {
			$type = 'list';
		}
		$crews = Cache::read(WB::$event->reference.'-crew-childs-'.$parent_id.$hiddenCachePrefix);
		if($crews === false) {
			$this->unbindModel(array(
				'hasMany' => array(
					'Team'
				),
				'belongsTo' => array(
					'Parentcrew'
				)
			));
			if($excludeHidden) {
				$crews = $this->query("SELECT * FROM (SELECT * FROM wb4_crews WHERE hidden=false order by crew_id, id) Crew, (SELECT @pv := '".$parent_id."') initialisation WHERE find_in_set(crew_id, @pv) > 0 AND @pv := concat(@pv, ',', id) ORDER BY sorted_weight, name");
			} else {
				$crews = $this->query("SELECT * FROM (SELECT * FROM wb4_crews order by crew_id, id) Crew, (SELECT @pv := '".$parent_id."') initialisation WHERE find_in_set(crew_id, @pv) > 0 AND @pv := concat(@pv, ',', id) ORDER BY sorted_weight, name");
			}
			Cache::write(WB::$event->reference.'-crew-childs-'.$parent_id.$hiddenCachePrefix, $crews);
		}
		return $crews;
	}
	public function getCrewByName($name) {
		$crew = $this->find('first', array(
			'conditions' => array(
				'Crew.name' => urldecode(htmlspecialchars_decode($name)),
				'Crew.event_id' => WB::$event->id
			)
		));
		return $crew;
	}

	/**
	 * Get an array of usertitles where the index corespond to the
	 * specified crews usertitle
	 *
	 * @param u_int $crew_id
	 * @return array with roles
	 */
	public function getUserRoles($crew_id=0) {
		return array(__("Member"), __("Shiftleader"), __("Co-Chief"), __("Chief"), __("Organizer"));
	}

	/**
	 * Retreive the user role for a specified user
	 *
	 * @param array $crew_id
	 * @param array $user_id
	 * @return the number coresponding to the leader. -1 otherwise.
	 */
	public function getMemberUserRole($crew, $user) {
		$return_role = -1;
		foreach($user['Crew'] as $current) {
			if($current['id'] == $crew['Crew']['id'] && $return_role < $current['CrewsUser']['leader']) {
				$return_role = $current['CrewsUser']['leader'];
			}
			if($current['id'] == $crew['Parentcrew']['id'] && $return_role < $current['CrewsUser']['leader']) {
				$return_role = $current['CrewsUser']['leader'];
			}
      $child_crews = $this->query("SELECT id, crew_id FROM (SELECT id, crew_id FROM wb4_crews ORDER BY crew_id, id) Crew, (SELECT @pv := '".$current['id']."') initialisation WHERE find_in_set(crew_id, @pv) > 0 AND @pv := concat(@pv, ',', id)");
      foreach ($child_crews as $child_crew) {
        if($child_crew['Crew']['id'] == $crew['Crew']['id'] && $return_role < $current['CrewsUser']['leader']) {
          $return_role = $current['CrewsUser']['leader'];
        }
      }
    }
		return $return_role;
	}

	/**
	 * Add member.
	 *
	 * @param u_int $crew_id
	 * @param u_int $user_id
	 * @param u_int $leader
	 */
	public function addMember($crew_id, $user_id, $leader=0) {
		$crew_id = (int) $crew_id;
		$user_id = (int) $user_id;
		$leader = (int) $leader;
		$event_id = (int) WB::$event->id;

		$this->query("insert into wb4_crews_users (crew_id, user_id, leader, assigned) values ($crew_id, $user_id, $leader, now())");
		//only allow modification of orders with items that are still orderable
		$this->query("UPDATE wb4_crew_effects_orders SET order_deactivated = 0 WHERE event_id = $event_id AND user_id=$user_id AND item_id IN (SELECT id FROM wb4_crew_effects_items WHERE allow_order = 1)");
		WbLog::log('crew', $crew_id. ' New member userID ' . $user_id. ' UserRole: '.$leader. ' performed by: '.WB::$user['User']['id']);
		$this->clearUserCache($crew_id);
	}

	/**
	 * Delete member.
	 *
	 * @param u_int $crew_id
	 * @param u_int $user_id
	 */
	public function deleteMember($crew_id, $user_id) {
		$crew_id = (int) $crew_id;
		$user_id = (int) $user_id;
		$event_id = (int) WB::$event->id;

		$memberships = $this->query("SELECT wb4_crews.name FROM wb4_crews_users INNER JOIN wb4_crews ON wb4_crews_users.crew_id=wb4_crews.id WHERE wb4_crews_users.user_id = $user_id AND wb4_crews.event_id = $event_id");
		$number_of_memberships = count($memberships);
		//only deactivate effects-order if user will have zero memberships after deletion. Count before deletion to avoid race condition/slow queries etc.
		if($number_of_memberships <= 1){
			$this->query("UPDATE wb4_crew_effects_orders SET order_deactivated = 1 WHERE event_id = $event_id AND user_id=$user_id");
		}

		$this->query("DELETE FROM wb4_crews_users WHERE crew_id=$crew_id AND user_id=$user_id");
		WbLog::log('crew', $crew_id. ': Removed userID ' . $user_id. ' performed by: '.WB::$user['User']['id']);
        $this->clearUserCache($crew_id);
	}

	/**
	 * Set the members user role (known as leader for now).
	 *
	 * @param u_int $crew_id
	 * @param u_int $user_id
	 * @param u_int $leader
	 */
	public function setUserRole($crew_id, $user_id, $leader=0) {
		$crew_id = (int) $crew_id;
		$user_id = (int) $user_id;
		$leader = (int) $leader;
		$this->query("UPDATE wb4_crews_users SET leader=$leader WHERE user_id=$user_id AND crew_id=$crew_id");
        WbLog::log('crew', $crew_id. ': Changed userrole for userID ' . $user_id. ' to '.$leader. ' performed by: '.WB::$user['User']['id']);
		$this->clearUserCache($crew_id);
	}

	/**
	 * Set the members custom title.
	 *
	 * @param u_int $crew_id
	 * @param u_int $user_id
	 * @param varchar $title
	 */
	public function setMemberCustomTitle($crew_id, $user_id, $title=''){
		$crew_id = (int) $crew_id;
		$user_id = (int) $user_id;
		$this->query("UPDATE wb4_crews_users SET title=\"$title\" WHERE user_id=$user_id AND crew_id=$crew_id");
		$this->clearUserCache($crew_id);
	}

	/**
	 * Set the team membership for a specified user and crew
	 *
	 * @param u_int $crew_id
	 * @param u_int $user_id
	 * @param u_int $team_id
	 */
	public function setMemberTeam($crew_id, $user_id, $team_id=0) {
		$crew_id = (int)$crew_id;
		$user_id = (int)$user_id;
		$team_id = (int)$team_id;
		$this->query("UPDATE wb4_crews_users SET team_id=$team_id WHERE user_id=$user_id AND crew_id=$crew_id");
		$this->clearUserCache($crew_id);
	}

	/**
	 * Add a team to the specified crew if it doesn't already exist
	 *
	 * @param u_int $crew_id
	 * @param string(64) $name
	 * @return true if team is added, false otherwise
	 */
	public function addTeam($crew_id, $name) {
		$crew_id = (int)$crew_id;

		// Make sure the team doesn't already exist
		$team = $this->query("SELECT Team.id FROM wb4_teams Team WHERE Team.crew_id=$crew_id AND Team.name='$name' LIMIT 1");
		if(!$team) {
			$this->query("INSERT INTO wb4_teams (crew_id, name) VALUES ($crew_id, '$name')");
			return true;
		}
		return false;
	}

	/**
	 * Remove a team and unassign all members
	 *
	 * @param u_int $team_id
	 */
	public function removeTeam($team_id, $crew_id) {
		$team_id = (int)$team_id;

		// Do not allow to delete 0 (No team)
		if($team_id) {
			// Unassign all users that belong to this team
			$this->query("UPDATE wb4_crews_users SET team_id=0 WHERE team_id=$team_id");

			// Delete the team
			$this->query("DELETE FROM wb4_teams WHERE id=$team_id");
			$this->clearUserCache($crew_id);
		}
	}

	/**
	 * Save crew description
	 *
	 * @param u_int $crew_id
	 * @param string $content
	 * @return boolean
	 */
	public function saveDescription($crew_id, $content, $parent_id) {
		$data['Crew']['id'] = $crew_id;
		$data['Crew']['content'] = $content;
		$data['Crew']['crew_id'] = $parent_id;
		$this->clearCrewCache($crew_id);
		return $this->save($data, false);
	}

	/**
	 * Clears cache for User after altering the database
	 *
	 * @param u_int crew_id
	 */
	public function clearUserCache($crew_id) {
		App::import('Model', 'User');
		$user = new User();
		$user->clearMemberCache($crew_id);
	}

	/**
	 * Clears cache for a crew
	 *
	 * @param u_int crew_id
	 */
	public function clearCrewCache($crew_id) {
		$crew = $this->find('first', array(
			'conditions' => array(
				'Crew.id' => $crew_id
			)
		));
		if ($crew) {
			$crew_id = $crew['Crew']['crew_id']?$crew['Crew']['crew_id']:$crew_id;
			Cache::delete(WB::$event->reference.'-crew-childs-'.$crew_id);
			Cache::delete(WB::$event->reference.'-crew-childs-'.$crew_id.'hidden');
		}
		Cache::delete(WB::$event->reference.'-crew-hierarchy-listhidden');
		Cache::delete(WB::$event->reference.'-crew-hierarchy-list');
		Cache::delete(WB::$event->reference.'-crew-hierarchy-allhidden');
		Cache::delete(WB::$event->reference.'-crew-hierarchy-all');
		Cache::delete(WB::$event->reference.'-crews-list');
		Cache::delete(WB::$event->reference.'-crews-list-hidden');
		Cache::delete(WB::$event->reference.'-crews-all');
		Cache::delete(WB::$event->reference.'-crews-all-hidden');
	}
	public function clearCrewListCache($crew_id) {
		$crew = $this->find('first', array(
			'conditions' => array(
				'Crew.id' => $crew_id
			)
		));
		if (!$crew) {
			return;
		}
		$crew_id = $crew['Crew']['crew_id']?$crew['Crew']['crew_id']:$crew_id;
		Cache::delete(WB::$event->reference.'-crew-childs-'.$crew_id);
		Cache::delete(WB::$event->reference.'-crew-childs-'.$crew_id.'hidden');
	}

    public function addChildCrews($res) {
        foreach($res as $r) {
            $tmp = $this->query("SELECT id FROM wb4_crews WHERE crew_id={$r}");
            foreach($tmp as $t) {
                $res[] = $t['wb4_crews']['id'];
            }
        }
        return $res;
    }
}

//HAck used for usort
function cCmp($a, $b) {
	return strcmp($a["cid"], $b["cid"]);
}

