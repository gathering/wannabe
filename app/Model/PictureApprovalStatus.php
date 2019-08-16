<?php
App::uses('AppModel', 'Model');
/**
 * PictureApprovalStatus Model
 *
 * @property PictureApproval $PictureApproval
 */
class PictureApprovalStatus extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'picture_approval_id';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'PictureApproval' => array(
			'className' => 'PictureApproval',
			'foreignKey' => 'picture_approval_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
