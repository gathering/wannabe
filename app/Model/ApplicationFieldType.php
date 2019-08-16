<?php
/**
 * ApplicationFieldType Model
 *
 */
class ApplicationFieldType extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

	public function getFieldTypes() {
		$fieldTypes = Cache::read('application_field_types');
		if($fieldTypes) {
			return $fieldTypes;
		}
		$fieldTypes = $this->find('all');
		Cache::write('application_field_types', $fieldTypes);
		return $fieldTypes;
	}
}
