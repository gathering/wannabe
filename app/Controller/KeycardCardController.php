<?php

class KeycardCardController extends AppController {

    public function index() {

        $cards = $this->KeycardCard->find('all', array('conditions' => array(
            'KeycardCard.event_id' => $this->Wannabe->event->id)));
        $this->set('cards', $cards);
    }

    public function add() {
        if($this->request->is('post')) {
            $this->request->data['KeycardCard']['event_id'] = $this->Wannabe->event->id;
            if($this->KeycardCard->save($this->request->data)) {
                $this->Flash->success(__("Your card was saved"));
                $this->redirectEvent('/KeycardCard');
            }
        }
    }

    public function delete($id) {
        if($this->KeycardCard->delete($id)) {
            $this->Flash->success(__("The card was deleted"));
            $this->redirectEvent('/KeycardCard');
        }
    }
}
