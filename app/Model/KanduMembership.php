<?php

class KanduMembership extends AppModel {

    public $validate = array('choice' => array (
        'rule' => 'notBlank'));

}
