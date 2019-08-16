<?php
class AdminController extends AppController {

	public $uses =  array('User');

	/**
	 * Change to another user
	 **/
	function Sudo() {
		$uid = $this->request->params['named']['user'];
		if(is_numeric($uid)) {
			$userGoingIn = $this->User->findById($uid);
			if($userGoingIn) {
				CakeSession::write('sudoFrom', CakeSession::read('User.login'));
                                CakeSession::write('User.login',$userGoingIn);
                                $this->Wannabe->user = CakeSession::read('User.login');
                                WB::$user = $this->Wannabe->user;
                                CakeSession::delete('aclCache');
				$this->Flash->info(__("You are in sudo mode"));
                $this->redirect($this->referer());
			}
		}
	}
}
