<?

class AccreditationController extends AppController {

    public $uses = array('Accreditation', 'AccreditationAccess', 'AccreditationGroup', 'AccreditationGroupMember', 'Mailer', 'User');

    public function index() {
        $this->set('title_for_layout', __("Accreditation main page"));
        $this->set('canManage', $this->Acl->hasAccess('manage'));
        $this->set('available_press_accreditation_groups', $this->AccreditationAccess->getGroupAccess($this->Wannabe->user['User']['id'], $this->Wannabe->event->id));
    }

    public function all() {
        $this->set('title_for_layout', __("Accreditations"));
        $this->set('all_accreditations', $this->Accreditation->find('all', array(
            'conditions' => array(
                'Accreditation.event_id' => $this->Wannabe->event->id
                ),
                'order' => 'arrivaldate ASC'
            )));
		$box_into_header = array();
		$box_into_header['Header'] = __("Actions");
		$box_into_header['Link'] = array();
		$box_into_header['Link'][] = array('class' => 'btn primary', 'href' => '/Accreditation/Today', 'title' => __("Today"));
		$box_into_header['Link'][] = array('class' => 'btn primary', 'href' => '/Accreditation/UserGroups', 'title' => __("Edit groups"));
		$this->set('box_into_header', $box_into_header);
    }

    public function today() {

        $this->set('title_for_layout', __("Accreditations today"));

        //Here right now
        $this->set('here_now', $this->Accreditation->find('all', array(
                'conditions' => array(
                    'Accreditation.event_id' => $this->Wannabe->event->id,
                    'Accreditation.arrivaldate <=' => date("Y-m-d"),
                    'Accreditation.departuredate >=' => date("Y-m-d"),
                    'Accreditation.actual_arrival !=' => '0000-00-00 00:00:00',
                    'Accreditation.actual_departure =' => '0000-00-00 00:00:00',
                ),
                'order' => 'Accreditation.id'
            )
        ));

        //Should be here now
        $this->set('should_be_here_now', $this->Accreditation->find('all', array(
                'conditions' => array(
                    'Accreditation.event_id' => $this->Wannabe->event->id,
                    'Accreditation.arrivaldate <=' => date("Y-m-d"),
                    'Accreditation.departuredate >=' => date("Y-m-d"),
                    'Accreditation.actual_arrival =' => '0000-00-00 00:00:00',
                ),
                'order' => 'Accreditation.id'
        )));

        //Been here but left
        $this->set('been_here', $this->Accreditation->find('all', array(
                'conditions' => array(
                    'Accreditation.event_id' => $this->Wannabe->event->id,
                    'Accreditation.arrivaldate <=' => date("Y-m-d"),
                    'Accreditation.departuredate >=' => date("Y-m-d"),
                    'Accreditation.actual_arrival != ' => '0000-00-00 00:00:00',
                    'Accreditation.actual_departure != ' => '0000-00-00 00:00:00',
                ),
                'order' => 'Accreditation.id'
        )));
		$box_into_header = array();
		$box_into_header['Header'] = __("Actions");
		$box_into_header['Link'] = array();
		$box_into_header['Link'][] = array('class' => 'btn primary', 'href' => '/Accreditation/All', 'title' => __("All"));
		$box_into_header['Link'][] = array('class' => 'btn primary', 'href' => '/Accreditation/UserGroups', 'title' => __("Edit groups"));
		$this->set('box_into_header', $box_into_header);
    }

    public function edit($id=0, $action=0, $usergroup = 0) {

         if($this->request->is('post')) {

             if(!$id) {
                $this->Flash->warning(__("Select accreditation to edit"));
                $this->redirectEvent("/Accreditation");
             }

             if($action) {
                switch($action) {
                    case "saveaccreditation": {
                        $this->request->data['Accreditation']['event_id'] = $this->Wannabe->event->id;
                        if($this->request->data['Accreditation']['id'] != 0) {
                            if($this->Accreditation->save($this->request->data)) {
                                $this->Flash->success(__("Accreditation was successfully saved"));
                                $this->redirectEvent("/Accreditation/Edit/{$id}");
                            }
                            else {
                                $this->Flash->warning(__("Something went wrong with saving the accreditation"));
                            }
                        }
                        break;
                    }
                    case "addusergroup": {

                        if($this->request->data['AccreditationAccess']['accreditation_id'] == 0)
                            break;

                        //Make sure the accreditation actually exists
                        $accreditationDoesNotExist = !$this->Accreditation->find('first', array(
                                                        'conditions' => array(
                                                            'id' => $this->request->data['AccreditationAccess']['accreditation_id']
                                                        )
                                                    ));

                        if($accreditationDoesNotExist) {
                            $this->Flash->warning(__("An accreditation with that id does not exist"));
                            break;
                        }

                        //Make sure the group is not already added
                        $groupAlreadyAdded = $this->AccreditationAccess->find('first', array(
                                                    'conditions' => array(
                                                        'accreditation_id' => $this->request->data['AccreditationAccess']['accreditation_id'],
                                                        'accreditation_group_id' => $this->request->data['AccreditationAccess']['accreditation_group_id']
                                                    )
                                                ));

                        if($groupAlreadyAdded) {
                            $this->Flash->warning(__("That group is already added"));
                            break;
                        }


                        if($this->AccreditationAccess->save($this->request->data)) {
                            $this->Flash->success(__("Group was successfully added"));
                            $this->redirectEvent("/Accreditation/Edit/{$id}");
                        }
                        else {
                            $this->Flash->warning(__("Something went wrong with adding the group"));
                        }
                        break;
                    }
                }
             }
        }

        if($id and $action and $usergroup) {
            switch($action) {
                case "delusergroup": {
                        if($id and $action and $usergroup) {
                            if($this->AccreditationAccess->deleteGroupFromAccreditation($id, $usergroup)) {
                                $this->Flash->success(__("Group was successfully deleted"));
                                $this->redirectEvent("/Accreditation/Edit/{$id}");
                            }
                            else {
                                $this->Flash->warning(__("Something went wrong with deleting the group"));
                            }
                        }
                        break;
                    }
            }
        }

		$box_into_header = array();
		$box_into_header['Header'] = __("Back");
		$box_into_header['Link'] = array();
		$box_into_header['Link'][] = array('class' => 'btn primary', 'href' => '/Accreditation/All', 'title' => __("Back"));
		$this->set('box_into_header', $box_into_header);
        $this->set('title_for_layout', __("Edit accreditation"));
        $this->set('accreditation', $this->Accreditation->find('first', array(
            'conditions' => array(
                'Accreditation.id' => $id
                )
            )
        ));

        $this->set('usergroups_assigned', $this->Accreditation->getAccessGroupsWithNames($id, $this->Wannabe->event->id));

        //Usergroups available for this event
        $allUserGroups = $this->AccreditationGroup->find('all', array(
            'conditions' => array(
                'AccreditationGroup.event_id' => $this->Wannabe->event->id
        )));

        $usergroups = array();

        foreach($allUserGroups as $usergroup) {
            $usergroups[$usergroup['AccreditationGroup']['id']] = $usergroup['AccreditationGroup']['name'];
        }

        $this->set('usergroups', $usergroups);
    }

    public function delete($id=0) {
        if($this->request->is('post')) {
            if($id) {
                if($this->Accreditation->deleteAccreditation($id)) {
                    $this->Flash->success(__("Accreditation was successfully deleted"));
                    $this->redirectEvent('/Accreditation/All');
                }
            }
        }

        if(!$id) {
            $this->Flash->warning(__("Select an accreditation to delete"));
            $this->redirectEvent('/Accreditation/All');
        }

        $this->set('title_for_layout', __("Delete accreditation"));
        $this->set('accreditation', $this->Accreditation->find('first', array(
            'conditions' => array(
                'Accreditation.id' => $id
                )
            )));
    }

    public function userGroups() {
        $this->set('title_for_layout', __("Accreditations"));
        $this->set('usergroups', $this->AccreditationGroup->find('all', array(
			'conditions' => array(
				'AccreditationGroup.event_id' => $this->Wannabe->event->id
				),
				'order' => 'name ASC'
			)));
    }

	public function createUserGroup() {
		if($this->request->is('post')) {
			$this->request->data['AccreditationGroup']['event_id'] = $this->Wannabe->event->id;

			if($this->AccreditationGroup->save($this->request->data)) {
				$this->Flash->success(__("User group was saved"));
				$this->redirectEvent('/Accreditation/UserGroups');
			}
		}
		$this->set('title_for_layout', __("Accreditation administration - create user group"));
	}

	public function deleteUserGroup($id=0) {
		if($this->request->is('post')) {
		    if($id) {
    			if($this->AccreditationGroup->deleteGroup($id, $this->Wannabe->event->id)) {
    				$this->Flash->success(__("User group was deleted"));
    				$this->redirectEvent('/Accreditation/UserGroups');
    			}
			}
		}

		if(!$id) {
			$this->Flash->warning(__("Select a user group to delete"));
			$this->redirectEvent('/Accreditation/UserGroups');
		}

		$this->set('title_for_layout', __("Delete user group"));
		$this->set('usergroup', $this->AccreditationGroup->find('first', array(
			'conditions' => array(
				'AccreditationGroup.id' => $id
				)
			)));
	}

	public function editUserGroup($id=0, $action=0) {

		if($this->request->is('post')) {

            if(!$id) {
                $this->Flash->warning(__("Select a user group to edit"));
                $this->redirectEvent('/Accreditation/UserGroups');
            }

            if($action) {
                switch($action) {
                    case 'addmember': {
                        if($this->AccreditationGroupMember->save($this->request->data)) {
                            $this->Flash->success(__("Member was successfully added"));
                            $this->redirectEvent("/Accreditation/EditUserGroup/{$id}");
                        }
                        break;
                    }
                    case 'name': {
            			$this->request->data['AccreditationGroup']['event_id'] = $this->Wannabe->event->id;
            			if($this->AccreditationGroup->save($this->request->data)) {
            				$this->Flash->success(__("User group was successfully saved"));
            				$this->redirectEvent('/Accreditation/UserGroups');
            			}
                        break;
                    }
    			}
			}
		}

		$this->set('title_for_layout', __("Edit user group"));
		$this->set('usergroup', $this->AccreditationGroup->find('first', array(
			'conditions' => array(
				'AccreditationGroup.id' => $id
			)
		)));

        $member_ids = $this->AccreditationGroupMember->find('all', array(
            'fields' => array('user_id'),
            'conditions' => array (
                'AccreditationGroupMember.accreditation_group_id' => $id
            )
        ));

        $crewmembers = array();

        foreach($member_ids as $member) {
            $crewmembers[$member['AccreditationGroupMember']['user_id']] = $this->User->find('first', array(
                'fields' => array('username', 'realname', 'email'),
                'conditions' => array(
                    'User.id' => $member['AccreditationGroupMember']['user_id']
                 ),
                 'recursive' => false
            ));
            $crewmembers[$member['AccreditationGroupMember']['user_id']]['User']['id'] = $member['AccreditationGroupMember']['user_id'];
        }

            $this->set('members', $crewmembers);
	}

    public function deleteMemberFromUserGroup($group_id, $user_id) {
        if($this->AccreditationGroupMember->deleteMember($group_id, $user_id)) {
            $this->Flash->success(__("Member was successfully deleted"));
            $this->redirectEvent("/Accreditation/EditUserGroup/{$group_id}");
        }

        $this->Flash->warning(__("Member was not deleted"));
        $this->redirectEvent("/Accreditation/EditUserGroup/{$group_id}");
    }

    public function checkin($id=0) {

        if(!$id) {
            $this->Flash->warning(__("You must select an accreditation to checkin"));
            $this->redirectEvent('/Accreditation');
        }

        $this->request->data['Accreditation']['id'] = $id;
        $this->request->data['Accreditation']['actual_arrival'] = date('Y-m-d H:i:s');

        if($this->Accreditation->save($this->request->data)) {
            $this->Flash->warning(__("Accreditation was successfully checked in. Please update the badge ID if you have not already done so"));
            $this->redirectEvent("/Accreditation/Edit/{$id}");
        }
        else {
            $this->Flash->warning(__("Accreditation could not be checked in"));
            $this->redirectEvent("/Accreditation");
        }
    }

    public function checkout($id=0) {

        if(!$id) {
            $this->Flash->warning(__("You must select an accreditation to checkout"));
            $this->redirectEvent('/Accreditation');
        }

        $this->request->data['Accreditation']['id'] = $id;
        $this->request->data['Accreditation']['actual_departure'] = date('Y-m-d H:i:s');

        if($this->Accreditation->save($this->request->data)) {
            $this->Flash->success(__("Accreditation was successfully checked out"));
            $this->redirectEvent("/Accreditation/Edit/{$id}");
        }
        else {
            $this->Flash->warning(__("Accreditation could not be checked out"));
            $this->redirectEvent("/Accreditation");
        }
    }

    public function resetCheckinOut($id=0) {

        if(!$id) {
            $this->Flash->warning(__("You must select an accreditation to reset"));
            $this->redirectEvent('/Accreditation');
        }

        $this->request->data['Accreditation']['id'] = $id;
        $this->request->data['Accreditation']['actual_arrival']     = '0000-00-00 00:00:00';
        $this->request->data['Accreditation']['actual_departure']   = '0000-00-00 00:00:00';

        if($this->Accreditation->save($this->request->data)) {
            $this->Flash->success(__("Accreditation was successfully reset"));
            $this->redirectEvent("/Accreditation/Edit/{$id}");
        }
        else {
            $this->Flash->warning(__("Accreditation could not be reset"));
            $this->redirectEvent("/Accreditation");
        }
    }

    /*
     * Login is not required to register an accreditation
     */
    public function beforeFilter() {
        if($this->request->params['action'] == 'Register')
            $this->requireLogin = false;

        parent::beforeFilter();
    }

    public function register() {

        if($this->request->is('post')) {
            $this->request->data['Accreditation']['event_id'] = $this->Wannabe->event->id;
            if($this->Accreditation->save($this->request->data)) {
                $this->request->data['Accreditation']['id'] = $this->Accreditation->id;

                //Mail to press
                $accreditationConfirmationMail = new CakeEmail('default');
                $accreditationConfirmationMail->viewVars(array('accreditation' => $this->request->data['Accreditation']));
                $accreditationConfirmationMail->template('accreditation-confirmation-'.$this->Wannabe->lang, 'plain')->emailFormat('text')->subject(__("Press: Accreditation confirmation"))->to($this->request->data['Accreditation']['email'])->from("presse@gathering.org")->send();

                //Mail to press crew
                $accreditationRecievedMail = new CakeEmail('default');
                $accreditationRecievedMail->viewVars(array('accreditation' => $this->request->data['Accreditation']));
                $accreditationRecievedMail->template('accreditation-received-'.$this->Wannabe->lang, 'plain')->emailFormat('text')->subject(__("Wannabe: New press applicant"))->to("presse@gathering.org")->from('wannabe@gathering.org')->send();

                $this->Flash->success(__("You have successfully registered. An e-mail has been sent to the specified e-mail address"));
                $this->set('registered', true);
            }
            else {
                $this->Flash->error(__("Something went wrong with your registration."));
            }
        }

        $this->set('title_for_layout', __('Register application'));
		if(!$this->Auth->isLoggedIn) {
            $this->layout = 'front-generic-long';
		}
        if(isset($_GET['iframe'])) {
            $this->layout = 'iframe';
        }
    }

    public function accept($id=0) {

        if(!$id) {
            $this->Flash->warning(__("You must select an accreditation"));
            $this->redirectEvent("/Accreditation/All");
        }

        $accreditation = $this->Accreditation->find('first', array(
            'conditions' => array(
                'Accreditation.id' => $id
                )
            ));

        if(!$accreditation) {
            $this->Flash->warning(__("Accreditation not found"));
            $this->redirectEvent("/Accreditation/All");
        }

        $this->Accreditation->acceptAccreditation($id);

        //Mail to press
        $accreditationConfirmationMail = new CakeEmail('default');
        $accreditationConfirmationMail->viewVars(array('accreditation' => $accreditation));
        $accreditationConfirmationMail->template('accreditation-approval-'.$this->Wannabe->lang, 'plain')->emailFormat('text')->subject(__("Press: Accreditation approval"))->to($accreditation['Accreditation']['email'])->from("presse@gathering.org")->send();
        //Mail to press crew
        $accreditationRecievedMail = new CakeEmail('default');
        $accreditationRecievedMail->viewVars(array('accreditation' => $accreditation));
        $accreditationRecievedMail->template('accreditation-approved-'.$this->Wannabe->lang, 'plain')->emailFormat('text')->subject(__("Wannabe: Press accreditation approved"))->to("presse@gathering.org")->from('wannabe@gathering.org')->send();

        $this->Flash->success(__("Accreditation was successfully accepted"));
        $this->redirectEvent("/Accreditation/Edit/{$id}");

    }

    public function decline($id=0) {

        if(!$id) {
            $this->Flash->warning(__("You must select an accreditation"));
            $this->redirectEvent("/Accreditation/All");
        }

        $accreditation = $this->Accreditation->find('first', array(
            'conditions' => array(
                'Accreditation.id' => $id
                )
            ));

        if(!$accreditation) {
            $this->Flash->warning(__("Accreditation not found"));
            $this->redirectEvent("/Accreditation/All");
        }

        $this->Accreditation->declineAccreditation($id);

        //Mail to press
        $accreditationConfirmationMail = new CakeEmail('default');
        $accreditationConfirmationMail->viewVars(array('accreditation' => $accreditation ));
        $accreditationConfirmationMail->template('accreditation-declinal-'.$this->Wannabe->lang, 'plain')->emailFormat('text')->subject(__("Press: Accreditation declined"))->to($accreditation['Accreditation']['email'])->from("presse@gathering.org")->send();

        //Mail to press crew
        $accreditationRecievedMail = new CakeEmail('default');
        $accreditationRecievedMail->viewVars(array('accreditation' => $accreditation));
        $accreditationRecievedMail->template('accreditation-declined-'.$this->Wannabe->lang, 'plain')->emailFormat('text')->subject(__("Wannabe: Press accreditation declined"))->to("presse@gathering.org")->from('wannabe@gathering.org')->send();

        $this->Flash->success(__("Accreditation was successfully declined"));
        $this->redirectEvent("/Accreditation/Edit/{$id}");

    }

    public function group($group_id=0) {

        if(!$this->AccreditationAccess->hasAccessToGroup($this->Wannabe->user['User']['id'], $group_id) && !$this->Acl->hasAccess('manage')) {
            throw new ForbiddenException(__("You do not have access to this accreditation group"));
        }

        $this->set('group_id', $group_id);
        $this->set('name', $this->AccreditationGroup->find('first', array(
                                            'fields' => 'name',
                                            'conditions' => array(
                                                'id' => $group_id)
                                            )));
        $this->set('accreditations', $this->Accreditation->getAccreditationsForGroup($group_id));
        $this->set('title_for_layout', __("Accreditations"));
    }

    public function groupEdit($group_id=0, $accreditation_id=0) {

        if(!$this->AccreditationAccess->hasAccessToGroup($this->Wannabe->user['User']['id'], $group_id)) {
            throw new ForbiddenException();
        }

         if($this->request->is('post')) {

             if(!$accreditation_id) {
                $this->Flash->warning(__("Select accreditation to edit"));
                $this->redirectEvent("/Accreditation/Group/{$group_id}");
             }

            $this->request->data['Accreditation']['event_id'] = $this->Wannabe->event->id;
            if($this->request->data['Accreditation']['id'] != 0) {
                if($this->Accreditation->save($this->request->data)) {
                    $this->Flash->success(__("Accreditation was successfully saved"));
                }
                else {
                    $this->Flash->warning(__("Something went wrong with saving the accreditation"));
                }
            }
        }

		$box_into_header = array();
		$box_into_header['Header'] = __("Back");
		$box_into_header['Link'] = array();
		$box_into_header['Link'][] = array('class' => 'btn primary', 'href' => '/Accreditation/Group/'.$group_id, 'title' => __("Back"));
		$this->set('box_into_header', $box_into_header);
        $this->set('group_id', $group_id);
        $this->set('title_for_layout', __("Edit accreditation"));
        $this->set('accreditation', $this->Accreditation->find('first', array(
            'conditions' => array(
                'Accreditation.id' => $accreditation_id
                )
            )
        ));
    }

    public function groupCheckin($group_id=0, $id=0) {

        if(!$this->AccreditationAccess->hasAccessToGroup($this->Wannabe->user['User']['id'], $group_id)) {
            throw new ForbiddenException();
        }

        if(!$id) {
            $this->Flash->warning(__("You must select an accreditation to checkin"));
            $this->redirectEvent("/Accreditation/Group/{$group_id}");
        }

        $this->request->data['Accreditation']['id'] = $id;
        $this->request->data['Accreditation']['actual_arrival'] = date('Y-m-d H:i:s');

        if($this->Accreditation->save($this->request->data)) {
            $this->Flash->success(__("Accreditation was successfully checked in. Please update the badge ID if you have not already done so"));
            $this->redirectEvent("/Accreditation/GroupEdit/{$group_id}/{$id}");
        }
        else {
            $this->Flash->warning(__("Accreditation could not be checked in"));
            $this->redirectEvent("/Accreditation/Group/{$group_id}");
        }
    }

    public function groupCheckout($group_id=0, $id=0) {

        if(!$this->AccreditationAccess->hasAccessToGroup($this->Wannabe->user['User']['id'], $group_id)) {
            throw new ForbiddenException();
        }

        if(!$id) {
            $this->Flash->warning(__("You must select an accreditation to checkout"));
            $this->redirectEvent("/Accreditation/Group/{$group_id}");
        }

        $this->request->data['Accreditation']['id'] = $id;
        $this->request->data['Accreditation']['actual_departure'] = date('Y-m-d H:i:s');

        if($this->Accreditation->save($this->request->data)) {
            $this->Flash->success(__("Accreditation was successfully checked out"));
            $this->redirectEvent("/Accreditation/GroupEdit/{$group_id}/{$id}");
        }
        else {
            $this->Flash->warning(__("Accreditation could not be checked out"));
            $this->redirectEvent("/Accreditation/Group/{$group_id}");
        }
    }

    public function groupResetCheckinOut($group_id=0, $id=0) {

        if(!$this->AccreditationAccess->hasAccessToGroup($this->Wannabe->user['User']['id'], $group_id)) {
            throw new ForbiddenException();
        }

        if(!$id) {
            $this->Flash->warning(__("You must select an accreditation to reset"));
            $this->redirectEvent("/Accreditation/Group/{$group_id}");
        }

        $this->request->data['Accreditation']['id'] = $id;
        $this->request->data['Accreditation']['actual_arrival']     = '0000-00-00 00:00:00';
        $this->request->data['Accreditation']['actual_departure']   = '0000-00-00 00:00:00';

        if($this->Accreditation->save($this->request->data)) {
            $this->Flash->success(__("Accreditation was successfully reset"));
            $this->redirectEvent("/Accreditation/GroupEdit/{$group_id}/{$id}");
        }
        else {
            $this->Flash->warning(__("Accreditation could not be reset"));
            $this->redirectEvent("/Accreditation/Group/{$group_id}");
        }
    }
}

?>
