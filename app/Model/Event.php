<?php
class Event extends AppModel {

    public $validate = array(
        'name' => array(
            'rule' => 'notBlank'
        ),
        'reference' => array(
            'rule' => 'notBlank'
        ),
        'locationname' => array(
            'rule' => 'notBlank'
        ),
        'latitude' => array(
            'rule' => 'notBlank'
        ),
        'longitude' => array(
            'rule' => 'notBlank'
        ),
        'start' => array(
            'rule' => 'notBlank'
        ),
        'end' => array(
            'rule' => 'notBlank'
        ),
        'show_time' => array(
            'rule' => 'notBlank'
        ),
        'urlmode' => array(
            'rule' => 'notBlank'
        ),
        'email' => array(
            'rule' => 'notBlank'
        )
    );


}
?>
