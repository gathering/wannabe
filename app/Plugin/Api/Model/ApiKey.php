<?php
/**
 * ApiKey Model
 *
 */
class ApiKey extends ApiAppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'apikey';
    public $belongsTo = 'ApiApplication';
    private function getKey($key, $application) {
        App::import('Model', 'Api.ApiApplication');
        $apiApplicationModel = new ApiApplication();
        $application = $apiApplicationModel->find('first', array(
            'conditions' => array(
                'ApiApplication.id' => $application,
                'ApiApplication.enabled' => 1
            )
        ));
        if(!is_array($application) || empty($application))
            return false;
        $key = $this->find('first', array(
            'conditions' => array(
                'ApiKey.apikey' => $key,
                'ApiKey.revoked' => false,
                'ApiKey.api_application_id' => $application['ApiApplication']['id']
            )
        ));
        if(!is_array($key) || empty($key))
            return false;
        return $key;
    }

    public function check($key, $application) {
        $key = $this->getKey($key, $application);
        if(!$key) return false;
        return true;
    }

    public function getUser($key, $application) {
        $key = $this->getKey($key, $application);
        if(!$key) return false;
        return $key['ApiKey']['user_id'];
    }

    public function generate($user, $application) {
        $key = $this->find('first', array(
            'conditions' => array(
                'ApiKey.user_id' => $user,
                'ApiKey.revoked' => false,
                'ApiKey.api_application_id' => $application
            )
        ));
        if(!empty($key))
            return $key;
        $key = md5($user*time());
        $db = $this->getDataSource();
        $this->query("INSERT INTO {$db->fullTableName($this)} (apikey, api_application_id, user_id, created, updated) values('{$key}', '{$application}', {$user}, NOW(), NOW())");
        return $this->find('first', array(
            'conditons' => array(
                'ApiKey.user_id' => $user
            ),
            'order' => 'ApiKey.created DESC'
        ));
    }
}
