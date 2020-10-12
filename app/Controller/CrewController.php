<?php
App::uses('WbSanitize', 'Lib');

class CrewController extends AppController {
	public $uses = array('User', 'Crew', 'Phonetype', 'Wikipage', 'Team', 'ApplicationDocument', 'EnrollSetting', 'ApplicationChoice', 'EnrollMail', 'Task', 'Term');
    var $layout = "responsive-default";

	/**
	 * Set requireLogin to false if description is accessed.
	 */
	public function beforeFilter() {
		if(
			$this->request->params['action'] == 'Description' ||
			$this->request->params['action'] == 'description'
		) {
			$this->requireLogin = false;
		}
		parent::beforeFilter();
	}

	/**
	 * Display a list of all the crews.
	 */
	public function index() {
		$crews = $this->Crew->getCrewHierarchy(false);
		$members = array();
		foreach($crews as $crew) {
			$members[$crew['Crew']['id']] = $this->User->getMembers($crew['Crew']['id']);
		}

		$template = 'default';
		$box_into_header = array();
		$box_into_header['Header'] = __("Views");
		$box_into_header['Link'] = array();
		if(isset($_REQUEST['extended'])) {
			$type = (int)$_REQUEST['extended'];
			switch($type) {
				case 1:
					$template = 'extended';
                    $box_into_header['Link'][] = array('class' => 'btn btn-default', 'href' => '/Crew?extended=0', 'title' => __("Normal"));
					break;
				default:
					$template = 'default';
                    $box_into_header['Link'][] = array('class' => 'btn btn-default', 'href' => '/Crew?extended=1', 'title' => __("Extended"));
			}
		} else if(CakeSession::check('crewlist-type')) {
			$template = CakeSession::read('crewlist-type');
			switch($template) {
				case 'extended':
                    $box_into_header['Link'][] = array('class' => 'btn btn-default', 'href' => '/Crew?extended=0', 'title' => __("Normal"));
					break;
				default:
                    $box_into_header['Link'][] = array('class' => 'btn btn-default', 'href' => '/Crew?extended=1', 'title' => __("Extended"));
			}
        } else {
            $box_into_header['Link'][] = array('class' => 'btn btn-default', 'href' => '/Crew?extended=1', 'title' => __("Extended"));
        }
		$this->set('box_into_header', $box_into_header);
		CakeSession::write('crewlist-type');

		$this->set('title_for_layout', __("Crew list"));
		$this->set('crewnames', $this->Crew->getAllCrews(true));
		$this->set('crews', $crews);
		$this->set('members', $members);
		$this->set('phonetypes', $this->Phonetype->find('list'));
		$this->set('canViewDetailedInfo', $this->Acl->hasAccessToDetailedUserInfo($this->Wannabe->user));
		$this->render("list-{$template}");
	}
	/**
	 * Display a single crew with members.
	 * This is also where a chief (or someone with access) can administrate a crew.
	 */
	public function view() {
		preg_match('/\/(\w+)\/(\w+)\/(\w+)\/(.*)/', $this->here, $matches);
		if(isset($matches[4]) && $matches[4]!='') {
			list($name, $action, $param, $subpageset) = preg_split('/\//', $matches[4]) + Array(null ,null ,null, True);
		} else {
			list($name, $action, $param, $subpageset) = Array($this->Wannabe->user['Crew'][0]['name'], null, null, False);
		}

		# If this user have accecss to multiple crews, show all or redirect if user only have access to one crew
		if($subpageset === False){
			# Get the users crews
			if(count($this->Wannabe->user['Crew']) <= 0){
				throw new BadRequestException(__("No access to show crew."));
			}
			if(count($this->Wannabe->user['Crew']) <= 1){
				return $this->redirectEvent('/Crew/View/'.array_values($this->Wannabe->user['Crew'])[0]['name']);
			}
			$this->set('title_for_layout',__("Select crew"));
			$this->set('desc_for_layout', '');
			$this->set('crews',$this->Wannabe->user['Crew']);
			$this->set('subpageset',$subpageset);
			return;
		}

		$crew = $this->Crew->getCrewByName($name);
		if(!$crew) {
			throw new BadRequestException(__("No crew with that name"));
		}

		$this->set('title_for_layout', $crew['Crew']['name']);
		$this->set( 'name', $name );
		$format = array('Wikipage' => array('content' => $crew['Crew']['content']));
		$format = $this->Wikipage->format($format, $this);
		   	$crew['Crew']['content'] = $format['Wikipage']['content'];
		$this->set( 'crew', $crew );
		$this->set( 'canManage', $this->Acl->hasAccessToCrew($this->Wannabe->user, $crew) );
		$this->set( 'canViewDetailedInfo', $this->Acl->hasMembershipToCrew($this->Wannabe->user, $crew['Crew']['id']) || $this->Acl->hasAccessToDetailedUserInfo($this->Wannabe->user));
		$canViewAddress = array();
		$canViewEmail = array();
		$canViewPhone = array();
    $canViewBirth = array();
		$members = $this->User->getMembers($crew['Crew']['id']);
		foreach($members as $user) {
			$canViewAddress[$user['User']['id']] = 	(isset($user['UserPrivacy']['address']) && !$user['UserPrivacy']['address']);
			$canViewEmail[$user['User']['id']] = 	(isset($user['UserPrivacy']['email']) && !$user['UserPrivacy']['email']);
			$canViewPhone[$user['User']['id']] = 	(isset($user['UserPrivacy']['phone']) && !$user['UserPrivacy']['phone']);
			$canViewBirth[$user['User']['id']] = 	(isset($user['UserPrivacy']['birth']) && !$user['UserPrivacy']['birth']);
		}
		$this->set('canViewAddress', $canViewAddress);
		$this->set('canViewEmail', $canViewEmail);
		$this->set('canViewPhone', $canViewPhone);
		$this->set('canViewBirth', $canViewBirth);
		$this->set('members', $members);
		$this->set('phonetypes', $this->Phonetype->find('list'));
		$this->set('subpageset',$subpageset);
	}

	public function edit() {
		preg_match('/\/(\w+)\/(\w+)\/(\w+)\/(.*)/', $this->here, $matches);
		if(isset($matches[4]) && $matches[4]!='') {
			list($name, $action, $param, $subpageset) = preg_split('/\//', $matches[4]) + Array(null ,null ,null, True);
		} else {
			list($name, $action, $param, $subpageset) = Array($this->Wannabe->user['Crew'][0]['name'], null, null, False);
		}

		# If this user have accecss to multiple crews, show all or redirect if user only have access to one crew
		if($subpageset === False){
			# Get the users crews
			$manageable_crews = [];
			foreach ($this->Wannabe->user['Crew'] as $usercrew) {
				if (1 <= $usercrew['CrewsUser']['leader'] || $this->Acl->hasAccess('superuser', $this->Wannabe->user, '/'.$this->Wannabe->event->reference.'/Crew/Edit')){
					$manageable_crews[$usercrew['id']] = array($usercrew);
					$crews[$usercrew['id']] = $usercrew['name'];
					$crews2 = $this->Crew->query("SELECT * FROM (SELECT * FROM wb4_crews ORDER BY crew_id, id) Crew, (SELECT @pv := '".$usercrew['id']."') initialisation WHERE find_in_set(crew_id, @pv) > 0 AND @pv := concat(@pv, ',', id) ORDER BY name");
					foreach ($crews2 as $crew2){
						$manageable_crews[$crew2['Crew']['id']] = array($crew2['Crew']);
						$crews[$crew2['Crew']['id']] = $crew2['Crew']['name'];
					}
				}
			}
			if(count($manageable_crews) <= 0){
				throw new BadRequestException(__("No access to edit crew."));
			}
			if(count($manageable_crews) <= 1){
				return $this->redirectEvent('/Crew/Edit/'.array_values($manageable_crews)[0][0]['name']);
			}
			$this->set('title_for_layout',__("Crew you administrate"));
			$this->set('desc_for_layout', '');
			$this->set('crews',$manageable_crews);
			$this->set('subpageset',$subpageset);
			return;
		}

		$crew = $this->Crew->getCrewByName($name);
		if(!$crew) {
			throw new BadRequestException(__("No crew with that name"));
		}
		$canManage = $this->Acl->hasAccessToCrew($this->Wannabe->user, $crew);
		$crewname = $crew['Crew']['name'];
		$members = $this->User->getMembers($crew['Crew']['id']);
		$userRole = $this->getUserRole($this->Wannabe->user, $crew);
		$userRoles = $this->Crew->getUserRoles($crew['Crew']['id']);
		$manageTeams[0] = __("No teams");
		$isLevelFour = $this->Acl->isLeader(4, $this->Wannabe->user);
        $isLevelThree = $this->Acl->isLeader(3, $this->Wannabe->user);
		if($this->Acl->hasAccess('superuser', $this->Wannabe->user)) {
			$isLevelFour = true;
			$isLevelThree = true;
		}

		if($userRole <= 0 || ($userRole == 1 && $this->Acl->hasMembershipToTeam($this->Wannabe->user, $crew['Crew']['id'], 0))) {
			throw new BadRequestException(__("No access to edit this crew."));
		}

		// Create a list of teams the logged in user has access to
		if($crew['Team']!=null){
			foreach($crew['Team'] as $team) {
				if($userRole >= 2 || $this->Acl->hasMembershipToTeam($this->Wannabe->user, $crew['Crew']['id'], $team['id'])) {
					$manageTeams[$team['id']] = WbSanitize::clean($team['name']);
				}
			}
		}

		// Specify wether the loged in user has access to each member
		foreach($members as &$member) {
			if(($userRole >= 2 || isset($manageTeams[$member['Team']['id']])) && $userRole > $member['CrewsUser']['leader']) {
				$member['canManage'] = true;
			} else {
				$member['canManage'] = false;
			}
		}

		// Am I suppose to save something?
		if($action) {
			if(!$canManage && ($action != 'save-members' || count($manageTeams) == 1)) {
				throw new BadRequestException(__("No access to perform chosen action."));
			}
			switch($action) {
				// Open/close crew for new applications
				case 'set-canapply':
					if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_REQUEST['set-canapply']) && isset($this->data['Crew']['canapply'])) {
						if($this->data['Crew']['canapply'] == 'TRUE') {
							$changecrew['Crew']['id'] = $crew['Crew']['id'];
							$changecrew['Crew']['canapply'] = 1;
							$this->Crew->save($changecrew, false);
							$this->Flash->success(__("Crew has been opened for application"));
						}
						else if($this->data['Crew']['canapply'] == 'FALSE') {
							$changecrew['Crew']['id'] = $crew['Crew']['id'];
							$changecrew['Crew']['canapply'] = 0;
							$this->Crew->save($changecrew, false);
							$this->Flash->success(__("Crew has been closed for application"));
						}
                        $this->Crew->clearCrewCache($crew['Crew']['id']);
					}
					break;

				// Reject all active applications if the user has access to enroll.
				case 'reject-all':
                    if($isLevelFour) {
						if($_SERVER['REQUEST_METHOD'] == 'POST') {
							// Do I need to verify the action?
							if(isset($_REQUEST['reject-all'])) {
								$this->set( 'was', preg_replace("/".$action."\/".$param."/", "", $this->here));
								$this->set( 'header', __("Deny all active applications"));
								$this->set( 'text', __("This action cannot be undone. Are you completely sure you want to continue?"));
								$this->set( 'rejectall', true);
								$this->render('_verifyaction');
								return;
							}
							// Is the action verified?
							else if(isset($_REQUEST['verify-yes'])) {
								if(!empty($this->request->data['denialmessage'])) {
									$denialmessage = __("From")." ".$crew['Crew']['name']."\n".$this->request->data['denialmessage']."\n";
								} else {
									$denialmessage = "";
								}
								$settings = $this->EnrollSetting->find('first', array(
									'conditions' => array(
										'EnrollSetting.event_id' => $this->Wannabe->event->id
									)
								));
								$pendingmail = $this->EnrollMail->find('first', array(
									'conditions' => array(
										'EnrollMail.enroll_setting_id' => $settings['EnrollSetting']['id'],
										'EnrollMail.type' => 'pending'
									)
								));
								$deniedmail = $this->EnrollMail->find('first', array(
									'conditions' => array(
										'EnrollMail.enroll_setting_id' => $settings['EnrollSetting']['id'],
										'EnrollMail.type' => 'denied'
									)
								));
								$this->ApplicationDocument->denyAll($crew['Crew']['id'], $deniedmail, $pendingmail, $denialmessage);
								$this->Flash->info(__("All applications denied."));
							}
						}
					} else {
						throw new BadRequestException(__("No access to deny all applications"));
					}
					break;

				// Save the crew description
				case 'save-description':
					if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_REQUEST['save-description']) && isset($this->data['Crew']['content'])) {
						$this->Crew->saveDescription($crew['Crew']['id'], $this->data['Crew']['content'], $crew['Crew']['crew_id']);
						$this->Flash->success(__("Description saved."));
					}
					break;

				// Delete a team an unassign all it's members
				case 'delete-team':
					if($param) {
						if(isset($_REQUEST['verify-yes'])) {
							$this->Crew->removeTeam($param, $crew['Crew']['id']);
							$this->Flash->info(__("Team deleted."));
						} else {
							$this->set( 'was', preg_replace("/".$action."\/".$param."/", "", $this->here));
							$this->set('header', __("Delete team"));
							$this->set('text', __("This action cannot be undone. Are you completely sure you want to continue?"));
							$this->set( 'hidden', array('Delete.Team' => $param));
							$this->render('_verifyaction');
							return;
						}
					}
					break;

				// Add a team
				case 'add-team':
					if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_REQUEST['add-team']) && isset($this->data['newteam']['name'])) {
						$this->Crew->addTeam($crew['Crew']['id'], $this->data['newteam']['name']);
						$this->Flash->success(__("Team added."));
					}
					break;

				// Add a member
				case 'add-member':
					if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_REQUEST['add-member']) && isset($this->data['newmember']['id'])) {
						$this->Crew->addMember($crew['Crew']['id'], $this->data['newmember']['id'], $this->data['newmember']['usertitle']);
						$this->Flash->success(__("Member added. As this was done manually rather than accepting an application, the user will not recieve a acceptance mail. "));
					}
					break;

				// Save members
				case 'save-members':
					if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_REQUEST['save-members'])) {
						$crewMembers = array();
							foreach($members as &$member) {
								$crewMembers[$member['User']['id']] = &$member;
							}
						if($userRole >= 2 && isset($this->data['UserRoles'])){
							foreach($this->data['UserRoles'] as $user_id => $newRole){
								if(isset($crewMembers[$user_id]) && $crewMembers[$user_id]['canManage']){
									$this->Crew->setUserRole($crew['Crew']['id'], $user_id, $newRole);
								}
							}
						}
						if(isset($this->data['Userteams'])) {
							foreach($this->data['Userteams'] as $user_id => $team_id) {
								if(isset($crewMembers[$user_id]) && ($crewMembers[$user_id]['canManage'] && isset($manageTeams[$crewMembers[$user_id]['Team']['id']]))) {
									$this->Crew->setMemberTeam($crew['Crew']['id'], $user_id, $team_id);
								}
							}
						}
						if(isset($this->data['Customtitle'])) {
							foreach($this->data['Customtitle'] as $user_id => $title) {
								if($isLevelFour or ($crewMembers[$user_id]['canManage'] and $isLevelThree)) {
									$this->Crew->setMemberCustomTitle($crew['Crew']['id'], $user_id, $title);
								}
							}
						}
						$this->Flash->success(__("The crew has been saved"));
					}
					break;

				// Delete a member
				case 'delete-member':
					if((int)$param > 0){
						$crewMembers = array();
						$user_id = 0;
						foreach($members as &$member) {
							$crewMembers[$member['User']['id']] = &$member;
						}

						if(isset($crewMembers[$param]) && $crewMembers[$param]['canManage'] && isset($manageTeams[$crewMembers[$param]['Team']['id']]) ) {
							if($_SERVER['REQUEST_METHOD'] == 'POST') {
								$user_id = (int)$this->data['Delete']['User'];
							} else {
								$user_id = $param;
							}
						}

						if((int)$user_id == (int)$param) {
							if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_REQUEST['verify-yes'])){
								// Delete application choices too. This let's the user apply again
								$application_document = $this->ApplicationDocument->find('first', array(
									'conditions' => array(
										'ApplicationDocument.user_id' => $user_id,
										'ApplicationDocument.event_id' => $this->Wannabe->event->id
									)
								));
								if(isset($application_document['ApplicationDocument'])){
									$this->ApplicationChoice->deleteAll(array('ApplicationChoice.application_document_id' => $application_document['ApplicationDocument']['id']));
                                }

								$this->Crew->deleteMember($crew['Crew']['id'], $user_id);
								$this->Flash->success(__("Crew member deleted"));
							} else {
								$this->set( 'was', preg_replace("/".$action."\/".$param."/", "", $this->here));
								$this->set( 'header', __("Delete member"));
								$this->set( 'text', __("This action cannot be undone. Are you completely sure you want to continue?"));
								$this->set( 'hidden', array('Delete.User' => $user_id));
								$this->render('_verifyaction');
								return;
							}
						}
						break;

					}
				case 'save-settings':
				if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_REQUEST['save-settings']) && $this->Acl->hasAccess('superuser', $this->Wannabe->user)) {

					$this->request->data['Crew']['event_id'] = $this->Wannabe->event->id;

					$crew_id = $this->request->data['Crew']['id'];
					if($this->request->data['Crew']['crew_id']) {
						$crew_id = $this->request->data['Crew']['crew_id'];
					} else {
						$this->request->data['Crew']['crew_id'] = 0;
					}

					if ($this->Crew->save($this->request->data)) {
						$this->Crew->clearCrewCache($crew_id);
						$this->Crew->clearCrewCache($this->request->data['Other']['last_parent']);
						$this->Flash->success(__("%s was saved", $this->request->data['Crew']['name']));
					} else {
						$this->Crew->set($this->request->data);
						$fieldErrors = $this->validateErrors($this->Crew);
						if (!empty($fieldErrors)) {
							array_map(function($errors) {
								$this->Flash->error(join(', ', $errors));
							}, $fieldErrors);
						}
						$this->redirectEvent('/Crew/Edit/'.$crew['Crew']['name']);
						return;
					}
				}
					break;
				default:
					throw new CakeException();
			}

			if(isset($this->request->data['Crew']['name'])) {
				$this->redirectEvent('/Crew/Edit/'.$this->request->data['Crew']['name']);
            } else {
                $this->redirectEvent('/Crew/Edit/'.$crew['Crew']['name']);
			}
			return;
		}
		$settings = $this->EnrollSetting->getSettings();
		$box_into_header = array();
		$box_into_header['Header'] = __("View crew");
		$box_into_header['Link'] = array();
		$box_into_header['Link'][] = array('class' => 'btn btn-default', 'href' => '/Crew/View/'.$crew['Crew']['name'], 'title' => __("View crew"));
		$this->set('box_into_header', $box_into_header);
		$this->set('name', $name);
		$this->set('crew', $crew);
		$this->set('canManage', $canManage);
		$this->set('crewlist', $this->Crew->getAllCrews(true, 0, true));
		$this->set('canDeleteMembers', $canManage);
		$this->set('applications', $this->ApplicationDocument->countActive($crew['Crew']['id']));
		$this->set('waitingapplications', $this->ApplicationDocument->countWaiting($crew['Crew']['id']));
		$this->set('accessToEnroll', $this->Acl->hasAccess('read', $this->Wannabe->user, '/'.WB::$event->reference.'/Enroll'));
		$this->set('isSuperUser', $this->Acl->hasAccess('superuser', $this->Wannabe->user));
		$this->set('enrollActive', $settings['EnrollSetting']['enrollactive']);
		$this->set('canRejectAll', $isLevelFour);
		$this->set('manageTeams', $manageTeams);
		$this->set('manageUserRoles', array_slice($userRoles, 0, $userRole));
		$this->set('members', $members);
		$this->set('isLevelFour', $isLevelFour);
		$this->set('canSetCustomTitle', $this->Acl->hasAccess('superuser', $this->Wannabe->user));
		$this->set('isLevelThree', $isLevelThree);
		$this->set('title_for_layout', $crew['Crew']['name']);
		$this->set('desc_for_layout', __("Edit crew"));
		$this->set('subpageset',$subpageset);
	}

	public function viewTaskStatus() {
		preg_match('/\/(\w+)\/(\w+)\/(\w+)\/(.*)/', $this->here, $matches);
		if(isset($matches[4])) {
			list($name, $action, $param) = preg_split('/\//', $matches[4]) + Array(null ,null ,null);
		} else {
			list($name, $action, $param) = Array($this->Wannabe->user['Crew'][0]['name'], null, null);
		}
		$crew = $this->Crew->getCrewByName($name);
		if(!$crew)
			throw new BadRequestException(__("No crew with that name"));
		$userRole = $this->getUserRole($this->Wannabe->user, $crew);
		if(($userRole <= 0) || ($userRole == 1 && $this->Acl->hasMembershipToTeam($this->Wannabe->user, $crew['Crew']['id'], 0)))
			throw new BadRequestException(__("No access to edit this crew."));
		$members = $this->User->getMembers($crew['Crew']['id']);
        $this->set('members', $members);
		$this->set('crew', $crew);
        $this->set('term', $this->Term->getTerms());
		$this->set('tasks', $this->Task->find('all', array(
			'conditions' => array(
                'Task.event_id' => $this->Wannabe->event->id,
                'Task.enabled' => true
			)
		)));
		$box_into_header = array();
		$box_into_header['Header'] = __("Edit crew");
		$box_into_header['Link'] = array();
		$box_into_header['Link'][] = array('class' => 'btn btn-default', 'href' => '/Crew/Edit/'.$crew['Crew']['name'], 'title' => __("Edit crew"));
		$this->set('box_into_header', $box_into_header);
		$this->set('title_for_layout', $crew['Crew']['name']);
		$this->set('desc_for_layout', __("View task status"));
    }

    public function viewAllTaskStatuses() {
        if(!$this->Acl->hasAccess('superuser')) {
            throw new ForbiddenException();
        }
		$crews = $this->Crew->getCrewHierarchy(false);
		$members = array();
		foreach($crews as $crew) {
			$members[$crew['Crew']['id']] = $this->User->getMembers($crew['Crew']['id']);
		}
        $this->set('members', $members);
		$this->set('crews', $crews);
        $this->set('term', $this->Term->getTerms());
		$this->set('tasks', $this->Task->find('all', array(
			'conditions' => array(
                'Task.event_id' => $this->Wannabe->event->id,
                'Task.enabled' => true
			)
		)));
		$this->set('desc_for_layout', __("View all task statuses"));
    }

	public function description($name=null) {
		preg_match('/\/(\w+)\/(\w+)\/(\w+)\/(.*)/', $this->here, $matches);
		array_splice($matches, 0, 4);
		if(!empty($matches)) list($name) = split('[/]', $matches[0]);

		if ($name !== null) {
			$crews = & $this->Crew->find('all', array(
				'conditions' => array(
					'Crew.name' => urldecode($name),
					'Crew.event_id' => $this->Wannabe->event->id,
					'Crew.hidden' => 0
				),
				'order' => 'Crew.name ASC'
			));
			$form = array(
				'action' => '/'.$this->Wannabe->event->reference.'/Crew/Description',
				'button' => array(
					array(
						'type' => 'submit',
						'class' => 'success',
						'id' => 'back_to_desc',
						'text' => __("Back to descriptions")
					)
				)
			);
			$this->set('form', $form);
		} else {
			$crews = $this->Crew->getCrewHierarchy(false, true);
		}
		foreach ($crews as &$crew) {
			$data['Wikipage']['content'] = &$crew['Crew']['content'];
			$this->Wikipage->format($data, $this);
		}
		$this->set('title_for_layout', __("Crew description"));
		$this->set('desc_for_layout', __("Descriptions are written in the preferred language of the chief of the crew. Contact %s for help.", 'co@gathering.org'));

		$this->set('crews', $crews);
		if(!$this->Auth->isLoggedIn) {
            if($this->Wannabe->event->can_apply_for_crew) {
                $this->layout = 'front-generic-long-responsive';
            } else {
                $this->Flash->error(__("This page is not active"));
                $this->redirectEvent('/');
            }
		}
	}

	/**
	 * Get the user role for the user given and optionally
	 * checks for superuseraccess for the current logged in
	 * user.
	 *
	 * @paramt array $userid, array $crew
	 */
	private function getUserRole(&$user, &$crew) {
		if($user == $this->Wannabe->user) {
			if($this->Acl->hasAccess('superuser')) {
				// return an insane number to make sure the user has access to it all
				return 999;
			}
		}
		return $this->Crew->getMemberUserRole($crew, $user);
	}
}

?>
