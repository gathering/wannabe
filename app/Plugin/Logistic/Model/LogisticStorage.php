<?php

/**
 * LogisticStorage Model
 *
 */
class LogisticStorage extends LogisticAppModel {
    /**
     * Display field
     *
     * @var string
     */
	public $displayField = 'name';

    /**
     * Validation rules
     *
     * @var array
     */
    public function beforeValidate() {
        $this->validate = array(
            'name' => array(
                'notempty' => array(
                    'rule' => array('notBlank'),
                    'message' => __("Cannot be empty")
                ),
            ),
        );
     }
}
