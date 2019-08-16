<?php
/**
 * Admin Controller
 *
 */
class CfadAdminController extends CfadAppController {
	public $uses = array(
		'Cfad.CfadApplicationDocument',
		'Cfad.CfadApplicationPage',
		'Cfad.CfadApplicationField',
		'Cfad.CfadApplicationAvailableField',
		'ApplicationFieldType',
		'Cfad.CfadApplicationSetting',
		'Crew'
	);

	public function index() {
		$this->redirectEvent('/cfad/CfadAdmin/page');
	}

	public function page($id=0) {
		$box_into_header = array();
		$box_into_header['Header'] = __("Back");
		$box_into_header['Link'] = array();
		$box_into_header['Link'][] = array('class' => 'btn primary', 'href' => '/cfad/', 'title' => __("Back"));
		$this->set('box_into_header', $box_into_header);
		$types = array(
			 'crewchoice' => 'crewchoice',
			 'crewfield' => 'crewfield');
		$this->set('types', $types);
		if($id != 0) {
			$this->set('page', $this->CfadApplicationPage->find('first', array(
				'conditions' => array(
					'id' => $id
				)
			)));
			$this->render('pageedit');
		} else {
			$this->set('pages', $this->CfadApplicationPage->find('all', array(
				'conditions' => array(
					'event_id' => $this->Wannabe->event->id
                ),
                'order' => array(
                    'position ASC'
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
			$page = $this->CfadApplicationPage->find('first', array(
				'conditions' => array(
					'id' => $page_id
				)
			));
			if($page['CfadApplicationPage']['type'] == 'crewchoice') {
				$this->redirectEvent('/cfad/CfadAdmin/settings');
			}
			$this->set('page', $page);
			if($field_id != 0) {
				$this->set('field', $this->CfadApplicationAvailableField->find('first', array(
					'conditions' => array(
						'CfadApplicationAvailableField.id' => $field_id
					)
				)));
				$this->render('fieldedit');
			}
		} else {
			$this->redirectEvent('/cfad/CfadAdmin/page');
		}
		$this->set('title_for_layout', __("Administer application field"));
	}
	public function save() {
		if(isset($this->data)) {
			$savedata = $this->data;
			if($savedata['Otherinfo']['type'] == 'page') {
				if(!isset($savedata['CfadApplicationPage']['id'])) {
					$this->CfadApplicationPage->create();
					$savedata['CfadApplicationPage']['event_id'] = $this->Wannabe->event->id;
					$savedata['CfadApplicationPage']['id'] = $this->CfadApplicationPage->getLastInsertID();
				}
				$this->CfadApplicationPage->save($savedata);
			} elseif($savedata['Otherinfo']['type'] == 'field') {
				if(!isset($savedata['CfadApplicationAvailableField']['id'])) {
					$this->CfadApplicationAvailableField->create();
					$savedata['CfadApplicationAvailableField']['event_id'] = $this->Wannabe->event->id;
					$savedata['CfadApplicationAvailableField']['id'] = $this->CfadApplicationAvailableField->getLastInsertID();
				}
				$this->CfadApplicationAvailableField->save($savedata);
				$this->redirectEvent('/cfad/CfadAdmin/field/'.$savedata['CfadApplicationAvailableField']['application_page_id']);

			}
			Cache::delete('application_pages');
		}
		$this->redirectEvent('/cfad/CfadAdmin');
	}

	public function createpage() {
		$types = array(
			 'crewchoice' => 'crewchoice',
			 'crewfield' => 'crewfield');
		$this->set('types', $types);
		$this->set('title_for_layout', __("Create application field"));
	}

	public function createfield($page_id) {
		if($page_id != 0) {
			$this->set('page', $this->CfadApplicationPage->find('first', array(
				'conditions' => array(
					'id' => $page_id
				)
			)));
			$this->set('fieldtypes', $this->ApplicationFieldType->find('list', array(
				'fields' => array('ApplicationFieldType.id', 'ApplicationFieldType.name'),
				'order' => 'ApplicationFieldType.id ASC'
			)));
		} else {
			$this->redirectEvent('/cfad/CfadAdmin/page');
		}
		$this->set('title_for_layout', __("Create application field"));
	}
	public function settings() {
		if(isset($this->data) && $this->request->is('post')) {
			$this->CfadApplicationSetting->save($this->data);
			Cache::delete('application_settings');
			$this->redirectEvent('/cfad/');
		}
		$tempsetting = $this->CfadApplicationSetting->find('first', array(
			'conditions' => array(
				'CfadApplicationSetting.event_id' => $this->Wannabe->event->id
			)
		));
		if(!$tempsetting['CfadApplicationSetting']['event_id']) {
			$this->CfadApplicationSetting->create();
			$createsave['CfadApplicationSetting']['id'] = $this->CfadApplicationSetting->getLastInsertID();
			$createsave['CfadApplicationSetting']['event_id'] = $this->Wannabe->event->id;
			$this->CfadApplicationSetting->save($createsave);
		}
		$settings = $this->CfadApplicationSetting->find('first', array(
			'conditions' => array(
				'CfadApplicationSetting.event_id' => $this->Wannabe->event->id
			)
		));
		$this->set('crews', $this->Crew->getAllCrews(true, 0, true));
		$this->set('settings', $settings);
		$this->data = $this->CfadApplicationSetting->find('first', array(
			'conditions' => array(
				'CfadApplicationSetting.event_id' => $this->Wannabe->event->id
			)
		));
		$this->set('title_for_layout', __("Crew for a day application setting"));
	}

	public function deletepage($page_id=0) {
		if(isset($this->data['Otherinfo']['confirmed'])) {
			$this->CfadApplicationPage->delete($this->data['CfadApplicationPage']['id']);
			$this->redirectEvent('/cfad/CfadAdmin/page');
		}
		$this->set('page', $this->CfadApplicationPage->find('first', array(
			'conditions' => array(
				'CfadApplicationPage.id' => $page_id
			)
		)));
		$this->render('_confirmdeletepage');
		$this->set('title_for_layout', __("Delete page"));
	}

	public function deletefield($field_id=0) {
		if(isset($this->data['Otherinfo']['confirmed'])) {
			$this->CfadApplicationAvailableField->delete($this->data['CfadApplicationAvailableField']['id']);
			$this->redirectEvent('/cfad/CfadAdmin/field/'.$this->data['CfadApplicationPage']['id']);
		}
		$field = $this->CfadApplicationAvailableField->find('first', array(
			'conditions' => array(
				'CfadApplicationAvailableField.id' => $field_id
			)
		));
		$this->set('field', $field);
		$this->set('page', $this->CfadApplicationPage->find('first', array(
			'conditions' => array(
				'CfadApplicationPage.id' => $field['CfadApplicationAvailableField']['application_page_id']
			)
		)));
		$this->render('_confirmdeletefield');
		$this->set('title_for_layout', __("Create page"));
	}

}
