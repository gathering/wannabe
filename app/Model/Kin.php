<?php
App::uses('AppModel', 'Model');
/**
 * Kin Model
 *
 */
class Kin extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notBlank'),
			),
		),
		'number' => array(
			'notempty' => array(
				'rule' => array('notBlank'),
			),
		),
	);
}
