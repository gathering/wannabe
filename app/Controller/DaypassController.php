<?php

class DaypassController extends AppController {

	public $uses = array('Daypass');

	public function index() {
		if (!empty($this->request->data)) {
			$data = $this->request->data;
			$data['Daypass']['user_id'] = $this->Wannabe->user['User']['id'];

			if ($this->Daypass->save($data))
				$this->Flash->success(__("Your information has been updated"));
			else
				$this->Flash->error(__("Unable to save your information"));

			$this->redirectEvent('/Daypass');
		}

        $this->request->data = $this->Daypass->find('first', array(
            'conditions' => array(
                'Daypass.user_id' => $this->Wannabe->user['User']['id']
            )
        ));

		$this->set('title_for_layout', __("Daypass"));
		$this->set('savebutton', __("Update information"));
	}

}
