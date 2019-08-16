<?php
App::uses('AppModel', 'Model');
/**
 * VoteOption Model
 *
 * @property Campaign $Campaign
 */
class VoteOption extends AppModel {
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
		'VoteCampaign' => array(
		    'className' => 'VoteCampaign',
			'foreignKey' => 'campaign_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
