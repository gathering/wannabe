<?php

/**
 * Component that handles authentication
 * @Author Tor Henning Ueland
 */
class AclComponent extends Component {

	private $cache;
    private $controller;
    var $forbidden = false;

	/**
	 * Init ACL function, makes sure that we got some data in cache, or else it will put
	 * ACL data there.
	 */
	public function initialize(Controller $controller) {

		$this->Aclobject = ClassRegistry::init('Aclobject');
		$this->controller = $controller;

		if(!isset($controller->Wannabe->user['User']) || !$controller->Wannabe->event->reference) {
			return true;
		}
		$uid = $controller->Wannabe->user['User']['id'];
		$event = $controller->Wannabe->event->reference;

		$this->cache = CakeSession::read('aclCache');

		//Init cached data if needed
		if(!isset($this->cache[$event]) || (null == $this->cache[$event][$uid] && $uid > 0)) {
			$this->initAclCache($controller->Wannabe->user, $controller->Wannabe->event);
		}
		if($controller->requireLogin && $uid) {
			if(!$this->hasAccess()) {
                $this->forbidden = true;
            } elseif(!$this->hasAccess('superuser', $controller->Wannabe->user, '/'.$controller->Wannabe->event->reference.'/') && $controller->Wannabe->event->disable) {
							$controller->Flash->error(__('The page “%s” does not exist.', $controller->here));
							$controller->redirect('/');
            }
		}
		if($uid && $this->hasAccess('read', $controller->Wannabe->user, 'search')) {
			$controller->set('searchAccess', true);
			$controller->Wannabe->searchAccess = true;
            WB::$searchAccess = true;
		}
		return true;
	}

	private function initAclCache($user, $event) {
		$uid = $user['User']['id'];
		if(!$uid) {
			$uid = 0;
		}
		$this->cache[$event->reference][$uid] = $this->Aclobject->findAllForUserEvent($user, $event);
		CakeSession::write('aclCache', $this->cache);
	}

	/**
	 * Check if the user have access to the current page.
	 *
	 * @return boolean
	 */
	public function hasAccess($action='read', $user=null, $path=null) {
		$event = $this->controller->Wannabe->event->reference;
		if(!$path) {
			$path = $this->controller->here;
		} elseif(substr($path, 1, strlen($this->controller->Wannabe->event->reference)) != $this->controller->Wannabe->event->reference) {
			$path = "/{$this->controller->Wannabe->event->reference}/{$path}";
		}
		if(substr($path,-1,1) != '/') {
			$path = $path.'/';
		}

		if(substr($path, -strlen('/Term/')) === '/Term/') {
			return true;
		}

		if(!isset($this->controller->Wannabe->user['User']) || (null != $user && $user['User']['id'] != $this->controller->Wannabe->user['User']['id'])) {
			if(!isset($this->cache[$event][$user['User']['id']])) {
				$this->initAclCache($user, $this->controller->Wannabe->event);
			}
		}

		if(null != $user) {
			$acls = $this->cache[$event][$user['User']['id']];
		} else {
			if(!isset($this->controller->Wannabe->user['User'])) {
				return false;
			}
			$acls = $this->cache[$event][$this->controller->Wannabe->user['User']['id']];
		}

		if(is_array($acls)) {
			foreach($acls as $acl) {
				if(preg_match('/(.*)*!(.*)$/i', $acl['path'], $exclude_matches) == 1) {

					$acl_path = explode("!", $acl['path'])[0];
					$exclude = $exclude_matches[2];
					$path_root = explode("*", $acl_path)[0];
					$exclude_path = $path_root.$exclude."/";
					$acl['path'] = $acl_path;
					$regexp = str_replace(array('/*','/','*'), array('(|/*)','\/','.*'), $exclude_path);
					if( preg_match('/'.$regexp.'$/i', $path) == 1)  {
						return false;
					}
				}
				$regexp = str_replace(array('/*','/','*'), array('(|/*)','\/','.*'), $acl['path']);
				if ( preg_match('/'.$regexp.'$/i', $path, $matches) == 1 ) {
					if($acl[$action] == 1) {
						return true;
					}
				}
			}
		}
		return false;
	}

	public function hasAccessToCrew($user, $crew) {
		if ($this->hasAccess('superuser', $user)) {
			return true;
		}
		else if ($this->hasAccess('write', $user)) {
			if ($this->hasMembershipToCrew($user, $crew['Crew']['id'])) {
				return true;
			}
			else if (isset($crew['Parentcrew']['id']) && $this->hasMembershipToCrew($user, $crew['Parentcrew']['id'])) {
				return true;
			}
		}
		return false;
	}

	public function hasMembershipToEvent($user) {
		foreach ( $user['Crew'] as $crew )
			if ($crew['event_id'] == WB::$event->id)
				return(true);
		return false;
	}

	public function hasMembershipToTeam($user, $crew_id, $team_id) {
		foreach ( $user['Crew'] as $crew ) {
			if ($crew['id'] == $crew_id && $crew['CrewsUser']['team_id'] == $team_id){
				return true;
            }
        }
		return false;
	}

	public function hasAccessToDetailedUserInfo($user) {
		// Is the user is a chief
		if($this->isLeader(3,$user)) {
			return true;
		}
		// Or does the user has write access to profile/view
		else if($this->hasAccess('superuser', $user, '/'.WB::$event->reference.'/profile/view')) {
			return true;
		}

		return false;
	}

    public function hasAccessToViewUserDetail($type, $target) {
        if(!isset($target['UserPrivacy']))
            return true;
        if(isset($target['UserPrivacy'][$type]) && $target['UserPrivacy'][$type])
            return false;
        return true;
    }

	public function hasMembershipToCrew($user, $crew_id) {
		foreach ($user['Crew'] as $crew) {
			if ($crew['id'] == $crew_id) {
				return true;
            } else{
			    $crew_class = New Crew();
                $child_crews = $crew_class->query("SELECT id, crew_id FROM (SELECT id, crew_id FROM wb4_crews ORDER BY crew_id, id) Crew, (SELECT @pv := '".$crew['id']."') initialisation WHERE find_in_set(crew_id, @pv) > 0 AND @pv := concat(@pv, ',', id)");
                foreach ($child_crews as $child_crew) {
                    if($child_crew['Crew']['id'] == $crew_id) {
                        return true;
                    }
                }
            }
        }
		return false;
	}

	public function isLeader($leader, $user) {
		foreach($user['Crew'] as $crew )
			if($crew['CrewsUser']['leader'] >= $leader || $this->hasAccess('superuser', $user))
				return true;
		return false;
	}
}
