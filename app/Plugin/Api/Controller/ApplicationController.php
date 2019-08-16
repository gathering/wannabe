<?php
/**
 * ApiApplications Controller
 *
 * @property ApiApplication $ApiApplication
 */
class ApplicationController extends ApiAppController {

    public $requireLogin = true;
    var $uses = array('Api.ApiApplication', 'Api.Apikey');
/**
 * index method
 *
 * @return void
 */
    public function index() {
		$this->ApiApplication->recursive = 0;
		$this->set('applications', $this->paginate());
        $this->set('title_for_layout', __("Api applications"));
        $this->set('desc_for_layout', __("View all applications"));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ApiApplication->create();
            if($this->ApiApplication->save($this->request->data)) {
				$this->Flash->success(__("The application has been saved"));
				$this->redirectEvent('/api/Application');
			} else {
				$this->Flash->error(__('The application could not be saved. Please, try again.'));
			}
		}
        $this->set('title_for_layout', __("API applications"));
        $this->set('desc_for_layout', __("Create new application"));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->ApiApplication->id = $id;
		if (!$this->ApiApplication->exists()) {
			throw new NotFoundException(__('Invalid application'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
            if($this->ApiApplication->save($this->request->data)) {
				$this->Flash->success(__("The application has been saved"));
				$this->redirectEvent('/api/Application');
			} else {
				$this->Flash->error(__('The application could not be saved. Please, try again.'));
                $this->set('application', $this->request->data);
			}
		} else {
			$this->set('application', $this->ApiApplication->read(null, $id));
		}
        $this->set('title_for_layout', __("API applications"));
        $this->set('desc_for_layout', __("Edit application"));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			$this->set('application', $this->ApiApplication->read(null, $id));
            $this->set('title_for_layout', __("API applications"));
            $this->set('desc_for_layout', __("Delete application"));
            $this->render();
		}
		$this->ApiApplication->id = $id;
		if (!$this->ApiApplication->exists()) {
			throw new NotFoundException(__('Invalid application'));
		}
		if ($this->ApiApplication->delete()) {
			$this->Flash->success(__("Application deleted"));
            $this->redirectEvent('/api/Application');
		}
		$this->Flash->error(__("Application was not deleted"));
        $this->redirectEvent('/api/Application');
	}
/**
 * keys method
 *
 * @param string $id
 * @return void
 */
	public function keys($id = null, $revoke = false, $key = null) {
		$this->ApiApplication->id = $id;
		if (!$this->ApiApplication->exists()) {
			throw new NotFoundException(__('Invalid application'));
		}
        if($revoke == 'revoke') {
            if(!$key) {
                throw new BadRequestException(__("No ID provided"));
            }
            $this->ApiKey->bindModel(
                array('belongsTo' => array('User'))
            );
            $key = $this->ApiKey->find('first', array(
                'conditions' => array(
                    'ApiKey.id' => $key,
                    'ApiKey.revoked' => 0,
                    'ApiApplication.enabled' => 1
                )
            ));
            if(is_array($key) && !empty($key)) {
                if($this->request->is("post")) {
                    $this->ApiKey->id = $key['ApiKey']['id'];
                    if($this->ApiKey->save(array('ApiKey' => array('revoked' => 1)))) {
                        $this->Flash->success(__("API key has been revoked"));
                    } else {
                        $this->Flash->error(__("An error occured when trying to revoke the API key"));
                    }
                    $this->redirectEvent('/api/Application/keys/'.$id);
                } else {
                    $this->set('title_for_layout', __("Revoke API key"));
                    $this->set('desc_for_layout', __("Revoke API access via %s", $key['ApiApplication']['name']));
                    $this->set('key', $key);
                    $this->render('key-revoke');
                }
            } else {
                throw new BadRequestException(__("API key not found"));
            }
        } else {
            $this->ApiApplication->bindModel(
                array('hasMany' => array('ApiKey'))
            );
            $this->ApiKey->bindModel(
                array('belongsTo' => array('User'))
            );
            $application = $this->ApiApplication->find('first', array(
                'conditions' => array(
                    'ApiApplication.id' => $id
                ),
                'recursive' => 2
            ));
            $box_into_header = array();
            $box_into_header['Header'] = __("Back");
            $box_into_header['Link'] = array();
            $box_into_header['Link'][] = array('class' => 'btn primary', 'href' => '/api/Application', 'title' => __("Back to applications"));
            $this->set('box_into_header', $box_into_header);
            $this->set('application', $application);
            $this->set('title_for_layout', __("API keys for %s", $application['ApiApplication']['name']));
            $this->set('desc_for_layout', __("Issued API keys"));
        }
	}

}
