<?php
/**
 * CrewEffectsItem Model
 *
 */
class CrewEffectsItem extends AppModel {
/**
 * Display field
 *
 * @var string
 */
    public $displayField = 'title';
    public $validate = array(
        'title' => array(
                'rule' => 'notBlank'
            ),
        'price' => array(
                'rule' => 'notBlank',
                'rule' => 'numeric',
                'message' => 'This field cannot ble blank and must be numeric'
            ),
        'amount_free' => array(
                'rule' => 'notBlank',
                'rule' => 'numeric',
                'message' => 'This field cannot ble blank and must be numeric'
            )
        );

}
