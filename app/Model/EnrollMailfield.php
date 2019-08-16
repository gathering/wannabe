<?php
/**
 * EnrollMailfield Model
 *
 */
class EnrollMailfield extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'EnrollMail' => array(
			'className' => 'EnrollMail',
			'foreignKey' => 'enroll_mail_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
