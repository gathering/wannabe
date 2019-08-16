<?php
App::uses('AppModel', 'Model');
/**
 * Mealtime Model
 *
 */
class Mealtime extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'mealtime';
    public $primaryKey = 'user_id';
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'mealtime' => array(
			'notempty' => array(
				'rule' => array('notBlank'),
				'message' => 'Field cannot be empty',
			),
		),
	);

    public function saveMeal($data) {
        $this->query("REPLACE INTO wb4_mealtimes values ({$data['Mealtime']['user_id']}, {$data['Mealtime']['event_id']},{$data['Mealtime']['mealtime']})");
    }
}
