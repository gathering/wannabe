<?php
App::uses('AppModel', 'Model');
/**
 * ApiSession Model
 *
 */
class ApiSession extends AppModel {
/**
 * Display field
 *
 * @var string
 */
    public $displayField = 'sessionkey';

    public function check($key) {
        $session = $this->find('first', array(
            'conditions' => array(
                'sessionkey' => $key,
                'UNIX_TIMESTAMP(created) > UNIX_TIMESTAMP(NOW())-600'
            )
        ));
        if(!is_array($session) || empty($session))
            return false;
        return true;
    }

    public function getUser($key) {
        $session = $this->find('first', array(
            'conditions' => array(
                'sessionkey' => $key,
                'UNIX_TIMESTAMP(created) > UNIX_TIMESTAMP(NOW())-600'
            )
        ));
        if(!is_array($session) || empty($session))
            return false;
        return $session['ApiSession']['user_id'];
    }

    public function generate($user, $infinite=0) {
        $session = $this->find('first', array(
            'conditions' => array(
                'user_id' => $user['User']['id'],
                'UNIX_TIMESTAMP(created) > UNIX_TIMESTAMP(NOW())-600'
            )
        ));
        if(!empty($session))
            return $session;
        $key = md5($user['User']['id']*time());
        $this->query("INSERT INTO wb4_api_sessions (sessionkey, infinite, user_id, created, updated) values('{$key}', {$infinite}, {$user['User']['id']}, NOW(), NOW())");
        return $this->find('first', array(
            'conditons' => array(
                'user_id' => $user['User']['id']
            ),
            'order' => 'created DESC'
        ));
    }
}
