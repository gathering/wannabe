<?php
App::uses('AppModel', 'Model');
/**
 * VoteCampaign Model
 *
 * @property VoteOption $VoteOption
 * @property VoteVote $VoteVote
 */
class VoteCampaign extends AppModel {
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
		'VoteOption' => array(
			'className' => 'VoteOption',
			'foreignKey' => 'campaign_id',
			'dependent' => true
		),
		'VoteVote' => array(
			'className' => 'VoteVote',
			'foreignKey' => 'campaign_id',
			'dependent' => true
		)
	);

}
