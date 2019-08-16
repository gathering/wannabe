<?php

class MessageController extends AppController {

    var $uses = array('User', 'MessageSender', 'Message');

    public function compose() {
        $this->set('title_for_layout', __("Send message"));
        $from = $this->request->params['named']['from'];
        if(!$from) {
			throw new BadRequestException(__("No sender given"));
        }
        $from = $this->MessageSender->find('first', array(
            'conditions' => array(
                'MessageSender.id' => $from,
                'MessageSender.event_id' => $this->Wannabe->event->id
            )
        ));
        if(!$from or !is_array($from)) {
			throw new BadRequestException(__("Invalid sender"));
        }
        $user_id = 0;
        if(isset($this->request->params['named']['user'])) {
            $user_id = $this->request->params['named']['user'];
        }
        if(isset($this->request->data['user_id'])) {
            $user_id = $this->request->data['user_id'];
        }
        if(!$user_id) {
			throw new BadRequestException(__("No user given"));
        }
        $subject = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            )
        ));
        if(!$subject || !is_array($subject) || !$this->User->isCrewForEvent($subject, $this->Wannabe->event->id)) {
            throw new BadRequestException(__("No such user"));
        }
        $redirect_to = $this->here;
        if(CakeSession::check('message_redirect_to')) {
            $redirect_to = CakeSession::read('message_redirect_to');
            CakeSession::delete('mssage_redirect_to');
        }
        if(isset($this->request->data['subject'])) {
            $this->set('subject', $this->request->data['subject']);
        } else {
            if(!$this->Acl->hasAccess('manage'))
                throw new ForbiddenException(__("You are only allowed to send predefined messages, please submit a message from an allowed module"));
        }
        $this->set('was', $redirect_to);
        $this->set('header', __("Send message to %s", $subject['User']['realname']));
        $this->set('to', $subject['User']['id']);
        $this->set('from', $from['MessageSender']);
        $this->set('hash', md5($from['MessageSender']['email']."-".microtime()));
        if($this->request->is('ajax')) {
			$this->layout = 'modal';
		}
    }

    public function send($hash=null) {
        if($this->request->is('post') && isset($this->request->data['Message']['confirm_send']) && $this->request->data['Message']['confirm_send'] == $hash) {
            $from = $this->request->data['Message']['from'];
            if(!$from) {
                throw new BadRequestException(__("No sender given"));
            }
            if(!$this->Acl->hasAccess('write', $this->Wannabe->user, 'Message/compose/from:'.$from))
                throw new ForbiddenException(__("You are not allowed to use this sender"));
            $from = $this->MessageSender->find('first', array(
                'conditions' => array(
                    'MessageSender.id' => $from,
                    'MessageSender.event_id' => $this->Wannabe->event->id
                )
            ));
            if(!$from or !is_array($from)) {
                throw new BadRequestException(__("Invalid sender"));
            }
            $user_id = $this->request->data['Message']['to'];
            if(!$user_id) {
                throw new BadRequestException(__("No user given"));
            }
            $to = $this->User->find('first', array(
                'conditions' => array(
                    'User.id' => $user_id
                )
            ));
            if(!$to || !is_array($to) || !$this->User->isCrewForEvent($to, $this->Wannabe->event->id)) {
                throw new BadRequestException(__("No such user"));
            }
            $message = array(
                'Message' => array(
                    'user_id' => $to['User']['id'],
                    'message_sender_id' => $from['MessageSender']['id'],
                    'content' => h($this->request->data['Message']['message']),
                    'subject' => h($this->request->data['Message']['subject'])
                )
            );
            if($this->Message->save($message)) {
                $this->Flash->success(__("The message was successfully delivered"));
            }
            $message = new CakeEmail('default');
            $message->viewVars(array('from' => $from['MessageSender']['name'], 'message' => h($this->request->data['Message']['message']), 'wannabe' => $this->Wannabe))
                ->template('message-'.$to['User']['language'], 'plain')
                ->emailFormat('text')
                ->subject('Wannabe: '.h($this->request->data['Message']['subject']))
                ->to($to['User']['email'], $to['User']['realname'])
                ->from($from['MessageSender']['email'], $from['MessageSender']['name'])
                ->sender($this->Wannabe->event->email, 'Wannabe')
                ->replyTo($from['MessageSender']['email'], $from['MessageSender']['name'])
                ->send();
            $this->redirect($this->request->data['Message']['redirect']);
        } else {
            throw new BadRequestException(__("Message accessed in wrong manner"));
        }
    }
}
