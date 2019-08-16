<?php

App::uses('AppHelper', 'View/Helper'); //Leave this in since it causes a crash (due to bug: http://cakephp.lighthouseapp.com/projects/42648/tickets/1973-php-fatal-error-when-loading-custom-helper)
App::uses('CakeEmail', 'Network/Email');

class AppController extends Controller {

	// Load required components. Wannabe.Wannabe must be loaded first as it defines global variables
	public $components = array('Wannabe', 'Auth', 'Language', 'Acl', 'Menu', 'Session', 'Register', 'Cookie', 'TermHandler', 'TaskHandler', 'Flash');

	// Load default helpers for views
	public $helpers = array('Date', 'Session', 'Html', 'Form', 'Js', 'Wb');

	// Require login to pages by default
	public $requireLogin = true;

	// Will be set to true by WannabeComponent if user changed event since last request
	public $changedEvent = false;


	public function beforeFilter() {
		// Run Controllers beforeFilter()
		parent::beforeFilter();
		// Load localized views if they exist
		$locale = CakeSession::read('Config.language');
		if ($locale && file_exists(ROOT . DS . APP_DIR . DS . 'View' . DS . $this->viewPath . DS . $locale)) {
			$this->viewPath = $this->viewPath . DS . $locale;
		}
		$olang = array('nob', 'Norsk');
		if($olang[0] == $locale) {
			$olang = array('eng', 'English');
		}
		$this->set('olang', $olang);

		// Set global variable
		$this->set('wannabe', $this->Wannabe);
		$this->set('taskHandler', $this->TaskHandler);
		$this->writeWas($this->here);
        if(isset($this->Wannabe->user['User']['id']) and !CakeSession::check('sudoFrom'))
            $this->updateLatestActivity();
        if($this->Acl->forbidden) {
			throw new ForbiddenException();
        }
	}
	public function beforeRender() {
		parent::beforeRender();
	}
	public function redirectEvent($path) {
		return $this->redirect('/'.$this->Wannabe->event->reference.$path);
	}
	public function writeWas($here) {
		if($this->requireLogin && !preg_match("/^\/{$this->Wannabe->event->reference}(\/){0,1}$/i", $here) && !isset($this->params['requested'])) {
			CakeSession::write('User.was', $here);
		}
	}
	protected function redirectWas($altpath=0) {
		$was = CakeSession::read('User.was');
		if($was && $was != $this->here) {
			CakeSession::delete('User.was');
			$this->redirect($was);
		} else if($altpath) {
			$this->redirectEvent($altpath);
		} else {
			$this->redirectEvent('/');
		}
    }
    public function updateLatestActivity() {
        App::import('Model', 'User');
        $userModel = new User();
        return $userModel->updateLatestActivity($this->Wannabe->user['User']['id']);
    }
	public function calculateAge($date) {
		list($year, $month, $day) = explode('-', $date);
		$yearDiff = date('Y') - $year;
		$monthDiff = date('m') - $month;
		$dayDiff = date('d') - $day;

		if ( $monthDiff < 0 || (($monthDiff == 0) and ($dayDiff < 0)) ) {
			$yearDiff --;
		}
		return($yearDiff);
	}
	public function getCrewsForUser($user, $leader=0) {
		$crews = array();

		foreach ($user['Crew'] as $crew) {
			if ($leader <= $crew['CrewsUser']['leader'])
				$crews[] = $crew['id'];
		}

		return $crews;
	}

	public function splitsimplelist($data, $modelname, $fields) {
		$items['update'] = array();
		$items['delete'] = array();
		$items['new'] = array();

		foreach($data as $index => $value) {
			// Remove cake's security token if exists
			if($index != '_Token') {
				$curitem = array();
				$cmpitem = null;
				$changed = false;

				if((int)$index > 0) {
					$cmpitem = $this->$modelname->findById($index);
					if(!isset($cmpitem[$modelname]['id'])) {
						continue;
					}

					$curitem[$modelname]['id'] = $index;
				}

				foreach($fields as $fieldname) {
					$curitem[$modelname][$fieldname] = $value[$fieldname];

					if($cmpitem) {
						if($cmpitem[$modelname][$fieldname] != $curitem[$modelname][$fieldname])
						{
							$changed = true;
						}
					}
				}

				if($cmpitem) {
					if(isset($value['__delete__']) && $value['__delete__'] == 1) {
						$items['delete'][] = $curitem;
					}
					else if($changed) {
						$items['update'][] = $curitem;
					}
				}
				else {
					$items['new'][] = $curitem;
				}

				unset($curitem);
			}
		}
		return $items;
	}
}
