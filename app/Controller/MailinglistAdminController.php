<?php
/**
 * MailinglistAdmin Controller
 *
 */
class MailinglistAdminController extends AppController {
	public $uses = array('Mailinglist', 'Mailinglistrule', 'Mailinglistaddress', 'MailinglistaddressCrewnew', 'Crew', 'User', 'MailinglistruleTeam', 'MailinglistruleUser', 'MailinglistruleCrewnew', 'Team');

    var $layout = 'responsive-default';

	public function index() {
		$this->set('title_for_layout', __("Mailinglist admin"));
		$this->set('desc_for_layout', __("Select list to administrate, or create new"));
		$this->set('mailinglists', $this->Mailinglist->find('list', array(
			'conditions' => array(
				'Mailinglist.event_id' => $this->Wannabe->event->id
			),
			'order' => 'address ASC'
		)));
	}
	public function rule($address=null) {
		if($address==null) {
			$this->Flash->warning(__("Please select list"));
			$this->redirectEvent('/MailinglistAdmin');
		}
		$db = ConnectionManager::getDataSource("default");
		$list = $this->Mailinglist->find('first', array(
			'conditions' => array(
				'Mailinglist.address' => $address,
				'Mailinglist.event_id' => $this->Wannabe->event->id
			)
		));
		if(!is_array($list)) {
			throw new BadRequestException(__("No such list"));
		}
		$this->set('list', $list);
		$this->set('title_for_layout', $list['Mailinglist']['address']);
		$this->set('desc_for_layout', __("Show rules/members"));
		$this->set('rules', $this->Mailinglistrule->find('all', array(
			'conditions' => array(
				'Mailinglistrule.mailinglist_id' => $list['Mailinglist']['id']
			)
		)));
		$this->set('userRules', $this->MailinglistruleUser->find('all', array(
			'conditions' => array(
				'MailinglistruleUser.mailinglist_id' => $list['Mailinglist']['id']
			)
		)));
		$this->set('teamRules', $this->MailinglistruleTeam->find('all', array(
			'conditions' => array(
				'MailinglistruleTeam.mailinglist_id' => $list['Mailinglist']['id']
			)
		)));
		$this->set('crewnewRules', $this->MailinglistruleCrewnew->find('all', array(
			'conditions' => array(
				'MailinglistruleCrewnew.mailinglist_id' => $list['Mailinglist']['id']
			)
		)));
        // Get members fro mregular mailinglist rules
        $this->set('members', $db->fetchAll("call mailinglistaddresses(:mailinglistid)", array("mailinglistid" => $list['Mailinglist']['id'])));
        /* Old method: $this->set('members', $this->Mailinglistaddress->find('all', array(
			'conditions' => array(
				'Mailinglistaddress.mailinglist' => $list['Mailinglist']['address']
			),
			'order' => 'Mailinglistaddress.realname ASC'
		)));*/

        // Get members from view supplying new crew
        $this->set('membersCrewnew', $this->MailinglistaddressCrewnew->find('all', array(
			'conditions' => array(
				'MailinglistaddressCrewnew.mailinglist' => $list['Mailinglist']['address']
			),
			'order' => 'MailinglistaddressCrewnew.realname ASC'
		)));

		$this->set('teams', $this->Crew->getTeamList());
		$this->set('crews', $this->Crew->getAllCrews(true, 0, true));
		$this->set('roles', $this->Crew->getUserRoles());
	}
	public function membership() {
		if($this->request->is('get') && isset($_GET['user_id'])) {
			$user = $this->User->find('first', array(
				'conditions' => array(
					'User.id' => $_GET['user_id']
				)
			));
			if(!is_array($user)) {
				throw new BadRequestException(__("No such user"));
			}
			$this->set('user', $user);
			$this->set('title_for_layout', __("Membership for %s", $user['User']['realname']));
			$this->set('desc_for_layout', __("See all lists %s is subscribed to", $user['User']['email']));
			$this->set('lists', $this->Mailinglistaddress->find('all', array(
				'conditions' => array(
					'Mailinglistaddress.address' => $user['User']['email'],
					'Mailinglistaddress.event_id' => $this->Wannabe->event->id
				)
			)));
		} else {
			$this->Flash->error(__("No user_id set"));
			$this->redirectEvent('/MailinglistAdmin');
		}
	}
	public function create() {
		if($this->request->is('post')) {
			$this->request->data['Mailinglist']['event_id'] = $this->Wannabe->event->id;
			if($this->Mailinglist->save($this->request->data)) {
				$this->Flash->success(__("List created"));
				$this->redirectEvent('/MailinglistAdmin');
			}
		}
		$this->set('title_for_layout', __("Create new list"));
		$this->set('crews', $this->Crew->getAllCrews(true, 0, true));
	}
	public function edit($id=0) {
		if($this->request->is('post')) {
			$this->request->data['Mailinglist']['event_id'] = $this->Wannabe->event->id;
			if($this->Mailinglist->save($this->request->data)) {
				$this->Flash->success(__("List saved"));
				$this->redirectEvent('/MailinglistAdmin');
			}
		}
		if(!$id) {
			$this->Flash->warning(__("Select list to edit"));
			$this->redirectEvent('/MailinglistAdmin');
		}
		$list = $this->Mailinglist->find('first', array(
			'conditions' =>	array(
				'Mailinglist.id' => $id,
				'Mailinglist.event_id' => $this->Wannabe->event->id
			)
		));
		if(!is_array($list)) {
			throw new BadRequestException(__("No such list"));
		}
		$this->set('list', $list);
		$this->set('title_for_layout', __("Edit list"));
		$this->set('desc_for_layout', $list['Mailinglist']['address']);
		$this->set('crews', $this->Crew->getAllCrews(true, 0, true));
	}
	public function delete($id=0) {
		if($this->request->is('post')) {
			if($this->Mailinglist->delete($this->request->data['Mailinglist']['id'])) {
				$this->Flash->success(__("List deleted"));
				$this->redirectEvent('/MailinglistAdmin');
			}
		}
		if(!$id) {
			$this->Flash->warning(__("Select list to delete"));
			$this->redirectEvent('/MailinglistAdmin');
		}
		$list = $this->Mailinglist->find('first', array(
			'conditions' =>	array(
				'Mailinglist.id' => $id,
				'Mailinglist.event_id' => $this->Wannabe->event->id
			)
		));
		if(!is_array($list)) {
			throw new BadRequestException(__("No such list"));
		}
		$this->set('list', $list);
		$this->set('title_for_layout', __("Delete list"));
		$this->set('desc_for_layout', $list['Mailinglist']['address']);
	}
	public function rulecreate($type=null, $list=null) {
		if(!$list || !$type)
			$this->redirectEvent('/MailinglistAdmin');
		$list = $this->Mailinglist->find('first', array(
			'conditions' => array(
				'Mailinglist.address' => $list,
				'Mailinglist.event_id' => $this->Wannabe->event->id
			)
		));
		if(!is_array($list))
			throw new BadRequestException(__("No such list"));
		$types = $this->getRuleTypes();
		if(!in_array($type, $types))
			$this->redirectEvent('/MailinglistAdmin/Rule'.$list['Mailinglist']['address']);
		if($type == 'crew')
			$type = '';
		if($type == 'crewnew') {
			$crewnew = array(
				'MailinglistruleCrewnew' => array(
					'mailinglist_id' => $list['Mailinglist']['id']
				)
			);
			$this->MailinglistruleCrewnew->save($crewnew);
			$this->Flash->success(__("Added rule for all new crew."));
			$this->redirectEvent('/MailinglistAdmin/Rule/'.$list['Mailinglist']['address']);
		}
		$ruleModelName = 'Mailinglistrule'.ucfirst($type);
		if($this->request->is('post')) {
			if($type == 'team') {
				$this->Team->lockTeam($this->request->data['MailinglistruleTeam']['team_id']);
			}
			$this->request->data[$ruleModelName]['mailinglist_id'] = $list['Mailinglist']['id'];
			$this->request->data[$ruleModelName]['action'] = 'add';
			if($this->$ruleModelName->save($this->request->data)) {
				$this->Flash->success(__("Rule created"));
				$this->redirectEvent('/MailinglistAdmin/Rule/'.$list['Mailinglist']['address']);
			}
		}
		$this->set('list', $list);
		$this->set('title_for_layout', __("Create rule"));
		$this->set('crews', $this->Crew->getAllCrews(true, 0, true));
		$this->set('teams', $this->Crew->getTeamList());
		$this->set('roles', $this->Crew->getUserRoles());
		if($type)
			$type = '_'.$type;
		$this->render('rule_create'.$type);
	}
	public function rulechange($list=null, $id=0) {
		if(!$list) {
			$this->redirectEvent('/MailinglistAdmin');
		}
		$list = $this->Mailinglist->find('first', array(
			'conditions' => array(
				'Mailinglist.address' => $list,
				'Mailinglist.event_id' => $this->Wannabe->event->id
			)
		));
		if(!is_array($list)) {
			throw new BadRequestException(__("No such list"));
		}
		if($this->request->is('post')) {
			$this->request->data['Mailinglistrule']['mailinglist_id'] = $list['Mailinglist']['id'];
			$this->request->data['Mailinglistrule']['action'] = 'add';
			if($this->Mailinglistrule->save($this->request->data)) {
				$this->Flash->success(__("Rule changed"));
				$this->redirectEvent('/MailinglistAdmin/Rule/'.$list['Mailinglist']['address']);
			}
		}
		if(!$id) {
			$this->Flash->warning(__("Select rule to change"));
			$this->redirectEvent('/MailinglistAdmin/Rule/'.$list['Mailinglist']['address']);
		}
		$rule = $this->Mailinglistrule->find('first', array(
			'conditions' =>	array(
				'Mailinglistrule.id' => $id
			)
		));
		if(!is_array($rule)) {
			throw new BadRequestException(__("No such rule"));
		}
		$this->set('list', $list);
		$this->set('rule', $rule);
		$this->set('title_for_layout', __("Change rule"));
		$this->set('crews', $this->Crew->getAllCrews(true, 0, true));
		$this->set('roles', $this->Crew->getUserRoles());
	}

	public function ruledelete($type=null, $list=null, $id=0) {

		if(!$list) {
			$this->redirectEvent('/MailinglistAdmin');
		}
		$types = $this->getRuleTypes();
		var_dump($type);
		if(!in_array($type, $types)) {
			$this->redirectEvent('/MailinglistAdmin');
        }

		if($type == 'crewnew') {
			$this->MailinglistruleCrewnew->delete($id);
			$this->Flash->success(__("Rule deleted"));
			$this->redirectEvent('/MailinglistAdmin/Rule/'.$list);
        }

		if($type == 'crew') {
			$type = '';
        }

		$ruleModelName = 'Mailinglistrule'.ucfirst($type);
		if($this->request->is('post')) {
			if($type == 'team') {
				$this->Team->unlockTeam($this->request->data['MailinglistruleTeam']['team_id']);
			}
			if($this->$ruleModelName->delete($this->request->data[$ruleModelName]['id'])) {
				$this->Flash->success(__("Rule deleted"));
				$this->redirectEvent('/MailinglistAdmin/Rule/'.$list);
			}
		}

		if(!$id) {
			$this->Flash->warning(__("Select rule to delete"));
			$this->redirectEvent('/MailinglistAdmin/Rule/'.$list);
		}

		$rule = $this->$ruleModelName->find('first', array(
			'conditions' =>	array(
				$ruleModelName.'.id' => $id
			)
		));

		if(!is_array($rule)) {
			throw new BadRequestException(__("No such rule"));
		}

		$this->set('list', $list);
		$this->set('rule', $rule);
		$this->set('title_for_layout', __("Delete rule"));

		if($type) {
			$type = '_'.$type;
        }
		$this->render('rule_delete'.$type);
	}

	private function getRuleTypes() {
		return array('crew', 'team', 'user', 'crewnew');
	}
}
