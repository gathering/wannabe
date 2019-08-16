<?php
/**
 * ApplicationAdmin Controller
 *
 */
class ApplicationAdminController extends AppController {
	public $uses = array(
		'ApplicationDocument',
		'ApplicationPage',
		'ApplicationField',
		'ApplicationAvailableField',
		'ApplicationFieldType',
		'ApplicationSetting',
		'Crew'
	);

	public function index() {
		$this->redirectEvent('/ApplicationAdmin/page');
	}

	public function page($id=0) {
		$types = array(
			 'crewquestion' => 'crewquestion',
			 'crewchoice' => 'crewchoice',
			 'crewfield' => 'crewfield');
		$this->set('types', $types);
		if($id != 0) {
			$this->set('page', $this->ApplicationPage->find('first', array(
				'conditions' => array(
					'id' => $id
				)
			)));
			$this->render('pageedit');
		} else {
			$this->set('pages', $this->ApplicationPage->find('all', array(
				'conditions' => array(
					'event_id' => $this->Wannabe->event->id
				)
			)));
		}
		$this->set('title_for_layout', __("Administer application pages"));
	}

	public function field($page_id=0, $field_id=0) {
		if($page_id !=0) {
                        $this->set('fieldtypes', $this->ApplicationFieldType->find('list', array(
                                'fields' => array('ApplicationFieldType.id', 'ApplicationFieldType.name'),
                                'order' => 'ApplicationFieldType.id ASC'
                        )));
			$page = $this->ApplicationPage->find('first', array(
				'conditions' => array(
					'id' => $page_id
				)
			));
			if($page['ApplicationPage']['type'] == 'crewquestion') {
				$this->redirectEvent('/ApplicationManager/question');
			}
			if($page['ApplicationPage']['type'] == 'crewchoice') {
				$this->redirectEvent('/ApplicationAdmin/settings');
			}
			$this->set('page', $page);
			if($field_id != 0) {
				$this->set('field', $this->ApplicationAvailableField->find('first', array(
					'conditions' => array(
						'ApplicationAvailableField.id' => $field_id
					)
				)));
				$this->render('fieldedit');
			}
		} else {
			$this->redirectEvent('/ApplicationAdmin/page');
		}
		$this->set('title_for_layout', __("Administer application field"));
	}
	public function save() {
		if(isset($this->data)) {
			$savedata = $this->data;
			if($savedata['Otherinfo']['type'] == 'page') {
				if(!isset($savedata['ApplicationPage']['id'])) {
					$this->ApplicationPage->create();
					$savedata['ApplicationPage']['event_id'] = $this->Wannabe->event->id;
					$savedata['ApplicationPage']['id'] = $this->ApplicationPage->getLastInsertID();
				}
				$this->ApplicationPage->save($savedata);
			} elseif($savedata['Otherinfo']['type'] == 'field') {
				if(!isset($savedata['ApplicationAvailableField']['id'])) {
					$this->ApplicationAvailableField->create();
					$savedata['ApplicationAvailableField']['event_id'] = $this->Wannabe->event->id;
					$savedata['ApplicationAvailableField']['id'] = $this->ApplicationAvailableField->getLastInsertID();
				}
				$this->ApplicationAvailableField->save($savedata);
				$this->redirectEvent('/ApplicationAdmin/field/'.$savedata['ApplicationAvailableField']['application_page_id']);

			}
			Cache::delete('application_pages');
		}
		$this->redirectEvent('/ApplicationAdmin');
	}

	public function createpage() {
		$types = array(
			 'crewquestion' => 'crewquestion',
			 'crewchoice' => 'crewchoice',
			 'crewfield' => 'crewfield');
		$this->set('types', $types);
		$this->set('title_for_layout', __("Create application field"));
	}

	public function createfield($page_id) {
		if($page_id != 0) {
			$this->set('page', $this->ApplicationPage->find('first', array(
				'conditions' => array(
					'id' => $page_id
				)
			)));
			$this->set('fieldtypes', $this->ApplicationFieldType->find('list', array(
				'fields' => array('ApplicationFieldType.id', 'ApplicationFieldType.name'),
				'order' => 'ApplicationFieldType.id ASC'
			)));
		} else {
			$this->redirectEvent('/ApplicationAdmin/page');
		}
		$this->set('title_for_layout', __("Create application field"));
	}
	public function settings() {
		if(isset($this->data) && $this->request->is('post')) {
			$this->ApplicationSetting->save($this->data);
			Cache::delete('application_settings');
			$this->redirectEvent('/ApplicationAdmin/page');
		}
		$tempsetting = $this->ApplicationSetting->find('first', array(
			'conditions' => array(
				'ApplicationSetting.event_id' => $this->Wannabe->event->id
			)
		));
		if(!$tempsetting['ApplicationSetting']['event_id']) {
			$this->ApplicationSetting->create();
			$createsave['ApplicationSetting']['id'] = $this->ApplicationSetting->getLastInsertID();
			$createsave['ApplicationSetting']['event_id'] = $this->Wannabe->event->id;
			$this->ApplicationSetting->save($createsave);
		}
		$settings = $this->ApplicationSetting->find('first', array(
			'conditions' => array(
				'ApplicationSetting.event_id' => $this->Wannabe->event->id
			)
		));
		$this->set('crews', $this->Crew->getAllCrews(true, 0, true));
		$this->set('settings', $settings);
		$this->data = $this->ApplicationSetting->find('first', array(
			'conditions' => array(
				'ApplicationSetting.event_id' => $this->Wannabe->event->id
			)
		));
		$this->set('title_for_layout', __("Application setting"));
	}

	public function deletepage($page_id=0) {
		if(isset($this->data['Otherinfo']['confirmed'])) {
			$this->ApplicationPage->delete($this->data['ApplicationPage']['id']);
			$this->redirectEvent('/ApplicationAdmin/page');
		}
		$this->set('page', $this->ApplicationPage->find('first', array(
			'conditions' => array(
				'ApplicationPage.id' => $page_id
			)
		)));
		$this->render('_confirmdeletepage');
		$this->set('title_for_layout', __("Delete page"));
	}

	public function deletefield($field_id=0) {
		if(isset($this->data['Otherinfo']['confirmed'])) {
			$this->ApplicationAvailableField->delete($this->data['ApplicationAvailableField']['id']);
			$this->redirectEvent('/ApplicationAdmin/field/'.$this->data['ApplicationPage']['id']);
		}
		$field = $this->ApplicationAvailableField->find('first', array(
			'conditions' => array(
				'ApplicationAvailableField.id' => $field_id
			)
		));
		$this->set('field', $field);
		$this->set('page', $this->ApplicationPage->find('first', array(
			'conditions' => array(
				'ApplicationPage.id' => $field['ApplicationAvailableField']['application_page_id']
			)
		)));
		$this->render('_confirmdeletefield');
		$this->set('title_for_layout', __("Create page"));
	}

}
