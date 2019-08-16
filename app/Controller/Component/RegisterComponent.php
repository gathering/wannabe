<?php

/**
 * Component that handles registration
 * @Author Roy Viggo Larsen
 */
class RegisterComponent extends Component {

	public function initialize($controller) {
		if(!isset($controller->Wannabe->user['User']) || !$controller->Wannabe->event->reference) {
			return true;
		}
		if($controller->Wannabe->user['User']['registered'] == 'done') {
			return true;
		}
		if($controller->here == '/'.$controller->Wannabe->event->reference.'/Profile/'.$controller->Wannabe->user['User']['registered'] || strpos($controller->here, '/'.$controller->Wannabe->event->reference.'/User/Verify') !== false) {
			return true;
		}
		if($controller->Wannabe->user['User']['registered'] === 'edit' && substr($controller->here, -strlen('/Term')) === '/Term') {
			return true;
		}
		if($controller->here == '/'.$controller->Wannabe->event->reference.'/User/logout') {
			return true;
		}
		$controller->redirectEvent('/Profile/'.$controller->Wannabe->user['User']['registered']);
		return true;
	}
}
