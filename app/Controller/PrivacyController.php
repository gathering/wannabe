<?php
/**
 * Privacy Controller
 *
 */
class PrivacyController extends AppController {
    var $uses = array('UserPrivacy');
    public function index() {
        if($this->request->is('post')) {
            $this->request->data['UserPrivacy']['user_id'] = $this->Wannabe->user['User']['id'];
            if($this->UserPrivacy->save($this->request->data)) {
                $this->Auth->reloadUserLogin($this->Wannabe->user['User']['id']);
                $this->Flash->success(__("Your privacy settings has been updated"));
            }
        }
        $privacy = $this->UserPrivacy->find('first', array(
            'conditions' => array(
                'UserPrivacy.user_id' => $this->Wannabe->user['User']['id']
            )
        ));
        if(!is_array($privacy) || empty($privacy)) {
            $privacy['UserPrivacy'] = array(
                'user_id' => $this->Wannabe->user['User']['id'],
                'phone' => 1,
                'address' => 1,
                'birth' => 0,
                'email' => 0,
                'allow_crew' => 0
            );
        }
        $this->set('privacy', $privacy);
        $privacyNames = array(
            'phone' => __("Phone numbers"),
            'address' => __("Address"),
            'birth' => __("Birth"),
            'email' => __("Email address"),
            'allow_crew' => __("Allow fellow crew members to see hidden info regardless of other privacy settings")
        );
        $this->set('privacyNames', $privacyNames);
        $this->set('title_for_layout', __("Privacy settings"));
        $this->set('desc_for_layout', '');
    }
}
