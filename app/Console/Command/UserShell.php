<?php
class UserShell extends AppShell {
    public $uses = array('User');

	public function getOptionParser() {
		$parser = parent::getOptionParser();
		$parser
			->addSubcommand('disable', array(
				'help' => 'Disable a user account by soft-deleting it',
				'parser' => array(
					'arguments' => array(
						'id' => array('help' => 'User id number', 'required' => true),
					)
				)
			))
			->addSubcommand('enable', array(
				'help' => 'Enable a user account by removing soft-delete from it',
				'parser' => array(
					'arguments' => array(
						'id' => array('help' => 'User id number', 'required' => true),
					)
				)
			));
		return $parser;
	}

	public function show() {
		$this->User->loadExtras = false;
		$user = $this->User->findById($this->args[0]);
		if (empty($user)) {
			$this->out("User id not found");
			return;
		}

		unset($user['User']['password']);
		unset($user['User']['verificationcode']);

		$this->out(print_r($user));
	}

	public function disable() {
		$this->User->loadExtras = false;
		$user = $this->User->findById($this->args[0]);
		if (empty($user)) {
			$this->out("User id not found");
			return;
		}

		$this->User->id = $user['User']['id'];
		if ($this->User->saveField('deleted', date('Y-m-d H:i:s'))) {
			$this->User->setUserHash($user);
			$this->out("User " . $user['User']['id'] . " (". $user['User']['email'] . ") disabled.");
		} else {
			$this->out("Error while trying to disable " . $user['User']['id'] . " (". $user['User']['email'] . ")");
		}
	}

	public function enable() {
		$this->User->loadExtras = false;
		$user = $this->User->findById($this->args[0]);
		if (empty($user)) {
			$this->out("User id not found");
			return;
		}

		$this->User->id = $user['User']['id'];
		if ($this->User->saveField('deleted',  '0000-00-00 00:00:00')) {
			$this->User->setUserHash($user);
			$this->out("User " . $user['User']['id'] . " (". $user['User']['email'] . ") enabled.");
		} else {
			$this->out("Error while trying to enable " . $user['User']['id'] . " (". $user['User']['email'] . ")");
		}
	}
}
