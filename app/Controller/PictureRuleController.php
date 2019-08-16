<?php
/**
 * PictureRules Controller
 *
 * @property PictureRule $PictureRule
 */
class PictureRuleController extends AppController {

    var $uses = array('PictureRule');
/**
 * index method
 *
 * @return void
 */
    public function index() {
		$this->PictureRule->recursive = 0;
		$this->set('rules', $this->paginate());
        $this->set('title_for_layout', __("Rules for picture upload"));
        $this->set('desc_for_layout', __("View all rules"));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
        $this->set('langs', $this->Language->localeMap);
		if ($this->request->is('post')) {
			$this->PictureRule->create();
            $saveall = true;
            foreach($this->Language->localeMap as $lang => $locale) {
                $this->PictureRule->locale = $lang;
                $rule = array(
                    'PictureRule' => $this->request->data['PictureRule'][$lang]
                );
                if(!$this->PictureRule->save($rule)) {
                    $saveall = false;
                }
            }
			if ($saveall) {
				$this->Flash->success(__("The picture rule has been saved"));
				$this->redirectEvent('/PictureRule');
			} else {
				$this->Flash->error(__('The picture rule could not be saved. Please, try again.'));
			}
		}
        $this->set('title_for_layout', __("Rules for picture upload"));
        $this->set('desc_for_layout', __("Create new rule"));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
        $this->set('langs', $this->Language->localeMap);
		$this->PictureRule->id = $id;
		if (!$this->PictureRule->exists()) {
			throw new NotFoundException(__('Invalid picture rule'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
            $saveall = true;
            foreach($this->Language->localeMap as $lang => $locale) {
                $this->PictureRule->locale = $lang;
                $rule = array(
                    'PictureRule' => $this->request->data['PictureRule'][$lang]
                );
                if(!$this->PictureRule->save($rule)) {
                    $saveall = false;
                }
            }
			if ($saveall) {
				$this->Flash->success(__("The picture rule has been saved"));
				$this->redirectEvent('/PictureRule');
			} else {
				$this->Flash->error(__('The picture rule could not be saved. Please, try again.'));
                $this->set('rule', $this->request->data);
			}
		} else {
            $this->PictureRule->bindTranslation(array(
                'denied_text' => 'deniedTranslation',
                'rule_text' => 'ruleTranslation'
            ));
            $this->PictureRule->recursive = 1;
			$this->set('rule', $this->PictureRule->read(null, $id));
		}
        $this->set('title_for_layout', __("Rules for picture upload"));
        $this->set('desc_for_layout', __("Edit rule"));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			$this->set('rule', $this->PictureRule->read(null, $id));
            $this->set('title_for_layout', __("Rules for picture upload"));
            $this->render();
		}
		$this->PictureRule->id = $id;
		if (!$this->PictureRule->exists()) {
			throw new NotFoundException(__('Invalid picture rule'));
		}
		if ($this->PictureRule->delete()) {
			$this->Flash->success(__("Picture rule deleted"));
            $this->redirectEvent('/PictureRule');
		}
		$this->Flash->error(__("Picture rule was not deleted"));
        $this->redirectEvent('/PictureRule');
	}
}
