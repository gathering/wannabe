<?php
App::uses('WbSanitize', 'Lib');

class KinController extends AppController {

    public $uses = array('User', 'Kin');

    public function index() {
        $this->set('title_for_layout', __("Enter next of kin"));
        if($this->request->is('post')) {
            $this->request->data['Kin']['user_id'] = $this->Wannabe->user['User']['id'];
            if($this->Kin->save($this->request->data)) {
                $this->Flash->success(__("Your kin has been updated"));
                $this->redirectEvent('/Kin');
            }
        }
        if($kin = $this->Kin->find('first', array(
            'conditions' => array(
                'Kin.user_id' => $this->Wannabe->user['User']['id'],
            )
        ))) {
            $this->set('kin', $kin);
        }
    }

	public function view($id=0) {

		// No ID set, setting to the logged in users
		if($id == 0) {
			$id = $this->Wannabe->user['User']['id'];
		}

		//Fake user ID, go away
		if(!is_numeric($id)) {
			 throw new BadRequestException(__('Missing user ID'));
		}

        $user = $this->User->findById($id);

		if(!$user) {
			throw new BadRequestException(__('User does not exist'));
		}

        $box_into_header = array();
        $box_into_header['Header'] = __("To profile");
        $box_into_header['Link'] = array();
        $box_into_header['Link'][] = array('class' => 'btn primary', 'href' => '/Profile/View/'.$user['User']['id'], 'title' => __("Back to profile"));
        $this->set('kin', $this->Kin->findByUserId($user['User']['id']));
        $this->set('box_into_header', $box_into_header);
        $this->set('user', $user);
        $this->set('title_for_layout', __("View next of kin"));
        $this->set('desc_for_layout', __("for")." ".WbSanitize::clean($user['User']['realname']));
	}


}
