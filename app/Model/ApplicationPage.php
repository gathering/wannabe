<?php
/**
 * ApplicationPage Model
 *
 */
class ApplicationPage extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */

	public $hasMany = array(
		'ApplicationAvailableField' => array(
			'className' => 'ApplicationAvailableField',
			'foreignKey' => 'application_page_id',
			'dependent' => false
		)
	);

	public function getPages() {
		$pages = Cache::read(WB::$event->reference.'-application_pages');
		if($pages) {
			return $pages;
		}
		$pages = $this->find('all', array(
			'conditions' => array(
				'ApplicationPage.event_id' => WB::$event->id
			)
		));
		ClassRegistry::init('ApplicationFieldType');
		ClassRegistry::init('User');
		$fieldType = new ApplicationFieldType();
		$createdBy = new User();
		$fieldTypes = $fieldType->find('all');
		foreach($pages as $pageIndex => $page) {
			if(!empty($page['ApplicationAvailableField'])) {
				foreach($page['ApplicationAvailableField'] as $fieldIndex => $field) {
					$type = $field['application_fieldtype_id'];
					foreach($fieldTypes as $fieldType) {
						if($fieldType['ApplicationFieldType']['id'] == $type) {
							$pages[$pageIndex]['ApplicationAvailableField'][$fieldIndex]['ApplicationFieldType'] = $fieldType['ApplicationFieldType'];
						}
					}
					if($field['user_id']) {
						$user = $createdBy->find('first', array(
							'conditions' => array(
								'User.id' => $field['user_id']
							),
							'recursive' => -1
						));
						$pages[$pageIndex]['ApplicationAvailableField'][$fieldIndex]['CreatedBy'] = $user['User'];
					}
				}
			}
		}
		Cache::write(WB::$event->reference.'-application_pages', $pages);
		return $pages;
	}

	public function afterSave($created, $options = []) {
        if(!$created)
            Cache::delete(WB::$event->reference.'-application_pages');
	}

}
