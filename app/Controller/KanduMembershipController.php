<?php

class KanduMembershipController extends AppController {

    public $uses = array('User', 'KanduMembership','KanduMembershipSetting');
    var $layout = 'responsive-default';

    public function index() {
        $settings = $this->KanduMembershipSetting->query('SELECT `enabled`, `expires`, `year` FROM wb4_kandu_membership_settings WHERE event_id ='.$this->Wannabe->event->id);
        if($settings != null){
            $expires = $settings[0]['wb4_kandu_membership_settings']['expires'];
            $year = $settings[0]['wb4_kandu_membership_settings']['year'];
            $this->set('age', $this->Wannabe->user['User']['age']);
            $this->set('year', $year);
            if(time() > strtotime($expires)) {
                $this->set('expired', true);
            }
            if($settings[0]['wb4_kandu_membership_settings']['enabled'] == 0){
                $this->set('disabled', true);
            }
        } else {
            $this->set('disabled', true);
        }

        $this->set('title_for_layout', __("Choose KANDU membership"));

        if($this->request->is('post')) {
            if(!isset($this->request->data['KanduMembership']['choice'])) {
                $this->Flash->error(__("Please make a choice"));
                $this->redirectEvent('/KanduMembership');
            }
           $this->redirectEvent('/KanduMembership/confirm/'.$this->request->data['KanduMembership']['choice']);
        }
        if($done = $this->KanduMembership->find('first', array(
            'conditions' => array(
                'KanduMembership.user_id' => $this->Wannabe->user['User']['id'],
                'KanduMembership.event_id' => $this->Wannabe->event->id
            )
        ))) {
            $this->set('done', $done);
        }
    }

    public function confirm($action) {
        $settings = $this->KanduMembershipSetting->query('SELECT `enabled`, `expires`, `year` FROM wb4_kandu_membership_settings WHERE event_id ='.$this->Wannabe->event->id);
        if($settings == null or $settings[0]['wb4_kandu_membership_settings']['enabled'] == 0) {
            throw new BadRequestException(__("Not yet open"));
        }
        $expires = $settings[0]['wb4_kandu_membership_settings']['expires'];
        $year = $settings[0]['wb4_kandu_membership_settings']['year'];

        $this->set('action', $action);
        $this->set('age', $this->Wannabe->user['User']['age']);
        $this->set('year', $year);

        if(time() > strtotime($expires)) {
            throw new BadRequestException(__("Form has expired"));
        }
        if($this->request->is('post')) {
            $this->request->data['KanduMembership']['user_id'] = $this->Wannabe->user['User']['id'];
            $this->request->data['KanduMembership']['event_id'] = $this->Wannabe->event->id;
            if($this->KanduMembership->save($this->request->data)) {
                $this->Flash->success(__("Your choice was registered"));
                $this->redirectEvent('/Home');
            }
        }
    }
}
