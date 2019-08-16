<?php
App::uses('AppModel', 'Model');
/**
 * VoteVote Model
 *
 * @property Campaign $Campaign
 * @property Option $Option
 * @property User $User
 */
class VoteVote extends AppModel {
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'campaign_id' => array(
			'notempty' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'option_id' => array(
			'notempty' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'user_id' => array(
			'notempty' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'created' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notempty' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

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
		),
		'VoteOption' => array(
			'className' => 'VoteOption',
			'foreignKey' => 'option_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

    public function save($data) {
        $data = $data['VoteVote'];
        $this->query("replace into wb4_vote_votes set user_id='".(int)$data['user_id']."', campaign_id='".(int)$data['campaign_id']."', option_id='".(int)$data['option_id']."', created=now()");
        return true;
    }
}
