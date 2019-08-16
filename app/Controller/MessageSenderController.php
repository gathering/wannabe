<?php
App::uses('AppController', 'Controller');
/**
 * MessageSenders Controller
 *
 * @property MessageSender $MessageSender
 */
class MessageSenderController extends AppController {
    var $uses = array('MessageSender');
/**
 * index method
 *
 * @return void
 */
    public function index() {
        $this->set('senders', $this->MessageSender->find('all', array(
            'conditions' => array(
                'MessageSender.event_id' => $this->Wannabe->event->id
            )
        )));
        $this->set('title_for_layout', __("Message senders"));
        $this->set('desc_for_layout', __("View all senders"));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->MessageSender->create();
            $this->request->data['MessageSender']['event_id'] = $this->Wannabe->event->id;
            if($this->MessageSender->save($this->request->data)) {
				$this->Flash->success(__("The sender has been saved"));
				$this->redirectEvent('/MessageSender');
			} else {
				$this->Flash->error(__('The sender could not be saved. Please, try again.'));
			}
		}
        $this->set('title_for_layout', __("Sender IDs for messages"));
        $this->set('desc_for_layout', __("Create new sender"));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->MessageSender->id = $id;
		if (!$this->MessageSender->exists()) {
			throw new NotFoundException(__('Invalid sender'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['MessageSender']['event_id'] = $this->Wannabe->event->id;
            if($this->MessageSender->save($this->request->data)) {
				$this->Flash->success(__("The sender has been saved"));
				$this->redirectEvent('/MessageSender');
			} else {
				$this->Flash->error(__('The sender could not be saved. Please, try again.'));
                $this->set('sender', $this->request->data);
			}
		} else {
			$this->set('sender', $this->MessageSender->read(null, $id));
		}
        $this->set('title_for_layout', __("Sender IDs for messages"));
        $this->set('desc_for_layout', __("Edit sender"));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			$this->set('sender', $this->MessageSender->read(null, $id));
            $this->set('title_for_layout', __("Sender IDs for messages"));
            $this->render();
		}
		$this->MessageSender->id = $id;
		if (!$this->MessageSender->exists()) {
			throw new NotFoundException(__('Invalid sender'));
		}
		if ($this->MessageSender->delete()) {
			$this->Flash->success(__("Sender deleted"));
            $this->redirectEvent('/MessageSender');
		}
		$this->Flash->error(__("Sender was not deleted"));
        $this->redirectEvent('/MessageSender');
    }
}
