<?php
App::uses('ExceptionRenderer', 'Error');
class WannabeExceptionRenderer extends ExceptionRenderer {

	public function render() {
        $this->controller->layout = 'responsive-default';
		if ($this->method) {
            $locale = Configure::read('language');
            $olang = array('nob', 'Norsk');
            if($olang[0] == $locale) {
                $olang = array('eng', 'English');
            }
            $this->controller->Wannabe->user = WB::$user;
            $this->controller->Wannabe->menu = WB::$menu;
            $this->controller->Wannabe->searchAccess = WB::$searchAccess;
            $this->controller->set('olang', $olang);
            $this->controller->set('wannabe', $this->controller->Wannabe);
            $this->controller->set('searchAccess', $this->controller->Wannabe->searchAccess);
			if(!isset($this->controller->request->params['eventPrefix'])) {
				if(!isset($this->controller->request->params['controller'])) {
					if (Configure::read('debug') == 0 && $this->error instanceof CakeException) {
					  $this->controller->Flash->error(__("No event named %s", $this->controller->request->here()));
					//	$this->controller->Session->setFlash(__("No event named %s", $this->controller->request->here()), 'error');
						$this->controller->redirect("/");
					}

				}
			} else {
				$this->controller->set('wannabe', $this->controller->Wannabe);
			}
			if (Configure::read('debug') != 0) {
				$this->controller->set('desc_for_layout', $this->error->getMessage());
				$this->controller->set('title_for_layout', __("Development error: ".get_class($this->error)));
				$this->controller->set('request', $this->controller->request);
			}
			call_user_func_array(array($this, $this->method), array($this->error));
		}
	}
/**
 * Convenience method to display a 400 series page.
 *
 * @param array $params Parameters for controller
 */
    public function error400($error) {
        if($this->controller->request->params['plugin'] == "api" && !$this->controller->requireLogin) {
            $this->controller->RequestHandler->renderAs($this->controller, 'json');
        }
        $message = $error->getMessage();
        if (Configure::read('debug') == 0 && $error instanceof CakeException) {
            $message = __('Page not found (404)');
        } else {
            $this->controller->set('messageError', true);
        }
        $url = $this->controller->request->here();
        $this->controller->response->statusCode($error->getCode());
        $code = $error->getCode();
        $name = $message;
        $error_json = array('error' => compact('code', 'url', 'name'));
		if(!($error instanceof CakeException)) {
            $this->controller->set(array(
				'title_for_layout' => __("The page returned an error"),
				'desc_for_layout' => $message,
                'error_out' => $error_json,
				'name' => $message,
				'url' => h($url),
                'error' => $error,
			));
		} else {
            $this->controller->set(array(
				'title_for_layout' => $message,
                'desc_for_layout' => '',
                'error_out' => $error_json,
				'name' => $message,
				'url' => h($url),
                'error' => $error,
			));
		}
	    if($error instanceof ForbiddenException) {
            if($message) {
                $this->controller->set(array(
                    'title_for_layout' => __("You do not have privileges to access this page."),
                    'desc_for_layout' => __("403 Forbidden: %s", $message),
                    'error_out' => $error_json,
                    'name' => $message,
                    'url' => h($url),
                    'error' => $error,
                ));
            } else {
                $this->controller->set(array(
                    'title_for_layout' => __("You do not have privileges to access this page."),
                    'desc_for_layout' => __("403 Forbidden: %s", h($url)),
                    'error_out' => $error_json,
                    'name' => $message,
                    'url' => h($url),
                    'error' => $error,
                ));
            }
		}
        $this->_outputMessage('error400');
    }

/**
 * Convenience method to display a 500 page.
 *
 * @param array $params Parameters for controller
 */
    public function error500($error) {
        if($this->controller->request->params['plugin'] == "api" && !$this->controller->requireLogin) {
            $this->controller->RequestHandler->renderAs($this->controller, 'json');
        }
        $message = __d('cake', 'An internal error has occurred');
        $url = $this->controller->request->here();
        $code = ($error->getCode() > 500) ? $error->getCode() : 500;
        $this->controller->response->statusCode($code);
        $name = $message;
        $error_json = array('error' => compact('code', 'url', 'name'));
        $this->controller->set(array(
			'title_for_layout' => __d('cake', 'An internal error has occurred'),
			'desc_for_layout' => '',
            'error_out' => $error_json,
            'name' => __d('cake', 'An internal error has occurred'),
            'message' => h($url),
            'url' => h($url),
            'error' => $error,
        ));
        $this->_outputMessage('error500');
    }
}
