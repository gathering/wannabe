<?php

class MailingListController extends AppController {
	public $uses = array('UserMailpref', 'Mailinglistaddresses', 'MailinglistaddressesNotopt', 'MailmanPassword', 'Mailinglists','Crew');

    var $layout = 'responsive-default';

	public function index() {
		$this->set('title_for_layout', __("Email settings"));

		if($this->request->is('post')) {
			foreach($this->request->data['UserMailpref'] as $mailpref) {
				$subscribe = $mailpref['subscribe'];
				$id = $mailpref['id'];
				$listid = $mailpref['mailinglist_id'];
				$mail = array(
					'UserMailpref' => array(
						'id' => $id,
						'user_id' => $this->Wannabe->user['User']['id'],
						'event_id' => $this->Wannabe->event->id,
						'mailinglist_id' => $listid,
						'subscribe' => $subscribe
					)
				);
				$this->UserMailpref->save($mail);
			}
			$this->Flash->success(__("Your preferences has been saved"));
			$this->Auth->reloadUserLogin($this->Wannabe->user['User']['id']);
		}

        $db = ConnectionManager::getDataSource("default");
		$lists = $db->fetchAll("call mailinglistmemberships(:userid, :eventid)", array(
		    "userid" => $this->Wannabe->user['User']['id'],
            "eventid" => $this->Wannabe->event->id
        ));
		$optional = array_filter($lists, function($list) {
		    return $list["ml"]["optional"] == 1;
        });
		$passwords = $this->MailmanPassword->find('all', array(
            'conditions' => array(
                'MailmanPassword.email' => $this->Wannabe->user['User']['email']
            )
        ));
		$prefs = $this->UserMailpref->find('all', array(
            'conditions' => array(
                'UserMailpref.user_id' => $this->Wannabe->user['User']['id']
            )
        ));
        foreach($optional as $key => $list) {
            $list["MailinglistaddressesNotopt"] = $list["ml"];
            $optional[$key] = $list;
            $pref = array_filter($prefs, function($pref) use ($list) {
                return $pref['UserMailpref']['mailinglist_id'] == $list['MailinglistaddressesNotopt']['mailinglist_id'];
            });
            $pref = reset(array_map(function($arr) {
                return array("UserMailpref" => reset($arr));
            }, $pref));
            if(is_array($pref) && !empty($pref)) {
                $optional[$key] += $pref;
            } else {
                $pref = array('UserMailpref' => array('id' => 0, 'subscribe' => 1));
                $optional[$key] += $pref;
            }
            $pass = array_filter($passwords, function($pass) use ($list) {
                return $pass['MailmanPassword']['mailinglist'] == $list['MailinglistaddressesNotopt']['mailinglist'];
            });
            $pass = reset(array_map(function($arr) {
                return array("MailmanPassword" => reset($arr));
            }, $pass));
            if(is_array($pass) && !empty($pass)) {
                $optional[$key] += $pass;
            }
        }
		$isModerator = false;

		foreach($lists as $key => $list) {
            $list["Mailinglistaddresses"] = $list["ml"];

            $moderator_list = $db->fetchAll("
              SELECT
              distinct u.email AS email, m.address AS mailinglist, m.moderatorpassword AS moderatorpassword 
              FROM wb4_mailinglists m 
              join wb4_users u
              join wb4_crews_users uc
              join wb4_mailinglistrules mrule
              join wb4_crews c
              WHERE
              m.address = :address
              and u.id = :userid
              and c.event_id = :eventid
              and c.id = uc.crew_id
              and uc.user_id = u.id
              and m.id = mrule.mailinglist_id
              and uc.crew_id = mrule.crew_id
              and uc.leader >= mrule.leader
              and mrule.enable_moderator = 1",
            array(
                "address" => $list["ml"]["mailinglist"],
                "userid" => $this->Wannabe->user['User']['id'],
                "eventid" => $this->Wannabe->event->id
            ));

            foreach ($moderator_list as $mod_list) {
               $list['Mailinglistmoderator']['moderatorpassword'] = $mod_list['m']['moderatorpassword'];
               $isModerator = true;
           }

            $lists[$key] = $list;

            $pass = array_filter($passwords, function($pass) use ($list) {
                return $pass['MailmanPassword']['mailinglist'] == $list['Mailinglistaddresses']['mailinglist'];
            });
            $pass = reset(array_map(function($arr) {
                return array("MailmanPassword" => reset($arr));
            }, $pass));
            if(is_array($pass) && !empty($pass)) {
                $lists[$key] += $pass;
            }
		}
		$this->set('isModerator', $isModerator);
		$this->set('lists', $lists);
        $this->set('optional', $optional);
	}
}
