<?php
class CarplateController extends AppController {

	public function index()
	{
		$this->set('savebutton', __("Save"));
		$this->set('my_plate', $this->Carplate->find('first', array('conditions' => array('user_id' => $this->Wannabe->user['User']['id']))));

		if (!empty($this->request->data))
		{
			$data = $this->request->data;
			$data['Carplate']['user_id'] = $this->Wannabe->user['User']['id'];

			if ($this->Carplate->save($data))
				$this->Flash->success(__("Carplate was updated"));
			else
				$this->Flash->error(__("Unable to add carplate"));

			$this->redirectEvent('/Carplate');

		}

	}

}
