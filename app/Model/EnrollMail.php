<?php
/**
 * EnrollMail Model
 *
 */
class EnrollMail extends AppModel {
/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'EnrollSetting' => array(
			'className' => 'EnrollSetting',
			'foreignKey' => 'enroll_setting_id',
			'dependent' => true
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'EnrollMailfield' => array(
			'className' => 'EnrollMailfield',
			'foreignKey' => 'enroll_mail_id',
			'dependent' => true,
			'order' => 'EnrollMailfield.position ASC'
		)
	);

}
