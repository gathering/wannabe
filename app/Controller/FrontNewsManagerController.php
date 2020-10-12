<?php
/**
 * FrontNewsManager Controller
 *
 */
class FrontNewsManagerController extends AppController {

	public $uses = array('FrontNews');

	public function index() {
		$this->set('frontNews', $this->FrontNews->find('all'));
		$this->set('title_for_layout', __("Front news"));
	}
	public function view($id = null) {
		$this->FrontNews->id = $id;
		$news = $this->FrontNews->read();
		$this->set('frontNews', $news);
		$this->set('title_for_layout', $news['FrontNews']['name']);
	}
	public function add() {
		if($this->request->is('post')) {
			if($this->FrontNews->save($this->request->data)) {
				Cache::delete('news'.$this->Wannabe->lang);
				$this->Flash->success(__("The news has been saved."));
				$this->redirectEvent('/FrontNewsManager/');
			}
		}
		$this->set('title_for_layout', __("Add news"));
	}
	public function edit($id = null) {
		$this->FrontNews->id = $id;
		if($this->request->is('get')) {
			$this->request->data = $this->FrontNews->read();
		} elseif ($this->request->is('post')) {
			$this->FrontNews->locale = $this->request->data['locale'];
			if($this->FrontNews->save($this->request->data)) {
				Cache::delete('news'.$this->Wannabe->lang);
				$this->Flash->success(__("The news has been saved."));
				$this->redirectEvent('/FrontNewsManager/');
			}
		}
		$this->set('title_for_layout', __("Edit %s", $this->request->data['FrontNews']['name']));
	}

	// Automatically set locale for FrontNews and relevant page variables
	public function beforeFilter() {
		parent::beforeFilter();
		$reqLocale = '';

		// Get from query argument on get requests
		if ($this->request->is('get') && isset($this->request->query['locale'])) {
			$reqLocale = $this->request->query['locale'];
		}
		// Get from form data on post requests
		if ($this->request->is('post') && isset($this->request->data['locale'])) {
			$reqLocale = $this->request->data['locale'];
		}

		// Fall back to user/system defaults
		$locale = empty($reqLocale) ? $this->Wannabe->lang : $reqLocale;
		$this->FrontNews->locale = $locale;
		$this->set('desc_for_layout', $locale === 'nob' ? __("Norwegian translation") : __("English translation"));
	}
}
