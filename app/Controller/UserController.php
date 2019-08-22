<?php
class UserController extends AppController {

	public $uses =  array('User');
	var $requireLogin = false;

	public function register() {
		if($this->request->is('post')) {
			if(Validation::email($this->data['email'])) {
				if(!$this->registerUser($this->data['email'])) {
					$this->redirect($this->data['was']);
				} else {
					$this->redirect('/'.$this->Wannabe->event->reference.'/Login');
				}
			} else {
				$this->Flash->error(__("I don\'t know about you, but where we come from that is not a valid email address. Please try again."));
				$this->redirect($this->data['was']);
			}
		} else {
			$form = array(
				'action' => $this->here,
				'button' => array(
					array(
						'type' => 'submit',
						'class' => 'primary',
						'id' => 'create_user_submit_button',
						'text' => __("Create")
					)
				)
			);
			$this->set('form', $form);
			$this->set('title_for_layout', __("Create new user"));
			$previousEmail = CakeSession::read('emailTried');
			if($previousEmail) {
				$this->set('previous', $previousEmail);
				CakeSession::delete('emailTried');
			}
			$this->layout = 'front-generic';
			$ajax = false;
			if($this->request->is('ajax')) {
				$ajax = true;
				$this->layout = 'modal';
			}
			$this->set('ajax', $ajax);
		}
	}

	public function forgot() {
		if($this->data) {
			if(Validation::email($this->data['email'])) {
				if(!$this->recoverUser($this->data['email'])) {
					$this->redirect($this->data['was']);
				} else {
					$this->redirect('/'.$this->Wannabe->event->reference.'/Login');
				}
			} else {
				$this->Flash->error(__("I don\'t know about you, but where we come from that is not a valid email address. Please try again."));
				$this->redirect($this->data['was']);
			}
		} else {
			$form = array(
				'action' => $this->here,
				'button' => array(
					array(
						'type' => 'submit',
						'class' => 'primary',
						'id' => 'reset_password_submit_button',
						'text' => __("Reset password")
					)
				)
			);
			$previousEmail = CakeSession::read('emailTried');
			if($previousEmail) {
				$this->set('previous', $previousEmail);
				CakeSession::delete('emailTried');
			}
			$this->set('form', $form);
			$this->set('title_for_layout', __("Forgot password"));
			$this->layout = 'front-generic';
			$ajax = false;
			if($this->request->is('ajax')) {
				$ajax = true;
				$this->layout = 'modal';
			}
			$this->set('ajax', $ajax);
		}
	}

	public function recover($code) {
		$user = $this->User->findByVerificationcode($code);
		if($user) {
			if($this->request->is('post')) {
				if($this->data['User']['id'] != $user['User']['id']) {
					$this->set('title_for_layout', "Never Gonna…");
					$this->layout = 'front-generic';
					$this->render('roll');
					return;
				}

				$this->User->set($this->data);
				if($this->User->validates()) {
					$savedata['User']['id'] = $this->data['User']['id'];
					$savedata['User']['password'] = $this->User->getPasswordHash($this->data['User']['newpassword1']);
					$savedata['User']['verificationcode'] = md5($user['User']['email']."-".microtime());
					if($this->User->save($savedata, false)) {
						$this->Flash->success(__("Password updated. You may now login."));
					} else {
						$this->Flash->error(__("Something went wrong. Try again."));
					}
					$this->redirect('/');
				} else {
					$this->validateErrors($this->User);
					$this->Flash->error(__("You have field errors. Please correct them and continue."));
				}
			}
			$this->set('user', $user);
			$form = array(
				'action' => $this->here,
				'button' => array(
					array(
						'type' => 'submit',
						'class' => 'primary',
						'id' => 'change_password_submit_button',
						'text' => __("Change password")
					)
				)
			);
			$this->set('form', $form);
			$this->set('title_for_layout', __("Reset password"));
			$this->layout = 'front-generic';
		} else {
			$this->Flash->error(__("Wrong code."));
			$this->redirect('/');
		}
	}

	public function verify($code) {
		$user = $this->User->findByVerificationcode($code);
		if($user && $user['User']['registered'] != 'done' && $user['User']['registered'] != 'edit') {
			$save['User']['id'] = $user['User']['id'];
			$changed = false;
			if(substr($user['User']['registered'],0,5) == 'email') {
				if($user['User']['username'] == $user['User']['email']) {
					$save['User']['username'] = substr($user['User']['registered'],6);
				}
				$save['User']['email'] = substr($user['User']['registered'],6);
				$save['User']['registered'] = 'done';
				$changed = true;
			}
			$save['User']['verified'] = date('Y-m-d H:i:s');
			$this->User->save($save, false);
			$user = $this->User->findById($user['User']['id']);
			CakeSession::write('User.login',$user);
			if($changed) {
				$this->Flash->success(__("Email verified."));
			} else {
				$this->Flash->success(__("Email verified. You can now complete your registration"));
			}
		} else {
			$this->Flash->error(__("Wrong code."));
		}
		$this->redirectEvent('/');
	}

	private function recoverUser($email) {
		$emailexists = $this->User->findByEmail($email);

		if($emailexists) {
			if($emailexists['User']['registered'] != 'done') {
				$this->Flash->error(__("You cannot reset your password as you have not completed your registration."));
				return false;
			}
			if($emailexists['User']['verified'] == '0000-00-00 00:00:00') {
				$this->Flash->error(__("You cannot reset your password as you have not verified your email address."));
				return false;
			}
			$validationCode = md5($email."-".microtime());
			$user['User']['id'] = $emailexists['User']['id'];
			$user['User']['verificationcode'] = $validationCode;
			if($this->User->save($user, false)) {
				$recoverEmail = new CakeEmail('default');
				$recoverEmail->viewVars(array('validation' => $validationCode, 'wannabe' => $this->Wannabe));
				$recoverEmail->template('recover-'.$this->Wannabe->lang, 'plain')->emailFormat('text')->subject(__("Wannabe: Forgot password"))->to($email)->send();
				$this->Flash->success(__('An email has been sent to “%s”. Click the link in the email to reset your password.', $email));
				return true;
			} else {
				CakeSession::write('emailTried',$email);
				$this->Flash->error(__('An error has occured while trying to save your user. Please try again. If the problem persists please contact %s', '<a href="mailto:wannabe@gathering.org">Core:Systems</a>'));
				return false;
			}
		} else {
			CakeSession::write('emailTried',$email);
			$this->Flash->error(__("The email address you entered is not registered. Maybe you mistyped?"));
			return false;
		}
	}
	private function registerUser($email) {
		$emailexists = $this->User->findByEmail($email);

		if(!$emailexists || ($emailexists && !$emailexists['User']['verified'])) {
			$validationCode = md5($email."-".microtime());
			$user['User']['email'] = $email;
			$user['User']['username'] = $email;
			// Set password to random non-guessable and non-md5 value to make password login _mostly_ unusable.
			// Just in case any api allows password lookup on unverified/pending accounts by mistake via hash or plain text.
			$pseudoBytes = openssl_random_pseudo_bytes(100);
			if ($pseudoBytes) {
				$user['User']['password'] = bin2hex($pseudoBytes);
			} else {
				$user['User']['password'] = sha1($email."-".microtime());
			}
			$user['User']['verificationcode'] = $validationCode;
			$user['User']['registered'] = 'password';
			if($this->User->save($user, false)) {
				$registerEmail = new CakeEmail('default');
				$registerEmail->viewVars(array('validation' => $validationCode, 'wannabe' => $this->Wannabe));
				$registerEmail->template('register-'.$this->Wannabe->lang, 'plain')->emailFormat('text')->subject(__("Wannabe: New account"))->to($email)->send();
				$this->Flash->success(__('An email has been sent to “%s”. Click the link in the email to continue registration.', $email));
				return true;
			} else {
				CakeSession::write('emailTried',$email);
				$this->Flash->error(__('An error has occured while trying to save your user. Please try again. If the problem persists please contact %s', '<a href="mailto:wannabe@gathering.org">Core:Systems</a>'));
				return false;
			}
		} else {
			CakeSession::write('emailTried',$email);
			$this->Flash->error(__('The email address you entered is already registered. If this account is yours you can %s click here %s to login.','<a href="/'.$this->Wannabe->event->reference.'/Login" title="Login page">', '</a>'));
			return false;
		}
	}
	public function logout() {
		if(CakeSession::check('User.login')) {
			//Jump out of sudo if in it
			if(CakeSession::check('sudoFrom')) {
				CakeSession::write('User.login',CakeSession::read('sudoFrom'));
                CakeSession::delete('aclCache');
				CakeSession::delete('sudoFrom');
				$this->Flash->info(__("You have un-sudoed"));
			} else {
                $this->response->disableCache();
                $this->Session->delete('Auth.User');
                $this->Session->delete('User');
                $this->Session->destroy();
                $this->Cookie->destroy();
				$this->Flash->info(__("You have been logged out"));
			}
		}
		$this->redirectEvent('/');
	}
	public function language($lang = 'eng') {
		if(CakeSession::read('Config.language') != $lang && $this->Language->valid($lang)) {
			if(CakeSession::check('User.login')) {
				$savedata['User']['id'] = $this->Wannabe->user['User']['id'];
				$savedata['User']['language'] = $lang;
				$this->User->save($savedata);
				CakeSession::write('User.login', $this->User->findById($this->Wannabe->user['User']['id']));
			}
			CakeSession::write('Config.language', $lang);
		}
		$this->redirect($this->referer());
	}
}
?>
