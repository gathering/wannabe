<?php
class AuthController extends ApiAppController {
    public $uses = array('User', 'Api.ApiKey', 'Api.ApiApplication', 'Crew', 'User', 'Team', 'PictureApproval', 'Phonetype', 'Improtocol');
    public function index() {

        if(!$this->request->is('post')) {
           $this->throwError('Invalid request type. Use POST request for authentication.', '403');
        }

        if(
           !isset($this->request->data['app']) ||
           !isset($this->request->data['username']) ||
           !isset($this->request->data['password'])
        ) {
           $this->throwError('Wrong syntax', '403');
        }

        $application = $this->ApiApplication->find('first', array(
            'conditions' => array(
                'ApiApplication.id' => $this->request->data['app'],
                'ApiApplication.enabled' => true
            )
        ));
        if(empty($application)) {
            $this->throwError('Application authentication failed', '403');
        }

        $user = $this->User->findByUsername($this->request->data['username']);
        if(!$user) {
            $user = $this->User->findByEmail($this->request->data['username']);
        }
        if(empty($user) || !$this->User->correctPassword($user, $this->request->data['password'])) {
            $this->throwError('User authentication failed', '403');
        }
        $this->User->keepPasswordHashUpToDate($user, $this->request->data['password']);


        $this->apiUser = $user;
        $this->apiKey = $this->ApiKey->generate($user['User']['id'], $application['ApiApplication']['id']);
        $crewnames = $this->Crew->getAllCrews(true);
        $teamnames = $this->Team->getAllTeams(true);
        $userroles = $this->Crew->getUserRoles();
        $improtocols = $this->Improtocol->find('list');
        $phonetypes = $this->Phonetype->find('list');
        $user = $this->processUserResponse($user, $crewnames, $teamnames, $userroles, $phonetypes, $improtocols);
        $apikey = $this->apiKey['ApiKey']['apikey'];
        $this->set(compact('apikey', 'user'));
        $this->set('_serialize', array('apikey', 'user'));
    }
}
