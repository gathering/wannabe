<?php
/**
 * ApplicationSetting Model
 *
 */
class ApplicationSetting extends AppModel {

	public function getSettings() {
		$settings = Cache::read(WB::$event->reference.'-application_settings');
		if($settings) {
			return $settings;
		}
                $settings = $this->find('first',array(
                        'conditions' => array(
                                'ApplicationSetting.event_id' => WB::$event->id
                        )
                ));
		Cache::write(WB::$event->reference.'-application_settings', $settings);
		return $settings;
	}

	public function afterSave($created) {
        if(!$created)
            Cache::delete(WB::$event->reference.'-application_settings');
	}

}
