<?php

/**
 * Component that handles terms agreement/approval
 * @Author Roy Viggo Larsen
 */
class TermHandlerComponent extends Component {

    var $terms = array();

	public function initialize(Controller $controller) {
        if(!isset($controller->Wannabe->user['User']) ||
           !$controller->Wannabe->event->reference ||
           !in_array($controller->Wannabe->user['User']['registered'], ['done', 'edit']) ||
           !$controller->requireLogin ) {
			return false;
        }
        if(strpos($controller->here, '/'.$controller->Wannabe->event->reference.'/TermAdmin') !== false ||
           strpos($controller->here, '/'.$controller->Wannabe->event->reference.'/User') !== false ||
           strpos($controller->here, '/'.$controller->Wannabe->event->reference.'/Term') !== false)
            return false;
        if($this->checkForUpdatedTerms($controller)) {
            CakeSession::write('afterTermsRedirect', $controller->here);
            $controller->redirectEvent('/Term');
            return true;
        }
        return true;
	}

    private function checkForUpdatedTerms(&$controller) {
        App::import('Model', 'Term');
        $termModel = new Term();
        $this->terms = $termModel->getTerms();
        App::import('Model', 'UserTerm');
        $userTermModel = new UserTerm();
        if(empty($this->terms)) {
            return false;
        }
        $user = $userTermModel->loadTerms($controller->Wannabe->user['User']['id'], $this->terms['Term']['id']);

        if(is_array($this->terms) && !empty($this->terms)) {
            if(!is_array($user) || empty($user) || strtotime($this->terms['Term']['updated']) > strtotime($user['UserTerm']['accepted'])) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }
}
