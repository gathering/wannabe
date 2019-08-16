<?php
class EventTemplateTask extends Shell {
    public $uses = array('User', 'Event', 'Aclobject', 'AclobjectsRole', 'AclobjectsUser', 'EnrollSetting', 'EnrollMail', 'EnrollMailfield', 'ApplicationPage', 'ApplicationSetting', 'ApplicationAvailableField');
    public function execute($event = array()) {
        $this->hr();
        $this->out(__d('cake_console', 'Setting up generic templates for this event. Acl roles, application settings, enrollment options and others will have default settings after this. This can be changed via the website later on. This should be finished before you even get to read this message.'));
        $this->hr();
        if(empty($event)) {
            $this->out(__d('cake_console', '..unless no event has been specified.'));
            do {
                $given_event_id = strtoupper($this->in(__d('cake_console', 'Supply event UID for the event that should have templates')));
                $event_temp = $this->Event->findById($given_event_id);
                if(empty($event_temp)) {
                    $this->err(__d('cake_console', 'No event with UID %s found.', $given_event_id));
                }
                $this->out(__d('cake_console', 'Generating templates for %s', $event_temp['Event']['name']));
                switch(strtoupper($this->in(__d('cake_console', 'Look okay?'), array('Y', 'N'), 'Y'))) {
                    case 'Y':
                        $event = $event_temp;
                        break;
                }
            } while(empty($event));
        }
        $this->_processEnrollTemplate($event);
        $this->_processApplicationTemplate($event);
        $this->_processAclTemplate($event);
        $this->hr();
        $this->out(__d('cake_console', 'The next step is to configure access to this event'));
        $this->hr();
        $shell_username = exec('whoami');
        $user_id = 0;
        do {
            $user = array();
            $sentence = __d('cake_console', 'this is');
            do {
                if($shell_username) {
                    $this->User->loadExtras= false;
                    $user = $this->User->findByUsername($shell_username);
                    $shell_username = false;
                    $sentence = __d('cake_console', 'you are');
                } else {
                    $given_user_id = strtoupper($this->in(__d('cake_console', 'Please give be the UID of the user which shall be given superuser access for this event..')));
                    $this->User->loadExtras= false;
                    $user = $this->User->findById($given_user_id);
                    if(empty($user)) {
                        $this->err(__d('cake_console', 'No user with UID %s found.', $given_user_id));
                    }
                }
            } while(empty($user));
            $this->out(__d('cake_console', 'I have deduced that %s %s aka %s with UID %s.', $sentence, $user['User']['realname'], $user['User']['nickname'], $user['User']['id']));
            switch(strtoupper($this->in(__d('cake_console', 'Am I correct and should I grant access?'), array('Y', 'N'), 'Y'))) {
                case 'Y':
                    $user_id = $user['User']['id'];
                    break;
                case 'N':
                    $user_id=0;
                    break;
            }
        } while($user_id==0);
        $aclobject = $this->Aclobject->findByPath('/'.$event['Event']['reference'].'/*');
        if(empty($aclobject))
            $this->error(__d('cake_console', 'Superuser path not found! Exiting!'));
        $this->AclobjectsUser->create(array(
            'AclobjectsUser' => array(
                'user_id' => $user_id,
                'aclobject_id' => $aclobject['Aclobject']['id'],
                'read' => 1,
                'write' => 1,
                'manage' => 1,
                'superuser' => 1
            )
        ));
        if(!$this->AclobjectsUser->save())
            $this->error(__d('cake_console', 'Failed to add superuser! Exiting!'));
        $this->out('<info>'.__d('cake_console', 'Access granted to UID %s!', $user_id).'</info>');
        $this->hr();
        $this->out(__d('cake_console', 'All done! The event %s now has templates!', $event['Event']['name']));
        $this->hr();
    }
    public function _processEnrollTemplate($event) {
        $this->EnrollSetting->create(array(
            'EnrollSetting' => array(
                'event_id' => $event['Event']['id'],
                'enrollactive' => 0,
                'greetingactive' => 0,
                'enrollaccept' => 0
            )
        ));
        if($this->EnrollSetting->save()) {
            $id = $this->EnrollSetting->getLastInsertID();
            App::import('Config/SqlTemplate', 'EnrollMailSqlTemplate');
            $template = new EnrollMailSqlTemplate();
            foreach ($template->template as $field) {
                $field['EnrollMail']['enroll_setting_id'] = $id;
                $this->EnrollMail->create($field);
                $failed = false;
                if($this->EnrollMail->save()) {
                    $last_id = $this->EnrollMail->getLastInsertID();
                    if(!empty($field['EnrollMail']['fields'])) {
                        foreach($field['EnrollMail']['fields'] as $mailfield) {
                            $mailfield['enroll_mail_id'] = $last_id;
                            $this->EnrollMailfield->create(array('EnrollMailfield' => $mailfield));
                            if(!$this->EnrollMailfield->save()) {
                                $failed = true;
                                $this->out('<error>'.__d('cake_console', 'Failed to add field %s enroll mail %s, you will need to manually fix this!', $mailfield['name'], $field['name']).'</error>');
                            }
                        }
                    }
                } else {
                    $failed = true;
                    $this->out('<error>'.__d('cake_console', 'Failed to add enroll mail %s, you will need to manually fix this!', $field['name']).'</error>');
                }
            }
            if($failed)
                $this->out('<error>'.__d('cake_console', 'Finished with enroll settings and mails, but some failed, check error messages above.').'</error>');
            else
                $this->out('<info>'.__d('cake_console', 'Enroll settings and mails finished!').'</info>');
        } else {
            $this->out('<error>'.__d('cake_console', 'Failed to add enroll settings, you will need to manually fix this!').'</error>');
        }
    }
    public function _processApplicationTemplate($event) {
        App::import('Config/SqlTemplate', 'ApplicationSettingSqlTemplate');
        $template = new ApplicationSettingSqlTemplate();
        $failed = false;
        foreach ($template->template as $setting) {
            $setting['ApplicationSetting']['event_id'] = $event['Event']['id'];
            $this->ApplicationSetting->create($setting);
            if(!$this->ApplicationSetting->save()) {
                $failed = true;
                $this->out('<error>'.__d('cake_console', 'Failed to add application settings, you will need to manually fix this!').'</error>');
            }
        }
        if($failed)
            $this->out('<error>'.__d('cake_console', 'Finished with application setting, but something failed, check error messages above.').'</error>');
        else
            $this->out('<info>'.__d('cake_console', 'Application settings finished!').'</info>');
        App::import('Config/SqlTemplate', 'ApplicationPageSqlTemplate');
        $template = new ApplicationPageSqlTemplate();
        $failed = false;
        foreach ($template->template as $page) {
            $page['ApplicationPage']['event_id'] = $event['Event']['id'];
            $this->ApplicationPage->create($page);
            if($this->ApplicationPage->save()) {
                $id = $this->ApplicationPage->getLastInsertID();
                if(!empty($page['ApplicationPage']['fields'])) {
                    foreach($page['ApplicationPage']['fields'] as $field) {
                        $field['application_page_id'] = $id;
                        $this->ApplicationAvailableField->create(array('ApplicationAvailableField' => $field));
                        if(!$this->ApplicationAvailableField->save()) {
                            $failed = true;
                            $this->out('<error>'.__d('cake_console', 'Failed to add field %s application page %s, you will need to manually fix this!', $field['name'], $page['name']).'</error>');
                        }
                    }
                }
            } else {
                $failed = true;
                $this->out('<error>'.__d('cake_console', 'Failed to add application page %s, you will need to manually fix this!', $page['name']).'</error>');
            }
        }
        if($failed)
            $this->out('<error>'.__d('cake_console', 'Finished with application pages and fields, but some failed, check error messages above.').'</error>');
        else
            $this->out('<info>'.__d('cake_console', 'Application pages and fields finished!').'</info>');
    }
    public function _processAclTemplate($event) {
        App::import('Config/SqlTemplate', 'AclSqlTemplate');
        $aclTemplate = new AclSqlTemplate();
        foreach ($aclTemplate->template as $index => $field) {
            $aclTemplate->template[$index]['path'] = str_replace(':event', $event['Event']['reference'], $field['path-template']);
            $this->Aclobject->create(array('Aclobject' => array('path' => $aclTemplate->template[$index]['path'])));
            $failed = false;
            if($this->Aclobject->save()) {
                $last_id = $this->Aclobject->getLastInsertID();
                if(!empty($field['roles'])) {
                    foreach($field['roles'] as $role => $permission) {
                        $permission['aclobject_id'] = $last_id;
                        switch($role) {
                            case 'non-member':
                                $permission['role'] = -1;
                                break;
                            case 'member':
                                $permission['role'] = 0;
                                break;
                            case 'shiftleader':
                                $permission['role'] = 1;
                                break;
                            case 'co-chief':
                                $permission['role'] = 2;
                                break;
                            case 'chief':
                                $permission['role'] = 3;
                                break;
                            case 'organizer':
                                $permission['role'] = 4;
                                break;
                        }
                        $this->AclobjectsRole->create(array('AclobjectsRole' => $permission));
                        if(!$this->AclobjectsRole->save()) {
                            $failed = true;
                            $this->out('<error>'.__d('cake_console', 'Failed to add ACL object role for %s to %s, you will need to manually fix this!', $role, $aclTemplate->template[$index]['path']).'</error>');
                        }
                    }
                }
            } else {
                $failed = true;
                $this->out('<error>'.__d('cake_console', 'Failed to add ACL object %s, you will need to manually fix this!', $aclTemplate->template[$index]['path']).'</error>');
            }
        }
        if($failed)
            $this->out('<error>'.__d('cake_console', 'Finished with ACL objects and roles, but some failed, check error messages above.').'</error>');
        else
            $this->out('<info>'.__d('cake_console', 'ACL objects and roles finished!').'</info>');
    }
}
