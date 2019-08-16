<?php
class UsersController extends ApiAppController {
    public $uses = array('User', 'Api.ApiKey', 'Api.ApiApplication', 'Crew', 'User', 'Team', 'PictureApproval', 'Phonetype', 'Improtocol');
    public function index($action='all') {
        if(isset($this->request->query['q']))
            return $this->search($this->request->query['q']);
        if(isset($this->request->query['approved']))
            return $this->approved();
        return $this->all();
    }

    public function view($id) {
        $user = $this->User->findById($id);
        if(is_array($user) && !empty($user) && $this->Acl->hasMembershipToEvent($user)) {
            $crewnames = $this->Crew->getAllCrews(true);
            $teamnames = $this->Team->getAllTeams(true);
            $userroles = $this->Crew->getUserRoles();
            $improtocols = $this->Improtocol->find('list');
            $phonetypes = $this->Phonetype->find('list');
            $user = $this->processUserResponse($user, $crewnames, $teamnames, $userroles, $phonetypes, $improtocols);
            $this->set(compact('user'));
            $this->set('_serialize', array('user'));
        } else {
            $this->throwError("No such user", '404');
        }
    }

    private function search($search) {
        $users = array();
        $crewnames = $this->Crew->getAllCrews(true);
        $crew = isset($this->request->query['crew']) ? $this->request->query['crew'] : null;
        $assigned = isset($this->request->query['assigned']) && strcasecmp($this->request->query['assigned'], 'true') == 0 ? $this->request->query['assigned'] : false;

        if((int)$crew > 0) {
            $crew = $this->Crew->findById($crew);
        }
        else if($crew) {
            $crew = $this->Crew->findByFullName($crew);
        }
        if($search) {
            foreach($this->User->search($search, $crew, $assigned) as $user) {
                $users[] = $this->User->findById($user['User']['id']);
            }
        }
        $response = array();
		$teamnames = $this->Team->getAllTeams(true);
        $userroles = $this->Crew->getUserRoles();
        $improtocols = $this->Improtocol->find('list');
        $phonetypes = $this->Phonetype->find('list');
        foreach($users as $user) {
            $response['user'][] = $this->processUserResponse($user, $crewnames, $teamnames, $userroles, $phonetypes, $improtocols);
        }
        $users = $response;
        $this->set(compact('users'));
        $this->set('_serialize', array('users'));
    }

    private function approved() {
        return $this->all(true);
    }

    private function all($approved=false) {
        $users = array();
        $crewnames = $this->Crew->getAllCrews(true);
        foreach($crewnames as $crew_id => $crewname) {
            if($approved) {
                if(!$this->Acl->hasAccess('manage', $this->apiUser))
                    $this->throwError('Access denied', '403');
                $members = $this->User->getMembersWithApprovedPicture($crew_id);
            } else {
                $members = $this->User->getMembers($crew_id);
            }
            foreach($members as $member) {
                $member['Crew']['CrewsUser'] = $member['CrewsUser'];
                if(!isset($users[$member['User']['id']])) {
                    $users[$member['User']['id']] = $member;
                    $users[$member['User']['id']]['Crew'] = array($member['Crew']);
                } else {
                    $users[$member['User']['id']]['Crew'][] = $member['Crew'];
                }
            }
        }
        $response = array();
		$teamnames = $this->Team->getAllTeams(true);
        $userroles = $this->Crew->getUserRoles();
        $improtocols = $this->Improtocol->find('list');
        $phonetypes = $this->Phonetype->find('list');
        foreach($users as $user) {
            $response['user'][] = $this->processUserResponse($user, $crewnames, $teamnames, $userroles, $phonetypes, $improtocols);
        }
        $users = $response;
        $this->set(compact('users'));
        $this->set('_serialize', array('users'));
    }
    public function pictureStatus($mode='fetched') {
        $user_id = $this->request->query['user_id'];
        if(!$this->Acl->hasAccess('manage', $this->apiUser))
            $this->throwError('Access denied', '403');
        if(!isset($this->request->query['user_id']))
            $this->throwError('No user given');
        $action = '';
        switch($mode) {
            case 'fetched':
                $action = 'setFetched';
                break;
            case 'printed':
                $action = 'setPrinted';
                break;
            default:
                $this->throwError('Invalid action');
                break;
        }
        if(!$this->PictureApproval->$action($user_id))
            $this->throwError('Error occured', '500');
        $success = true;
        $this->set(compact('success'));
        $this->set('_serialize', array('success'));
    }
}
