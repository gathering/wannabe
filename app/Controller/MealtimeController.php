<?php
class MealtimeController extends AppController {
    public $uses = array('Mealtime', 'Crew', 'User');
    public function index() {
        if($this->request->is('post')) {
            $this->request->data['Mealtime']['user_id'] = $this->Wannabe->user['User']['id'];
            $this->request->data['Mealtime']['event_id'] = $this->Wannabe->event->id;
            $this->Mealtime->set($this->request->data);
            if($this->Mealtime->validates()) {
                $this->Mealtime->saveMeal($this->request->data);
                $this->Flash->success(__("Meal time saved"));
            } else {
                $errors = $this->Mealtime->validationErrors;
                $this->Flash->error(__("Error saving meal time"));
            }
        }
        $this->set('title_for_layout', __("Select meal time"));
        $mealtimes = array();
        $mealtimes[] = __("Day").' 15.30–17.00';
        $mealtimes[] = __("Night").' 03.00–04.30';
        $this->set('mealtimes', $mealtimes);
        $this->set('mealtime', $this->Mealtime->find('first', array(
            'conditions' => array(
                'Mealtime.user_id' => $this->Wannabe->user['User']['id'],
                'Mealtime.event_id' => $this->Wannabe->event->id
            )
        )));
    }
    public function view() {
        $mealtimes = $this->Mealtime->find('list', array(
            'fields' => array('Mealtime.user_id', 'Mealtime.mealtime'),
            'conditions' => array(
                'Mealtime.event_id' => $this->Wannabe->event->id
            )
        ));
        $members = $this->User->getAllMembers();
		/*$crews = $this->Crew->getAllCrews();
		$members = array();
		foreach($crews as $crew) {
            foreach($this->User->getMembers($crew['Crew']['id']) as $member) {
                $members[] = $member;
            }
        }*/
        $day = array();
        $night = array();
        $notset = array();
        foreach($members as $member) {
            if(isset($mealtimes[$member['User']['id']])) {
                switch($mealtimes[$member['User']['id']]) {
                    case 0:
                        $day[] = $member;
                        break;
                    case 1:
                        $night[] = $member;
                        break;
                }
            } else {
                $notset[] = $member;
            }
        }
        $this->set('day', $day);
        $this->set('night', $night);
        $this->set('notset', $notset);
        $this->set('title_for_layout', __("View meal times"));
    }
}
