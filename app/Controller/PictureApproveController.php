<?php
/**
 * PictureApproves Controller
 *
 * @property PictureApprove $PictureApprove
 */
class PictureApproveController extends AppController {

    var $uses = array('PictureApproval', 'User', 'Crew', 'PictureRule');
/**
 * index method
 *
 * @return void
 */
	public function index() {
        if($this->request->is('post')) {
            $saved = false;
            foreach($this->request->data['PictureApproval'] as $user_id => $action) {
                switch($action['process']) {
                    case 2:
                        $saved = true;
                        $this->approve($user_id);
                        break;
                    case 1:
                        $saved = true;
                        $this->deny($user_id, $action['rule_broken'], $action['user_message']);
                        break;
                    case 0:
                        $saved = true;
                        break;
                }
            }
            if($saved) {
                $this->Flash->success(__("Pictures processed"));
            } else {
                $this->Flash->warning(__("Select pictures to process"));
            }
        }

        //Get members without picture
        $sql = "SELECT wb4_users.id, wb4_users.image, wb4_crews.name  FROM wb4_users
JOIN wb4_crews_users ON wb4_crews_users.user_id = wb4_users.id
JOIN wb4_crews ON wb4_crews.id = wb4_crews_users.crew_id
LEFT JOIN wb4_picture_approvals ON wb4_picture_approvals.user_id = wb4_users.id
WHERE ( wb4_picture_approvals.approved = 0 OR wb4_picture_approvals.approved IS NULL) AND wb4_users.image > '' AND wb4_crews.event_id = ".$this->Wannabe->event->id. " GROUP BY wb4_users.id";

        $members = $this->User->query($sql);
        $count = count($members);

        $this->set('members', $members);
        $this->set('count', $count);
        $this->set('rules', $this->PictureRule->find('list'));
        $this->set('title_for_layout', __("Profile picture censorship"));

        if($count == 1){
            $this->set('desc_for_layout', __("picture need approval", $count));
        }else {
            $this->set('desc_for_layout', __("pictures need approval", $count));
        }
    }

    public function noPicture() {
		$crews = $this->Crew->getCrewHierarchy(false);
		$members = array();
		foreach($crews as $crew) {
            $m = $this->User->getMembers($crew['Crew']['id']);
            foreach($m as $index => $member) {
                if($member['User']['image'] != '') {
                    unset($m[$index]);
                }
            }
			$members[$crew['Crew']['id']] = $m;
        }


        $sql = "SELECT wb4_users.id, wb4_users.image, wb4_crews.name  FROM wb4_users
JOIN wb4_crews_users ON wb4_crews_users.user_id = wb4_users.id
JOIN wb4_crews ON wb4_crews.id = wb4_crews_users.crew_id
WHERE ( wb4_users.image = '' OR  wb4_users.image IS NULL) AND wb4_crews.event_id = ".$this->Wannabe->event->id. " GROUP BY wb4_users.id";

        $users_without_picture = $this->User->query($sql);
        $users_without_picture_count = count($users_without_picture);

		$box_into_header = array();
		$box_into_header['Header'] = __("Picture approval");
		$box_into_header['Link'] = array();
		$box_into_header['Link'][] = array('class' => 'btn primary', 'href' => '/PictureApprove/', 'title' => __("Go back"));
		$this->set('box_into_header', $box_into_header);
		$this->set('crewnames', $this->Crew->getAllCrews(true));
		$this->set('crews', $crews);
        $this->set('members', $members);
        $this->set('title_for_layout', __("Profile picture censorship"));
        $this->set('desc_for_layout', __("users without picture", $users_without_picture_count));
    }

    private function approve($user_id) {
        $approval_id = $this->PictureApproval->find('first', array(
            'conditions' => array(
                'user_id' => $user_id
            )
        ));
        $save = array(
            'user_id' => $user_id,
            'approved' => true
        );
        $this->PictureApproval->id = $approval_id['PictureApproval']['id'];
        $this->PictureApproval->save($save);
        $user = array('User' => array('id' => $user_id));
        $this->User->setUserHash($user);
    }

    private function deny($user_id, $rule, $message='') {
        $approval_id = $this->PictureApproval->find('first', array(
            'conditions' => array(
                'user_id' => $user_id
            )
        ));
        $save = array(
            'user_id' => $user_id,
            'approved' => false,
            'picture_rule_id' => $rule,
            'custom_denied_reason' => $message
        );
        $this->PictureApproval->id = $approval_id['PictureApproval']['id'];
        if($this->PictureApproval->save($save)) {
            $this->PictureRule->bindTranslation(array(
                'denied_text' => 'deniedTranslation'
            ));
            $rule = $this->PictureRule->find('first', array(
                'conditions' => array(
                    'PictureRule.id' => $rule
                ),
                'recursive' => 1
            ));
            $user = $this->User->find('first', array(
                'conditions' => array(
                    'User.id' => $user_id
                )
            ));
            $usersave = array(
                'id' => $user_id,
                'image' => ''
            );
            $this->User->save($usersave);
            $this->User->setUserHash($user);
            $denied_text = false;
            foreach($rule['deniedTranslation'] as $translation) {
                if($translation['locale'] == $user['User']['language'])
                    $denied_text = $translation['content'];
            }
            $email = new CakeEmail('default');
            $email->viewVars(array('denied' => $denied_text, 'custom' => $message, 'user' => $user, 'wannabe' => $this->Wannabe));
            $email->template('picture-rejected-'.$user['User']['language'], 'plain')->emailFormat('text')->subject(__("Wannabe: Picture denied"))->to($user['User']['email'])->send();
        }
    }

    public function resetPicture($user_id) {
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            )
        ));
        if(is_array($user) && $user) {
            if($user['User']['image'] && $user['PictureApproval']['approved']) {
                $save = array(
                    'user_id' => $user_id,
                    'approved' => false,
                    'picture_rule_id' => 0,
                    'custom_denied_reason' => ''
                );
                $this->PictureApproval->id = $user['PictureApproval']['id'];
                if($this->PictureApproval->save($save)) {
                    $usersave = array(
                        'id' => $user['User']['id'],
                        'image' => ''
                    );
                    $this->User->save($usersave);
                    $this->User->setUserHash($user);
                    $email = new CakeEmail('default');
                    $email->viewVars(array('user' => $user, 'wannabe' => $this->Wannabe));
                    $email->template('picture-reset-'.$user['User']['language'], 'plain')->emailFormat('text')->subject(__("Wannabe: Picture reset"))->to($user['User']['email'])->send();
                    foreach($user['Crew'] as $crew) {
                        $this->User->clearMemberCache($crew['id']);
                    }
                    $this->Flash->success(__("Picture reset"));
                }
            } else {
               $this->Flash->error(__("Picture not approved. Nothing reset."));
            }
            $this->redirectEvent('/Profile/View/'.$user['User']['id']);
        } else {
            $this->Flash->error(__("No such user."));
            $this->redirectEvent('/Profile/View');
        }
    }
}
