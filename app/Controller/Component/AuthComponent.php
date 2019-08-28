<?php

/**
 * Component that handles authentication
 */
class AuthComponent extends Component {

	var $components = array('Cookie');
	var $controller;
	var $isLoggedin = false;
	var $allowUserAuthCookie = false;

	public function initialize(Controller $controller) {
		//save controller for later use
		$this->controller = &$controller;
		$this->User = $controller->User;

		$cookie = null;

		if (!empty(Configure::read('AuthCookieKey'))) {
			$this->allowUserAuthCookie = true;
		}

		if ($this->allowUserAuthCookie) {
			// Configure User Auth Cookie
			$this->Cookie->name = 'WB';
			$this->Cookie->key = Configure::read('AuthCookieKey');

			$sessionIni = Configure::read('Session.ini');
			$this->Cookie->domain = $sessionIni['session.cookie_domain'];

			//Read Cookie
			$cookie = $this->Cookie->read('User.auth');
		}

        //check if user has a session active
		if(null != CakeSession::read('User.login')) {
			$controller->Wannabe->user = CakeSession::read('User.login');
            if($this->changeCheck($controller)) {
                $controller->Wannabe->user = CakeSession::read('User.login');
                //Force reload if not member of crew
                if(!isset($controller->Wannabe->user['Crew'][0])) {
                    $this->reloadUserLogin($controller->Wannabe->user['User']['id']);
                }
                WB::$user = $controller->Wannabe->user;
                $this->isLoggedIn = true;
            } else {
                $controller->Wannabe->user = array();
            }
		} else if(!is_null($cookie)) {
			if($this->login($cookie['user'], $cookie['pass'])) {
				$controller->Wannabe->user = CakeSession::read('User.login');
                if($this->changeCheck($controller)) {
                    $controller->Wannabe->user = CakeSession::read('User.login');
                    //Force reload if not member of crew
                    if(!isset($controller->Wannabe->user['Crew'][0])) {
                        $this->reloadUserLogin($controller->Wannabe->user['User']['id']);
                    }
                    WB::$user = $controller->Wannabe->user;
                    $this->isLoggedIn = true;
                } else {
                    $controller->Wannabe->user = array();
                    $this->Cookie->delete('User.auth');
                }
			} else {
				$this->Cookie->delete('User.auth');
			}
		}

		//Turn off required login for Error pages to avoid redirects away from them
		if($controller->name == 'CakeError') {
			$controller->requireLogin = false;
		}

		//Throw away users trying to go directly to login
		if(substr($controller->here, 0, 6) == '/Login') {
			$controller->redirect('/');
        }
	}
	public function startup(Controller $controller) {
		//We are not logged in, redirect
		if(!$this->isLoggedIn && $controller->requireLogin) {
			if($controller->here != '/'.$controller->Wannabe->event->reference.'/') {
				$controller->Flash->info(__('The page “%s” requires login.', $controller->here));
			}
			$controller->redirect("/{$controller->Wannabe->event->reference}/Login");
		}
	}
    public function changeCheck(&$controller) {
        $user = &$controller->Wannabe->user;
        App::import('Model', 'User');
        $userModel = new User();
        $hash = $userModel->getUserHash($user);
        if(isset($hash['UserProfileHash']['hash'])) {
            if($hash['UserProfileHash']['hash'] != $user['UserProfileHash']['hash'] || $controller->changedEvent) {
                return $this->reloadLogin($user['User']['username'], $user['User']['password']);
            } else if (empty($hash)) {
                $userModel->setUserHash($user);
                return $this->reloadLogin($user['User']['username'], $user['User']['password']);
            }
        }
        return true;
    }
    public function reloadLogin($username, $password) {
        CakeSession::delete('aclCache');
        CakeSession::delete('userMenu-nob');
        CakeSession::delete('userMenu-eng');
        return $this->login($username, $password);
    }
	public function login($login, $pass, $remember=0) {
		$userGoingIn = $this->User->findByUsername($login);
		if(!$userGoingIn) {
			$userGoingIn = $this->User->findByEmail($login);
		}
		if(!$userGoingIn) {
			return false;
		}
		if (!$this->User->correctPassword($userGoingIn, $pass)) {
			return false;
		}
		$this->User->keepPasswordHashUpToDate($userGoingIn, $pass);
		if ($this->allowUserAuthCookie) {
			$cookie = $this->Cookie->read('User.auth');
			if(is_null($cookie)) {
				$cookie = array();
				$cookie['user'] = $userGoingIn['User']['username'];
				$cookie['pass'] = $userGoingIn['User']['password'];
				if($remember) {
					$this->Cookie->write('User.auth', $cookie, true, '+4 weeks');
				} else {
					$this->Cookie->write('User.auth', $cookie, true, '+1 weeks');
				}
			}
		}
		CakeSession::write('User.login',$userGoingIn);
		return true;
	}
	public function reloadUserLogin($userId) {
		App::import('Model', 'User');
		$user = new User();
		$userGoingIn = $user->findById($userId);
		CakeSession::write('User.login',$userGoingIn);
		$this->controller->Wannabe->user = $userGoingIn;
		WB::$user = $this->controller->Wannabe->user;
	}
}
