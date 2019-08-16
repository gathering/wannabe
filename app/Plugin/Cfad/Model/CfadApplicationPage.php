<?php
/**
 * CfadApplicationPage Model
 *
 */
class CfadApplicationPage extends CfadAppModel {
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
		'CfadApplicationAvailableField' => array(
			'className' => 'CfadApplicationAvailableField',
			'foreignKey' => 'application_page_id',
			'dependent' => false
		)
	);

	public function getPages() {
		$pages = $this->find('all', array(
			'conditions' => array(
				'CfadApplicationPage.event_id' => WB::$event->id
            ),
            'order' => array(
                'CfadApplicationPage.position ASC'
            )
		));
		ClassRegistry::init('ApplicationFieldType');
		ClassRegistry::init('User');
		$fieldType = new ApplicationFieldType();
		$createdBy = new User();
		$fieldTypes = $fieldType->find('all');
		foreach($pages as $pageIndex => $page) {
			if(!empty($page['CfadApplicationAvailableField'])) {
				foreach($page['CfadApplicationAvailableField'] as $fieldIndex => $field) {
					$type = $field['application_fieldtype_id'];
					foreach($fieldTypes as $fieldType) {
						if($fieldType['ApplicationFieldType']['id'] == $type) {
							$pages[$pageIndex]['CfadApplicationAvailableField'][$fieldIndex]['ApplicationFieldType'] = $fieldType['ApplicationFieldType'];
						}
					}
				}
			}
		}
		return $pages;
	}
}
