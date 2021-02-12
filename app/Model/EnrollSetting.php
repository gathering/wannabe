<?php
/**
 * EnrollSetting Model
 *
 */
class EnrollSetting extends AppModel {

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'EnrollMail' => array(
			'className' => 'EnrollMail',
			'foreignKey' => 'enroll_setting_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	public function afterSave($created, $options = []) {
        if(!$created)
            $this->clearEnrollCache();
	}

	public function getSettings() {
		$settings = Cache::read(WB::$event->reference.'-enroll-settings');
		if($settings) {
			return $settings;
		}

		$settings = $this->find('first',array(
			'conditions' => array(
				'EnrollSetting.event_id' => WB::$event->id
			)
		));
		Cache::write(WB::$event->reference.'-enroll-settings', $settings);
		return $settings;
	}
	public function clearEnrollCache() {
		Cache::delete(WB::$event->reference.'-enroll-settings');
	}

}
