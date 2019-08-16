<?php
App::uses('AppModel', 'Model');
/**
 * PictureRule Model
 *
 */
class PictureRule extends AppModel {
    public $displayField = 'rule_text';
	public $actsAs = array(
		'Translate' => array(
			'rule_text', 'denied_text'
		)
	);
    public $validate = array(
        'rule_text' => array(
            'rule' => 'notBlank',
            'message' => 'Rule cannot be empty'
        ),
        'denied_text' => array(
            'rule' => 'notBlank',
            'message' => 'Denied text cannot me empty'
        )
    );
}
