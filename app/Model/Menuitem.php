<?php
class Menuitem extends AppModel {

	public $actsAs = array(
		'Translate' => array(
			'name'
		)
	);

	public function getMenu() {
		$menu = array();
		$parents = $this->find('all', array(
			'conditions' => array(
				'OR' => array(
					'Menuitem.event_id' => WB::$event->id,
					'Menuitem.event_id' => 0
				),
				'Menuitem.hidden' => 0,
				'Menuitem.parent_id' => 0
			),
			'order' => 'Menuitem.position ASC'
		));
		foreach($parents as $key => $parent) {
			$menu[$key] = $parent;
			$childs = $this->find('all', array(
				'conditions' => array(
					'Menuitem.hidden' => 0,
					'Menuitem.parent_id' => $parent['Menuitem']['id']
				),
				'order' => 'Menuitem.position ASC'
			));
			if($childs) {
				$menu[$key]['Child'] = array();
				foreach($childs as $child) {
					$menu[$key]['Child'][] = $child;
				}
			}
		}
		return $menu;
	}
}
