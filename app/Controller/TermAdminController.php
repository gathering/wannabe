<?php

class TermAdminController extends AppController {
	var $uses = array('Term', 'User');

	public function index() {
		$this->set('title_for_layout', __("Administer terms"));
		$this->set('terms', $this->Term->find('all', array(
			'conditions' => array(
				'Term.event_id' => $this->Wannabe->event->id
            ),
            'order' => 'updated DESC'
		)));
	}
	public function create() {
        $this->set('langs', $this->Language->localeMap);
		if($this->request->is('post')) {
			$this->request->data['Term']['event_id'] = $this->Wannabe->event->id;
			$this->request->data['Term']['updated'] = false;
            $saveall = true;
            foreach($this->Language->localeMap as $lang => $locale) {
                $this->Term->locale = $lang;
                $term = array(
                    'Term' => $this->request->data['Term']
                );
                $term['Term'] += $this->request->data['Term'][$lang];
                if(!$this->Term->save($term)) {
                    $saveall = false;
                }
            }
            if ($saveall) {
                $this->Flash->success(__("Term was created"));
                $this->redirectEvent('/TermAdmin');
			}
		}
		$this->set('title_for_layout', __("Create new term"));
	}
	public function edit($id=0) {
        $this->set('langs', $this->Language->localeMap);
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['Term']['event_id'] = $this->Wannabe->event->id;
			$this->request->data['Term']['updated'] = false;
            $saveall = true;
            foreach($this->Language->localeMap as $lang => $locale) {
                $this->Term->locale = $lang;
                $term = array(
                    'Term' => $this->request->data['Term']
                );
                $term['Term'] += $this->request->data['Term'][$lang];
                if(!$this->Term->save($term)) {
                    $saveall = false;
                }
            }
            if ($saveall) {
                $this->Flash->success(__("Term was saved"));
                $this->redirectEvent('/TermAdmin');
			}
		}
		if(!$id) {
			$this->Flash->warning(__("Select term to edit"));
			$this->redirectEvent('/TermAdmin');
		}
        $this->Term->bindTranslation(array(
            'title' => 'titleTranslation',
            'content' => 'contentTranslation'
        ));
        $this->Term->recursive = 1;
		$term = $this->Term->find('first', array(
			'conditions' => array(
				'Term.id' => $id,
				'Term.event_id' => $this->Wannabe->event->id
			)
		));
		if(!is_array($term)) {
			throw new BadRequestException(__("No such term"));
		}
		$this->set('term', $term);
		$this->set('title_for_layout', __("Edit term"));
	}
	public function delete($id) {
		if($this->request->is('post')) {
			if($this->Term->delete($this->request->data['Term']['id'])) {
				$term_id = $this->request->data['Term']['id'];
				$this->Flash->success(__("Term deleted"));
				$this->redirectEvent('/TermAdmin');
			}
		}
		if(!$id) {
			$this->Flash->warning(__("Select term to delete"));
			$this->redirectEvent('/TermAdmin');
		}
		$term = $this->Term->find('first', array(
			'conditions' => array(
				'Term.id' => $id,
				'Term.event_id' => $this->Wannabe->event->id
			)
		));
		if(!is_array($term)) {
			throw new BadRequestException(__("No such term"));
		}
		$this->set('term', $term);
		$this->set('title_for_layout', __("Delete term"));
	}
}
