<?php

/**
 * Component that handles menu generation
 */
class MenuComponent extends Component {

	var $controller;

	public function initialize(Controller $controller) {
		if(!isset($controller->Wannabe->user['User']['id'])) {
			return;
		}
		$this->controller = $controller;
		$user_id = $controller->Wannabe->user['User']['id'];
		//$menu = CakeSession::read('userMenu-'.$controller->Wannabe->lang);
        $menu = false;
		if(!$menu) {
			App::import('Model', 'Menuitem');
			$menuModel = new Menuitem();
			$menu = $menuModel->getMenu();
			$menu = $this->generateMenuForUser($menu);
			//CakeSession::write('userMenu-'.$controller->Wannabe->lang, $menu);
		}
		$controller->Wannabe->menu = $menu;
        WB::$menu = $menu;
	}
	public function generateMenuForUser($menu) {
		foreach($menu as $key => $item) {
			if(!$this->controller->Acl->hasAccess('read', null, "/{$this->controller->Wannabe->event->reference}{$item['Menuitem']['path']}") && $item['Menuitem']['requireevent']) {
				unset($menu[$key]);
			} else if(isset($item['Child'])) {
				foreach($item['Child'] as $childkey => $child) {
					if(!$this->controller->Acl->hasAccess('read', null, "/{$this->controller->Wannabe->event->reference}{$child['Menuitem']['path']}") && $child['Menuitem']['requireevent']) {
						unset($menu[$key]['Child'][$childkey]);
					}
				}
				if(empty($menu[$key]['Child'])) {
					unset($menu[$key]);
				}
            } else {
                unset($menu[$key]);
            }
		}
		return $menu;
	}
}
