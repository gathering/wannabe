<?php
/**
 * CrewEffectsOrder Model
 *
 */
class CrewEffectsOrder extends AppModel {
/**
 * Display field
 *
 * @var string
 */
    public $displayField = 'item_id';
    public $validate = array(
        'item_size' => array(
            'rule' => 'notBlank'
        ),
        'amount_extra' => array(
            'rule-1' => array(
                'rule' => 'notBlank'),
            'rule-2' => array(
                'rule' => array('comparison', '>=', 0))
        )
    );

}
