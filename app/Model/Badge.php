<?php

class Badge extends AppModel {

	public $validate = array(
		'nfc_id' => array(
			'rule' => 'isUnique',
			'message' => 'There already exits a card with this NFC id.',
		),
	);
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id'
		)
	);
}

?>
