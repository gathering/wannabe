<?php

class KeycardHandoutController extends AppController {

    public $uses = array('KeycardCard', 'KeycardHandout');

    public function index()
    {
        $this->set('title_for_layout', __("Key cards"));

        $eventid = $this->Wannabe->event->id;

        $handouts = $this->KeycardHandout->find('all', array('conditions' => array(
                'event_id' => $eventid), 'order' => array('KeycardHandout.card_id' => 'asc')
            ));

        $this->set('handouts', $handouts);
    }

    public function out()
    {
        $this->set('title_for_layout', __("Key cards"));

        if($this->request->is('post')) {

            $this->request->data['KeycardHandout']['event_id'] = $this->Wannabe->event->id;

            if($this->KeycardHandout->save($this->request->data)) {
                $this->KeycardCard->setHandedOut($this->request->data['KeycardHandout']['card_id'], $this->Wannabe->event->id);
                $this->Flash->success(__("Key card handed out!"));
                $this->redirectEvent('/KeycardHandout/');
            }
        }

        $this->set('cards', $this->KeycardCard->getCards($this->Wannabe->event->id));
    }

    public function in($id)
    {
        if($handout = $this->KeycardHandout->find('first', array('conditions' => array('KeycardHandout.id' => $id)))) {
            $this->KeycardCard->setHandedIn($handout['KeycardHandout']['card_id'], $this->Wannabe->event->id);
            if($this->KeycardHandout->delete($id)) {
                $this->Flash->success(__("Key card handed in"));
                $this->redirectEvent('/KeycardHandout/');
            }
        }
    }
}
