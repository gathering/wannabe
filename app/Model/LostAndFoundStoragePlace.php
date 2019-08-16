<?php

class LostAndFoundStoragePlace extends AppModel {


    public $hasMany = array(
        'LostItem' => array(
            'className'  => 'LostItem',
            'foreignKey' => 'category_id',
        ),
        'FoundItem' => array(
            'className'  => 'FoundItem',
            'foreignKey' => 'category_id'
        )
    );

    public function beforeValidate() {

        $this->validate = array(
            'event_id' => array(
                'notempty' => array(
                    'rule' => 'notBlank',
                    'message' => __("Cannot be empty"),
                ),
            ),
            'name' => array(
                'notempty' => array(
                    'rule' => 'notBlank',
                    'message' => __("Cannot be empty"),
                ),
                'unique' => array(
                    'rule' => array('isEventUnique'),
                    'message' => __('A storage place with that name already exists.')
                )
            ),
            'active' => array(
                'notempty' => array(
                    'rule' => array('boolean'),
                    'message' => __("Cannot be empty"),
                )
            ),

        );
    }
}

?>
