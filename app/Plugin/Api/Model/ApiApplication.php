<?php
/**
 * ApiApplication Model
 *
 */
class ApiApplication extends ApiAppModel {
    public $validate = array(
        'name' => array(
            'rule' => 'notBlank',
            'message' => 'Name cannot be empty'
        )
    );
}
