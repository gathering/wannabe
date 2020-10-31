<?php
class ApiAppController extends AppController {
    public $uses = array('User', 'Api.ApiKey', 'Api.ApiApplication', 'Crew', 'User', 'Team', 'PictureApproval');
    public $components = array('RequestHandler');

    public $requireLogin = false;
    protected $apiUser = false;
    protected $apiKey = false;

    public function beforeFilter() {
        if(!$this->requireLogin) {
            if(!isset($this->request->params['ext'])) {
                $this->request->params['ext'] = 'json';
                $this->RequestHandler->renderAs($this, 'json');
            }
            if($this->request->params['controller'] != 'auth') {
                if(isset($this->request->query['apikey']) && isset($this->request->query['app'])) {
                    if(!$this->checkApiKey($this->request->query['apikey'], $this->request->query['app'])) {
                        $this->throwError('Invalid API key', '403');
                    }
                    if(!$this->Acl->hasAccess('read', $this->apiUser)) {
                        $this->throwError('Access denied', '403');
                    }
                } else {
                    $this->throwError('Access denied. API key needed', '403');
                }
            }
        }
        parent::beforeFilter();
    }
    protected function checkApiKey($key, $application) {
        if($this->ApiKey->check($key, $application)) {
            $this->apiUser = $this->User->findById($this->ApiKey->getUser($key, $application));
            return true;
        }
        return false;
    }
    protected function throwError($string, $code=404) {
        switch($code) {
            case 400:
                throw new BadRequestException($string);
                break;
            case 404:
                throw new NotFoundException($string);
                break;
            case 403:
                throw new ForbiddenException($string);
                break;
            case 405:
                throw new MethodNotAllowedException($string);
                break;
            case 500:
                throw new InternalErrorException($string);
                break;
        }
    }
    protected function processUserResponse($user, $crewnames, $teamnames, $userroles, $phonetypes, $improtocols) {
        $response = array(
            'id' => $user['User']['id'],
            'username' => $user['User']['username'],
            'realname' => $user['User']['realname'],
            'nickname' => $user['User']['nickname'],
            'age' => $user['User']['age']
        );
        $canViewDetailedInfo = false;
        if(isset($user['Crew'][0])) {
            $accessToCrew = false;
            foreach($user['Crew'] as $crew) {
                if($this->Acl->hasMembershipToCrew($this->apiUser, $crew['id'])) {
                    $accessToCrew = true;
                }
            }
            if($accessToCrew || $this->Acl->hasAccessToDetailedUserInfo($this->apiUser)) {
                $canViewDetailedInfo = true;
            }
        } else {
            if($this->Acl->hasMembershipToCrew($this->apiUser, $user['Crew']['id']) || $this->Acl->hasAccessToDetailedUserInfo($this->apiUser)) {
                $canViewDetailedInfo = true;
            }
        }
        if((isset($user['UserPrivacy']['address']) && (!$user['UserPrivacy']['address'] || $canViewDetailedInfo)) || $user['User']['id'] == $this->ApiUser['User']['id']) {
            $response['address'] = $user['User']['address'];
            $response['postcode'] = h($user['User']['postcode']);
            $response['town'] = $user['User']['town'];
            $response['countrycode'] = h($user['User']['countrycode']);
        }
        if((isset($user['UserPrivacy']['email']) && (!$user['UserPrivacy']['email'] || $canViewDetailedInfo)) || $user['User']['id'] == $this->ApiUser['User']['id']) {
            $response['email'] = h($user['User']['email']);
        }
        if((isset($user['UserPrivacy']['phone']) && (!$user['UserPrivacy']['phone'] || $canViewDetailedInfo)) || $user['User']['id'] == $this->ApiUser['User']['id']) {
            if (count($user['Userphone'])) {
                $response['phonenumbers'] = array();
                $response['phonenumbers']['phonenumber'] = array();
                foreach( $user['Userphone'] as $phone ) {
                    $response['phonenumbers']['phonenumber'][] = array(
                        'type' => array(
                            'id' => $phone['phonetype_id'],
                            'name' => $phonetypes[$phone['phonetype_id']]
                        ),
                        'number' => $phone['number']
                    );
                }
            }
        }
        if((isset($user['UserPrivacy']['birth']) && (!$user['UserPrivacy']['birth'] || $canViewDetailedInfo)) || $user['User']['id'] == $this->ApiUser['User']['id']) {
            $response['birth'] = $user['User']['birth'];
        }
        if (count($user['Userim'])) {
            $response['imaccounts'] = array();
            $response['imaccounts']['imaccount'] = array();
            foreach($user['Userim'] as $imaccount) {
                $response['imaccounts']['imaccount'][] = array(
                    'type' => array(
                        'id' => $imaccount['improtocol_id'],
                        'name' => $improtocols[$imaccount['improtocol_id']]
                    ),
                    'account' => h($imaccount['address'])
                );
            }
        }
        $response['crews'] = array();
        if(isset($user['Crew'][0])) {
            $response['crews']['crew'] = array();
            foreach($user['Crew'] as $crew) {
                $response['crews']['crew'][] = $this->processCrewResponse(array('Crew' => $crew), $crewnames, $teamnames, $userroles);
            }
        } else {
            $response['crews']['crew'] = $this->processCrewResponse($user, $crewnames, $teamnames, $userroles);
        }
        if(strlen($user['User']['image'])) {
            $response['images'] = array();
            $response['images']['image'] = array();
            foreach(array(50,100,150,200,210,256,320) as $size) {
                $response['images']['image'][] = array(
                    'url' => 'http://'.$_SERVER['SERVER_NAME'].'/'.$user['User']['image'].'_'.$size.'.png',
                    'width' => $size
                );
             }
        }
        return $response;
    }
    protected function processCrewResponse($crew, $crewnames, $teamnames, $userroles) {
        if(isset($crew['Crew']['CrewsUser']))
            $crew['CrewsUser'] = $crew['Crew']['CrewsUser'];
        $response = array(
            'id' => $crew['Crew']['id'],
            'name' => h($crewnames[$crew['Crew']['id']]),
        );
        if(isset($crew['CrewsUser'])) {
            $response['usertitle'] = $crew['CrewsUser']['title'] ? h($crew['CrewsUser']['title']) : $userroles[$crew['CrewsUser']['leader']];
            if($crew['CrewsUser']['team_id']) {
                $response['team'] = h($teamnames[$crew['CrewsUser']['team_id']]);
            }
        }
        return $response;
    }
}
