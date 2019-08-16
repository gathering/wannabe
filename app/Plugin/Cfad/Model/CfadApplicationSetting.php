<?php
/**
 * CfadApplicationSetting Model
 *
 */
class CfadApplicationSetting extends CfadAppModel {

	public function getSettings() {
        $settings = $this->find('first',array(
                'conditions' => array(
                        'CfadApplicationSetting.event_id' => WB::$event->id
                )
        ));
		return $settings;
	}
}
