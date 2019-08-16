<?php

class KeyController extends ApiAppController {
    var $uses = array('Api.ApiApplication', 'Api.ApiKey');
    public $requireLogin = true;
    public function index() {
        $this->set('title_for_layout', __("API keys"));
        $this->set('desc_for_layout', __("View your issued API keys"));
        $this->set('keys', $this->ApiKey->find('all', array(
            'conditions' => array(
                'ApiKey.user_id' => $this->Wannabe->user['User']['id'],
                'ApiKey.revoked' => 0,
                'ApiApplication.enabled' => 1
            )
        )));
    }
    public function revoke($id=0) {
        if(!$id) {
            throw new BadRequestException(__("No ID provided"));
        }
        $key = $this->ApiKey->find('first', array(
            'conditions' => array(
                'ApiKey.id' => $id,
                'ApiKey.user_id' => $this->Wannabe->user['User']['id'],
                'ApiKey.revoked' => 0,
                'ApiApplication.enabled' => 1
            )
        ));
        if(is_array($key) && !empty($key)) {
            if($this->request->is("post")) {
                $this->ApiKey->id = $id;
                if($this->ApiKey->save(array('ApiKey' => array('revoked' => 1)))) {
                    $this->Flash->success(__("API key has been revoked"));
                } else {
                    $this->Flash->error(__("An error occured when trying to revoke the API key"));
                }
                $this->redirectEvent('/api/Key');
            } else {
                $this->set('title_for_layout', __("Revoke API key"));
                $this->set('desc_for_layout', __("Revoke API access via %s", $key['ApiApplication']['name']));
                $this->set('key', $key);
            }
        } else {
            throw new BadRequestException(__("API key not found"));
        }

    }
}
