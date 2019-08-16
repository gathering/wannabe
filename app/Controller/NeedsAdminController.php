<?php

class NeedsAdminController extends AppController {
    var $layout = 'responsive-default';
	public $uses = array('Needs', 'User');

	public function medical()
	{
		$this->set('needs', $this->Needs->getNeeds('medicalneeds'));
		$this->set('title_for_layout', __("Medical needs"));
		$this->set('desc_for_layout', __("Overview"));
	}

	public function nutritional()
	{
        CakeSession::write('message_redirect_to', $this->here);
		$this->set('needs', $this->Needs->getNeeds('nutritionalneeds'));
		$this->set('title_for_layout', __("Nutritional needs"));
		$this->set('desc_for_layout', __("Overview"));
	}

    public function deny() {
        $need = $this->request->params['named']['need'];
        $validneeds = array_keys($this->Needs->getColumnTypes());
        if(!in_array($need."needs", $validneeds))
            throw new NotFoundException(__("No such need"));
        if(!$this->Acl->hasAccess('manage', $this->Wannabe->user, 'NeedsAdmin/'.$need))
			throw new ForbiddenException();
        $user_id = $this->request->params['named']['user'];
        $userneed = $this->Needs->getNeedForUser($need."needs", $user_id);
        if(!$userneed || !is_array($userneed))
            throw new NotFoundException(__("User has no such need"));
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            )
        ));
        if($this->request->is('post') && isset($this->request->data['verify-yes'])){
            $save = array(
                'user_id' => $user_id,
                $need.'needs' => null
            );
            if($this->Needs->save($save)) {
                $email = new CakeEmail('default');
                $email->viewVars(array('user' => $user, 'wannabe' => $this->Wannabe, 'need' => $userneed, 'message' => $this->request->data['Otherinfo']['message']));
                if($user['User']['language'] == 'nob') {
                    $subject = 'Wannabe: Behov avslått';
                } else {
                    $subject = 'Wannabe: Need denied';
                }
                $email->template('need-denied-'.$need.'-'.$user['User']['language'], 'plain')->emailFormat('text')->subject($subject)->to($user['User']['email'])->send();
                $this->Flash->success(__("Need has been denied"));
                $this->redirectEvent('/NeedsAdmin/'.$need);
            } else {
                $this->Flash->error(__("An error occured, please try again"));
                $this->redirectEvent('/NeedsAdmin/'.$need);
            }
        } else {
            $this->set('was', '/NeedsAdmin/'.$need);
            $this->set('title_for_layout', __("Deny need"));
            $this->set('desc_for_layout', __("You are about to deny the need of %s, would you like to send a message?", $user['User']['realname']));
            $this->render('_verifyaction');
            return;
        }
    }

}
