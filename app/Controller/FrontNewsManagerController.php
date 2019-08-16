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
			$this->FrontNews->locale = $this->Wannabe->lang;
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
		} else {
			$this->Post->locale = $this->Wannabe->lang;
			if($this->FrontNews->save($this->request->data)) {
				Cache::delete('news'.$this->Wannabe->lang);
				$this->Flash->success(__("The news has been saved."));
				$this->redirectEvent('/FrontNewsManager/');
			}
		}
		$this->set('title_for_layout', __("Edit %s", $this->request->data['FrontNews']['name']));
	}

}
