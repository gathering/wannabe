<?php

/**
 * Component that handles localization
 */
class LanguageComponent extends Component {

	var $lang;
    var $localeMap = array(
        'nob' => 'nb_NO.utf8',
        'eng' => 'en_US.utf8'
    );
    var $langMap = array(
        'nob' => 'nb',
        'eng' => 'en'
    );

	public function initialize(Controller $controller) {
        if(isset($controller->request->query['hl']) && $this->valid($controller->request->query['hl'])) {
            $this->lang = $controller->request->query['hl'];
        } else if(isset($controller->Wannabe->user['User'])) {
			if($controller->Wannabe->user['User']['language'] == '') {
				$this->lang = $this->getLocale();
				App::import('Model', 'User');
				$users = new User();
				$savedata['User']['id'] = $controller->Wannabe->user['User']['id'];
				$savedata['User']['language'] = $this->lang;
				$users->save($savedata);
				$controller->Auth->reloadUserLogin($controller->Wannabe->user['User']['id']);
			} else {
				$this->lang = $controller->Wannabe->user['User']['language'];
			}
		} else {
			$this->lang = $this->getLocale();
		}
		Configure::write('Config.language', $this->lang);
		CakeSession::write('Config.language', $this->lang);
	 	$controller->Wannabe->lang = $this->lang;
	 	$controller->Wannabe->langMap = $this->langMap;
        	setlocale(LC_TIME, $this->localeMap[$this->lang]);
	}
	public function valid($lang) {
		$localedir = ROOT.DS.APP_DIR.DS.'Locale';
		$dir = scandir($localedir);
		$ignore = array(".", "..");
		$dir = array_diff($dir, $ignore);
		foreach($dir as $current) {
			if(is_dir($localedir.'/'.$current) && $current == $lang) {
				return true;
			}
		}
		return false;
	}
	public function getLocale() {
		if(CakeSession::check('Config.language')) {
			return CakeSession::read('Config.language');
		}
		App::import('I18n', 'L10n');
		$this->L10n = new L10n();
		$this->L10n->get();
		$getlang = $this->L10n->locale;
		if($getlang == 'nor') {
			$getlang = 'nob';
		}
		if($this->valid($getlang)) {
			return $getlang;
		}
		return Configure::read('Config.language');
	}
}
