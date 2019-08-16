<?php

class DispatchController extends AppController {
	public $uses = array('User', 'Crew', 'DispatchProblem', 'DispatchCase');

	public function undelegatedcases() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			if(!isset($this->data['DispatchCase']['id']) || (int)$this->data['DispatchCase']['id'] == 0 ) {
				throw new ExceptionBase('Feil eller ikke spesifisert id i saken.');
			}

			$this->save('undelegated', $this->data);
			$this->redirect($this->here);
			return;
		}
		$this->set('cases', $this->DispatchCase->getUndelegated());
		$this->set('delegatednames', $this->DispatchCase->getDelegatedNames());
		$this->set('problemnames', $this->DispatchProblem->generateList());
		$this->set('priorities', $this->DispatchCase->getPriorities() );

	}

	public function delegatedcases() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			if(!isset($this->data['DispatchCase']['id']) || $this->data['DispatchCase']['id'] == 0) {
				throw new ExceptionBase('Feil eller ikke spesifisert id i saken.');
			}

			$this->save('delegated', $this->data);
			$this->redirect($this->here);
			return;
		}
		$this->set('cases', $this->DispatchCase->getDelegated());
		$this->set('delegatednames', $this->DispatchCase->getDelegatedNames());
		$this->set('problemnames', $this->DispatchProblem->generateList());
		$this->set('priorities', $this->DispatchCase->getPriorities() );
	}


	public function usercases($user_id=null) {
		if( (int)$user_id <= 0 )
			$user_id = $this->Wannabe->user['User']['id'];

		$this->set('cases', $this->DispatchCase->getUsercases($user_id));
		$this->set('delegatednames', $this->DispatchCase->getDelegatedNames());
		$this->set('problemnames', $this->DispatchProblem->generateList());
		$this->set('priorities', $this->DispatchCase->getPriorities() );
	}


	public function problems() {
		$problems = $this->DispatchProblem->find('all');

		if(!$this->Acl->hasAccess('write', $this->user)) {
			throw new Exception403('Ingen tilgang');
		}

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			if(isset($_REQUEST['save'])) {
				$locations = $this->splitsimplelist($this->data, 'DispatchProblem', array('name'));
				// Add the wanted storages
				foreach($locations['new'] as $newlocation) {
					if($newlocation !== null) {
						if(strlen($newlocation['DispatchProblem']['name']) > 1) {
							$this->DispatchProblem->create();
							$this->DispatchProblem->save($newlocation);
						}
					}
				}

				// Update the wanted storages
				foreach($locations['update'] as $updatelocation) {
					if(strlen($updatelocation['DispatchProblem']['name'])) {
						$this->DispatchProblem->save($updatelocation);
					}
				}

				//Delete
				foreach($locations['delete'] as $del) {
					$this->DispatchProblem->delete($del);
				}
			}
			$this->redirect($this->here);
			return;
		}
		$this->set('problems', $problems);
	}

	public function createCase() {
		if(!$this->Acl->hasAccess('write', $this->user)) {
			throw new Exception403('Du har ikke tilgang til &aring; opprette saker.');
		}

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$d = $this->data;
			$d['DispatchCase']['event_id'] = WB::$event->id;

			$delegated_user_id = $d['DispatchCase']['delegated_user_id'];
			unset($d['DispatchCase']['delegated_user_id']);

			$d['DispatchCase']['created_user_id'] = $this->Wannabe->user['User']['id'];
			$this->DispatchCase->create();
			$this->DispatchCase->save($d);

			if($delegated_user_id > 0) {
				$case_id = $this->DispatchCase->getLastInsertId();
				if($case_id > 0) {
					$this->DispatchCase->setDelegated($case_id, $delegated_user_id, $delegated_user_id);
				}
			}

			$this->redirect('/'.WB::$event->reference.'/dispatch/index');
			return;
		}

		$this->set('case', array('DispatchCase' => array('problem_id' => 0, 'row' => '', 'seat' => '', 'switch' => '', 'description' => '', 'priority' => 3, 'delegated_user_id' => 0)));
		$this->set('problemnames', $this->DispatchProblem->generateList());
		$this->set('delegatednames', $this->DispatchCase->getDelegatedNames());
		$this->set('canManageProblems', $this->Acl->hasAccess('write', $this->user, '/'.WB::$event->reference.'/dispatch/problems'));
		$this->set('priorities', $this->DispatchCase->getPriorities() );
	}

	function index() {
		$undelegated = $this->DispatchCase->getUndelegated();
		$delegated = $this->DispatchCase->getDelegated();
		$undelegatednum = count($undelegated);
		$delegatednum = count($delegated);
		$this->set('problemnames', $this->DispatchProblem->generateList());
		$this->set('delegatednames', $this->DispatchCase->getDelegatedNames());
		$this->set('priorities', $this->DispatchCase->getPriorities() );
		$this->set('cases', $delegated );
		$this->set('canManageProblems', $this->Acl->hasAccess('write', $this->user, '/'.WB::$event->reference.'/dispatch/problems'));
		$this->set('unresolvednum', 0);
		$this->set('resolvednum', 0);
		$this->set('undelegatednum', $undelegatednum);
		$this->set('delegatednum', $delegatednum);
	}
}
