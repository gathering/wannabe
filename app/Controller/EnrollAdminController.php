<?php

class EnrollAdminController extends AppController {

	var $uses = array('EnrollMail', 'EnrollSetting', 'EnrollMailfield');

	public function index() {
		if($this->request->is('post')) {
			$this->request->data['EnrollSetting']['event_id'] = $this->Wannabe->event->id;
			if($this->EnrollSetting->save($this->request->data)) {
				$this->Flash->success(__("Enrollment settings updated"));
				$this->redirectEvent('/EnrollAdmin');
			}
		}
		$setting = $this->EnrollSetting->find('first', array(
			'conditions' => array(
				'EnrollSetting.event_id' => $this->Wannabe->event->id
			)
		));
		if(!is_array($setting)) {
			$save['EnrollSetting']['event_id'] = $this->Wannabe->event->id;
			if($this->EnrollSetting->save($save)) {
				$setting = $this->EnrollSetting->find('first', array(
					'conditions' => array(
						'EnrollSetting.event_id' => $this->Wannabe->event->id
					)
				));
			}
		}
		$this->set('mails', $this->EnrollMail->find('all', array(
			'conditions' => array(
				'EnrollMail.enroll_setting_id' => $setting['EnrollSetting']['id']
			)
		)));
		$this->set('types', $this->getMailTypes());
		$this->set('setting', $setting);
		$this->set('title_for_layout', __("Enrollment settings"));
	}
	public function create() {
		$setting = $this->EnrollSetting->find('first', array(
			'conditions' => array(
				'EnrollSetting.event_id' => $this->Wannabe->event->id
			)
		));
		if($this->request->is('post')) {
			$this->request->data['EnrollMail']['enroll_setting_id'] = $setting['EnrollSetting']['id'];
			if($this->EnrollMail->save($this->request->data)) {
				$this->Flash->success(__("Mail created"));
				$this->redirectEvent('/EnrollAdmin');
			}
		}
		$mails = $this->EnrollMail->find('all', array(
			'conditions' => array(
				'EnrollMail.enroll_setting_id' => $setting['EnrollSetting']['id']
			)
		));
		$types = $this->getMailTypes();
		foreach($mails as $mail) {
			unset($types[$mail['EnrollMail']['type']]);
		}
		if(empty($types)) {
			$this->Flash->warning(__("All mailtypes created already"));
			$this->redirectEvent('/EnrollAdmin');
		}
		$this->set('title_for_layout', __("Create new mail"));
		$this->set('types', $types);
	}
	public function mail($id=0) {
		if($id==0) {
			$this->Flash->warning(__("Please select mail"));
			$this->redirectEvent('/EnrollAdmin');
		}
		$mail = $this->EnrollMail->find('first', array(
			'conditions' => array(
				'EnrollMail.id' => $id
			)
		));
		if(!is_array($mail)) {
			throw new BadRequestException(__("No such mail"));
		}
		$types = $this->getMailTypes();
		$this->set('types', $types);
		$this->set('mail', $mail);
		$this->set('title_for_layout', $mail['EnrollMail']['subject']);
		$this->set('desc_for_layout', __("View %s-mail", $types[$mail['EnrollMail']['type']]));
	}
	public function edit($id=0) {
		if($this->request->is('post')) {
			if($this->EnrollMail->save($this->request->data)) {
				$this->Flash->success(__("Mail saved"));
				$this->redirectEvent('/EnrollAdmin');
			}
		}
		if($id==0) {
			$this->Flash->warning(__("Please select mail"));
			$this->redirectEvent('/EnrollAdmin');
		}
		$mail = $this->EnrollMail->find('first', array(
			'conditions' => array(
				'EnrollMail.id' => $id
			)
		));
		if(!is_array($mail)) {
			throw new BadRequestException(__("No such mail"));
		}
		$types = $this->getMailTypes();
		$this->set('types', $types);
		$this->set('mail', $mail);
		$this->set('title_for_layout', $mail['EnrollMail']['subject']);
		$this->set('desc_for_layout', __("Edit %s-mail", $types[$mail['EnrollMail']['type']]));
	}
	public function delete($id=0) {
		if($this->request->is('post')) {
			if($this->EnrollMail->delete($this->request->data['EnrollMail']['id'])) {
				$this->Flash->success(__("Mail deleted"));
				$this->redirectEvent('/EnrollAdmin');
			}
		}
		if($id==0) {
			$this->Flash->warning(__("Please select mail"));
			$this->redirectEvent('/EnrollAdmin');
		}
		$mail = $this->EnrollMail->find('first', array(
			'conditions' => array(
				'EnrollMail.id' => $id
			)
		));
		if(!is_array($mail)) {
			throw new BadRequestException(__("No such mail"));
		}
		$types = $this->getMailTypes();
		$this->set('types', $types);
		$this->set('mail', $mail);
		$this->set('title_for_layout', $mail['EnrollMail']['subject']);
		$this->set('desc_for_layout', __("Delete %s-mail", $types[$mail['EnrollMail']['type']]));
	}
	public function fieldedit($id=0) {
		if($this->request->is('post')) {
			if($this->EnrollMailfield->save($this->request->data)) {
				$this->Flash->success(__("Field saved"));
				$this->redirectEvent('/EnrollAdmin/mail/'.$this->request->data['EnrollMailfield']['enroll_mail_id']);
			}
		}
		if($id==0) {
			$this->Flash->warning(__("Please select field"));
			$this->redirectEvent('/EnrollAdmin');
		}
		$field = $this->EnrollMailfield->find('first', array(
			'conditions' => array(
				'EnrollMailfield.id' => $id
			)
		));
		if(!is_array($field)) {
			throw new BadRequestException(__("No such mail"));
		}
		$this->set('field', $field);
		$this->set('title_for_layout', $field['EnrollMailfield']['name']);
		$this->set('desc_for_layout', __("Edit field"));
	}
	public function fieldcreate($mailid=0) {
		if($mailid==0) {
			$this->Flash->warning(__("Please select field"));
			$this->redirectEvent('/EnrollAdmin');
		}
		$mail = $this->EnrollMail->find('first', array(
			'conditions' => array(
				'EnrollMail.id' => $mailid
			)
		));
		if(!is_array($mail)) {
			throw new BadRequestException(__("No such field"));
		}
		if($this->request->is('post')) {
			$this->request->data['EnrollMailfield.enroll_mail_id'] = $mailid;
			if($this->EnrollMailfield->save($this->request->data)) {
				$this->Flash->success(__("Field created"));
				$this->redirectEvent('/EnrollAdmin/mail/'.$mailid);
			}
		}
		$this->set('mail_id', $mailid);
		$this->set('title_for_layout', __("Create new field"));
	}
	public function fielddelete($id=0) {
		if($this->request->is('post')) {
			if($this->EnrollMailfield->delete($this->request->data['EnrollMailfield']['id'])) {
				$this->Flash->success(__("Field deleted"));
				$this->redirectEvent('/EnrollAdmin/mail/'.$this->request->data['EnrollMailfield']['enroll_mail_id']);
			}
		}
		if($id==0) {
			$this->Flash->warning(__("Please select field"));
			$this->redirectEvent('/EnrollAdmin');
		}
		$field = $this->EnrollMailfield->find('first', array(
			'conditions' => array(
				'EnrollMailfield.id' => $id
			)
		));
		if(!is_array($field)) {
			throw new BadRequestException(__("No such field"));
		}
		$this->set('field', $field);
		$this->set('title_for_layout', $field['EnrollMailfield']['name']);
		$this->set('desc_for_layout', __("Delete field"));
	}
	private function getMailTypes() {
		return array(
			'pending' => __("Pending"),
			'denied' => __("Denied"),
            'accepted' => __("Accepted"),
            'waiting' => __("Wait list")
		);
	}
}
