<?php
class SmsMessageController extends AppController {

    public $uses = array('Crew', 'User', 'Accreditation', 'SmsBudget', 'SmsMessage', 'Cleanup.Cleanup', 'Cleanup.CleanupPosition', 'Userphone', 'Mailinglist','Mailinglistaddress', 'Team');

    public function index()
    {
        $this->set('title_for_layout', __("Send SMS messages"));
    }

    public function all()
    {
        $this->set('title_for_layout', __("Send SMS messages"));

        if($this->request->is('post')) {
            $numbers = array();
            $crews = $this->Crew->getAllCrews();
            foreach($crews as $crew) {
                $usersInCrew = $this->User->getMembers($crew['Crew']['id']);
                foreach($usersInCrew as $user) {
                    foreach($user['Userphone'] as $phone) {
                        if($phone['phonetype_id'] == 1)
                           $numbers[$phone['number']] = $phone['number'];
                    }
                }
            }
            $this->_checkBudgetAndSend($numbers, $this->request->data);
        }
    }

    public function chiefs()
    {
        $this->set('title_for_layout', __("Send SMS messages"));
        if($this->request->is('post')) {
            $numbers = array();
            $allCrewMembers = $this->User->getAllMembers();

            foreach($allCrewMembers as $user) {
                if($user['CrewsUser']['leader'] == 3) {
                    foreach($user['Userphone'] as $phone) {
                        if($phone['phonetype_id'] == 1)
                            $numbers[$phone['number']] = $phone['number'];
                    }
                }
            }
            $this->_checkBudgetAndSend($numbers, $this->request->data);
        }
    }


    public function mailinglist()
    {
        $this->set('title_for_layout', __("Send SMS messages"));
        if($this->request->is('post')) {
            $numbers = array();


            $list = $this->request->data['SmsMessage']['eid'];

            if($list == null or $list == '') {
                $this->Flash->error(__("The mailinglist was not found"));
                $this->redirectEvent('/SmsMessage/mailinglist/');
            }

            // Get members fro regular mailinglist rules
            $members = $this->Mailinglistaddress->find('all', array(
                'conditions' => array(
                    'Mailinglistaddress.mailinglist' => $list
                ),
                'order' => 'Mailinglistaddress.realname ASC'
            ));

            if($members == null or count($members) <= 0) {
                $this->Flash->error(__("The mailinglist was not found"));
                $this->redirectEvent('/SmsMessage/mailinglist/');
            }

            foreach ($members as $member) {
                $user = $this->User->find('first', array('conditions' => array('User.email' => $member['Mailinglistaddress']['address'])));
                $phones = $this->Userphone->findAllByUserId($user['User']['id']);
                foreach($phones as $phone) {
                    if($phone['Userphone']['phonetype_id'] == 1)
                        $numbers[$phone['Userphone']['number']] = $phone['Userphone']['number'];
                }
            }

            $this->_checkBudgetAndSend($numbers, $this->request->data);
        }

        $this->set('mailinglists', $this->Mailinglist->find('list', array(
            'conditions' => array(
                'Mailinglist.event_id' => $this->Wannabe->event->id
            ),
            'order' => 'address ASC'
        )));

    }

    private function _checkBudgetAndSend($numbers, $data)
    {
        if(!is_array($data) && !is_array($numbers))
            $this->_checkBudgetAndSend(array($numbers), array($data));

        // Check if budget is adequate
        $msg_length = (1 + floor(mb_strlen($data['SmsMessage']['content'], 'UTF-8')/160));
        $uid = $this->Wannabe->user['User']['id'];

        $budget = $this->SmsBudget->getBudgetForUser($uid);

        // Check if no budget rows in db are linked to this user.
        if (sizeof($budget) < 1) {
            $this->Flash->error(__("You have no budget registered to your account."));
            $this->redirect($this->referer());
        }

        $sent = (int)$budget['SmsBudget']['sms_sent'];
        $limit = (int)$budget['SmsBudget']['sms_limit'];

        $recieverCount = count($numbers);

        if(($sent + ($recieverCount * $msg_length)) <= $limit) {
            $budget['SmsBudget']['sms_sent'] += ($recieverCount * $msg_length);
            $this->SmsBudget->save($budget);

            if($errors = $this->SmsMessage->send($uid, $numbers, $data['SmsMessage']['content'])) {
                $this->Flash->warning(__('All messages sent, except: ').$this->_arrayToString($errors));
                $this->redirect($this->referer());
            }else{
                $this->Flash->success(__("Your messages were sent"));
                $this->redirect($this->referer());
            }
        }else{
                $this->Flash->error(__("You do not have enough quota to send"));
        }
    }

    private function _arrayToString($array)
    {
        return implode(',', $array);
    }

    public function teams()
    {
        $this->set('title_for_layout', __("Send SMS messages"));

        $crews = array();
        foreach($this->Crew->getAllCrews() as $crew) {
            $crews[$crew['Crew']['id']] = $crew['Crew']['name'];
        }

        $this->set('crews', $crews);

        if($this->request->is('post')) {

            $usersInCrew = $this->User->getMembers($this->request->data['SmsMessage']['crew']);
            foreach($usersInCrew as $user) {
                foreach($user['Userphone'] as $phone) {
                    if($phone['phonetype_id'] == 1)
                       $numbers[$phone['number']] = $phone['number'];
                }
            }

            $this->_checkBudgetAndSend($numbers, $this->request->data);
        }
    }

    public function real_teams()
    {
        $this->set('title_for_layout', __("Send SMS messages to teams"));

        $crews = array();
        foreach($this->Crew->getTeamList() as $id => $team) {
            $teams[$id] = $team;
        }

        $this->set('teams', $teams);

        if($this->request->is('post')) {
            $usersInTeam = $this->Crew->query('SELECT user_id from wb4_crews_users where team_id = '.$this->request->data['SmsMessage']['team'].';');
                foreach($usersInTeam as $users) {
                    $user_id = $users['wb4_crews_users']['user_id'];
                        $user = $this->User->findById($user_id);
                        foreach($user['Userphone'] as $phone) {
                            if ($phone['phonetype_id'] == 1)
                                $numbers[$phone['number']] = $phone['number'];
                        }
                    }

            $this->_checkBudgetAndSend($numbers, $this->request->data);
        }
    }

    public function user()
    {
        $this->set('title_for_layout', __("Send SMS messages"));

        if($this->request->is('post')) {
            $user = $this->User->find('first', array('conditions' => array('User.id' => $this->request->data['SmsMessage']['user'])));
                if(sizeof($user) < 1) {
                    $this->Flash->error(__("The user id was not found"));
                    $this->redirectEvent('/SmsMessage/user/');
                }

            foreach($user['Userphone'] as $phone)
                if($phone['phonetype_id'] == 1)
                    $numbers[$phone['number']] = $phone['number'];

            if(!empty($numbers))
                $this->_checkBudgetAndSend($numbers, $this->request->data);
        }
    }

    public function users()
    {
        $this->set('title_for_layout', __("Send SMS messages"));

        if($this->request->is('post')) {
            $this->request->data['SmsMessage']['users'] = trim($this->request->data['SmsMessage']['users']);
            $uids = explode(',', $this->request->data['SmsMessage']['users']);
            $users = array();
            $numbers = array();

            foreach($uids as $uid) {
                $user = $this->User->find('first', array('conditions' => array('User.id' => $uid)));
                if(empty($user))
                    continue;
                else
                    array_push($users, $user);
            }

            foreach($users as $user) {
                foreach($user['Userphone'] as $phone) {
                    if($phone['phonetype_id'] == 1)
                        $numbers[$phone['number']] = $phone['number'];
                }
            }

            if(empty($numbers)) {
                $this->Flash->error(__("You have not entered any valid users"));
                $this->redirectEvent('/SmsMessage/users/');
            }

            $this->_checkBudgetAndSend($numbers, $this->request->data);
        }
    }

    public function numbers()
    {
        $this->set('title_for_layout', __("Send SMS messages"));

        if($this->request->is('post')) {
            $this->request->data['SmsMessage']['numbers'] = trim($this->request->data['SmsMessage']['numbers']);
            $numbers = explode(',', $this->request->data['SmsMessage']['numbers']);
            $this->_checkBudgetAndSend($numbers, $this->request->data);
        }
    }

    public function accreditationAlerts() {
        $this->set('title_for_layout', __("Send SMS messages"));

        if($this->request->is('post')) {
            $numbers = $this->Accreditation->getPhoneFromAcceptedAccreditationsWithSmsAlerts($this->Wannabe->event->id);
            if(!empty($numbers)) {
                $this->_checkBudgetAndSend($numbers, $this->request->data);
            }
        }
    }

    public function accreditation() {
        $this->set('title_for_layout', __("Send SMS messages"));

        if($this->request->is('post')) {
            $numbers = $this->Accreditation->getPhoneFromAcceptedAccreditations($this->Wannabe->event->id);
            if(!empty($numbers)) {
                $this->_checkBudgetAndSend($numbers, $this->request->data);
            }
        }
    }
    public function cleanups()
    {
        $this->set('title_for_layout', __("Send SMS messages"));

        $times = $this->Cleanup->find('list', array(
            'conditions' => array(
                'Cleanup.event_id' => WB::$event->id
            ),
            'order' => array(
                'Cleanup.time ASC'
            )
        ));
        $this->set('times', $times);

        if($this->request->is('post')) {

            $users = $this->CleanupPosition->getCleaners($this->request->data['SmsMessage']['cid']);

            $numbers = array();

            foreach($users as $user) {
                $phones = $this->Userphone->findAllByUserId($user['User']['id']);
                foreach($phones as $phone) {
                    if($phone['Userphone']['phonetype_id'] == 1)
                        $numbers[$phone['Userphone']['number']] = $phone['Userphone']['number'];
                }
            }
            $this->_checkBudgetAndSend($numbers, $this->request->data);
        }

    }
}
