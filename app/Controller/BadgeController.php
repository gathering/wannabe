<?php

class BadgeController extends AppController {

	public $types = array('crew', 'press', 'invited', 'hoa', 'iss', 'other');

	public function index() {

		$badges =  $this->Badge->find('all', array(
			'conditions' => array(
				'Badge.event_id' => $this->Wannabe->event->id
				),
			'order' => array(
				'Badge.type', 'Badge.user_id'
				)
		));
		$this->set('badges', $badges);
	}

	public function add() {
		if ($this->request->is('post')) {

            $this->request->data['Badge']['event_id'] = $this->Wannabe->event->id;
            $this->request->data['Badge']['type'] = $this->types[$this->request->data['Badge']['type']];
            if ($this->Badge->save($this->request->data)) {
   				$this->Flash->success(__("The badge was saved"));
				$this->redirectEvent('/Badge/add');
			 } else {
			 	$this->Flash->error(__("Something went wrong"));
			 }
        }

        $this->set('savebutton', __("Save badge"));
        $this->set('title_for_layout', __('Add new badge'));
        $this->set('types', $this->types);
	}

	function get_badge_by_card_number($card_number) {
        $badge = $this->Badge->find('first', array(
            'conditions' => array(
                'Badge.nfc_id' => $card_number,
                'Badge.event_id' => $this->Wannabe->event->id
                )
            )
        );

        return $badge;
    }

	public function disable($id=null) {
		if($id != null || $this->request->is('post')) {
			if($this->request->is('post')) {
				$this->Badge->id = $this->get_badge_by_card_number($this->request->data['Badge']['nfc_id'])['Badge']['id'];
			} else {
				$this->Badge->id = $id;
			}

			if (!$this->Badge->exists()) {
				throw new NotFoundException(__('Badge does not exist'));
			}

			if($this->Badge->saveField('active', 0)) {
				$this->Flash->success(__("The badge was disabled"));
			} else {
				$this->Flash->error(__("Could not disable badge"));
			}
			if($this->request->is('post')) {
				$this->redirectEvent('/Badge/disable');
			} else {
				$this->redirectEvent('/Badge/');
			}
		} else {
			$this->set('savebutton', __("Disable badge"));
			$this->set('title_for_layout', __('Disable badge'));
		}
	}
}

?>
