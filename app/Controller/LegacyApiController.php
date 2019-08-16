<?php
class LegacyApiController extends AppController {
    var $uses = array('User', 'ApiSession', 'Crew', 'User', 'Team');
    public $requireLogin = false;
    private $apiUser = false;
    public function beforeFilter() {
        if(!is_callable(array($this, $this->request->params['action']))) {
            $this->throwError('<?xml version="1.0" encoding="UTF-8"?><wannabe><errormsg>Page not found</errormsg></wannabe>', 404);
        }
        if($this->request->params['action'] != 'login') {
            if(isset($_GET['sessionkey'])) {
                if(!$this->checkApiSession($_GET['sessionkey'])) {
                    $this->throwError('<?xml version="1.0" encoding="UTF-8"?><wannabe><errormsg>Invalid session. New login needed.</errormsg></wannabe>', 403);
                }
                if(!$this->Acl->hasAccess('read', $this->apiUser)) {
                    $this->throwError('<?xml version="1.0" encoding="UTF-8"?><wannabe><errormsg>Access denied</errormsg></wannabe>', 403);
                }
            } else {
                $this->throwError('<?xml version="1.0" encoding="UTF-8"?><wannabe><errormsg>Access denied. Login needed.</errormsg></wannabe>', 403);
            }
        }
        $this->layout = 'legacy_api';
        parent::beforeFilter();
    }
    private function checkApiSession($key) {
        if($this->ApiSession->check($key)) {
            $this->User->loadExtras = false;
            $this->apiUser = $this->User->findById($this->ApiSession->getUser($key));
            return true;
        }
        return false;
    }
    public function login($username,$password) {
        $this->User->loadExtras = false;
        $user = $this->User->findByUsername($username);
        if(!$user) {
            $this->User->loadExtras = false;
            $user = $user->findByEmail($username);
        }
        if(empty($user) || $user['User']['password'] != $password) {
            $this->throwError('<?xml version="1.0" encoding="UTF-8"?><wannabe><errormsg>Authentication failed</errormsg></wannabe>', 403);
        }
        $this->apiUser = $user;
        $this->set('user', $user);
        $this->set('session', $this->ApiSession->generate($user));
        $this->set('crewnames', $this->Crew->getAllCrews(true));
        $this->set('teamnames', $this->Team->getAllTeams(true));
        $this->set('userroles', $this->Crew->getUserRoles());
    }
    public function users($action='all') {
        $users = array();
        $crewnames = $this->Crew->getAllCrews(true);
        switch($action) {
            case 'search':
                $search = isset($_GET['search']) && strlen($_GET['search']) ? $_GET['search'] : null;
                $crew = isset($_GET['crew']) ? $_GET['crew'] : null;
                $assigned = isset($_GET['assigned']) && strcasecmp($_GET['assigned'], 'true') == 0 ? $_GET['assigned'] : false;

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
                break;
            case 'all':
            case 'approved':
            default:
                foreach($crewnames as $crew_id => $crewname) {
                    if($action == 'approved') {
                        $members = $this->User->getMembersWithApprovedPicture($crew_id);
                    } else {
                        $members = $this->User->getMembers($crew_id);
                    }
                    foreach($members as $member) {
                        if(!isset($users[$member['User']['id']])) {
                            $users[$member['User']['id']] = $this->User->findById($member['User']['id']);
                        }
                    }
                }
                break;
        }
        $this->set('crewnames', $crewnames);
        $this->set('userroles', $this->Crew->getUserRoles());
        $this->set('teamnames', $this->Team->getAllTeams(true));
        $this->set('users', $users);
    }
    private function throwError($string, $code=404) {
        switch($code) {
            case 404:
                header('HTTP/1.1 404 Not Found');
                break;
            case 403:
                header('HTTP/1.1 403 Forbidden');
                break;
            case 500:
                header('HTTP/1.1 500 Internal Server Error');
                break;
        }
        die($string);
    }
}
