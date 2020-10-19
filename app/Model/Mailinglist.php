<?php
/**
 * Mailinglist Model
 *
 */
class Mailinglist extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'address';
/**
 * Validation rules
 *
 * @var array
 */
	public function beforeValidate($options = []) {
		$this->validate = array(
			'event_id' => array(
				'notempty' => array(
					'rule' => array('notBlank'),
					'message' => __("Cannot be empty")
				),
			),
			'address' => array(
				'email' => array(
					'rule' => array('email'),
					'message' => __("Must be an email")
				),
				'notempty' => array(
					'rule' => array('notBlank'),
					'message' => __("Cannot be empty")
				),
			),
			'moderatorpassword' => array(
				'notempty' => array(
					'rule' => array('notBlank'),
					'message' => __("Cannot be empty")
				),
				'maxlength' => array(
					'rule' => array('maxlength', 6),
					'message' => __("Must be 6 characters")
				),
				'minlength' => array(
					'rule' => array('minlength', 6),
					'message' => __("Must be 6 characters")
				),
				'alphanumeric' => array(
					'rule' => array('alphanumeric'),
					'message' => __("Must be alphanumerical")
				),
			)
		);
	}
}
