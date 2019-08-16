<?php

class ShowupTimesController extends AppController {

    public $uses = array('ShowupTime', 'User', 'Crew');

    public function index() {

        $userid = $this->Wannabe->user['User']['id'];
        $eventid = $this->Wannabe->event->id;

        $data = $this->ShowupTime->find('first', array('conditions' => array(
            'ShowupTime.user_id' => $userid,
            'ShowupTime.event_id' => $eventid)));

        $this->set('data', $data);
        if(isset($data['ShowupTime']['message']))
            if($data['ShowupTime']['message'])
                $this->Flash->error(('<strong>('.__("Message from leader").')</strong> '.$data['ShowupTime']['message']));

        if($this->request->is('post')) {
            if($object = $this->ShowupTime->find('first', array('conditions' => array(
                'ShowupTime.user_id' => $userid,
                'ShowupTime.event_id' => $eventid)))) {
                $this->request->data['ShowupTime']['approved'] = 0;
                $this->request->data['ShowupTime']['message'] = "";
                $this->ShowupTime->id = $object['ShowupTime']['id'];
            }

            $this->request->data['ShowupTime']['user_id'] = $userid;
            $this->request->data['ShowupTime']['event_id'] = $eventid;
            if($this->ShowupTime->save($this->request->data)) {
                $crews = $this->getCrewsForUser($this->Wannabe->user, 0);
                if(!empty($crews)) {
                    foreach($crews as $crew) {
                        $this->User->clearMemberCache($crew);
                    }
                }
                $this->Flash->success(__("Show up time was saved"));
                $this->redirectEvent('/');
            }
        }

        // Calculate possible showuptimes and prepare for view
        // Adding 2 hours as a dirty hack to fix DST problems
        $start = strtotime(substr($this->Wannabe->event->start, 0, 10) . ' 00:00:00') - (86400*8 + 2*60*60);
        $end = strtotime(substr($this->Wannabe->event->end, 0, 10) . ' 00:00:00');
        $showuptimedate = array();
        while ($start < $end && $start += 86400)
            $showuptimedate[date('Y-m-d', $start)] = date('l, M j', $start);
        $this->set('dates', $showuptimedate);

        $this->set('title_for_layout', __("Set showup time"));
        $this->set('ordinary_show_time', strftime('%A, %e %B, %H:%M', strtotime($this->Wannabe->event->show_time)));
    }

    public function moderate() {
        if($this->request->is('post')) {
            if(!isset($this->request->data['ShowupTime'])) {
                $this->Flash->error(__("No changes to save"));
                $this->redirectEvent('/ShowupTimes/moderate');
            }

            foreach($this->request->data['ShowupTime'] as $userid => $showup) {

                if($object = $this->ShowupTime->find('first', array('conditions' => array(
                    'ShowupTime.user_id' => $userid,
                    'ShowupTime.event_id' => $this->Wannabe->event->id)))) {
                    $this->ShowupTime->id = $object['ShowupTime']['id'];
                }

                if($this->ShowupTime->save($this->request->data['ShowupTime'][$userid])) {
                    $crews = $this->getCrewsForUser($this->Wannabe->user, 0);
                    if(!empty($crews)) {
                        foreach($crews as $crew) {
                            $this->User->clearMemberCache($crew);
                        }
                    }

                $this->Flash->success(__("Objects were moderated"));
                }
            }
        }

        $thisUser = $this->Wannabe->user;
        $crewsAndMembers = array();

        // For each crew user is member of, get uids
        foreach($thisUser['Crew'] as $crew) {
            $users = $this->User->getMembers($crew['id']);
            $crewsAndMembers[$crew['name']] = $users;
            $childCrews = $this->Crew->getChildCrews($crew['id']);
            foreach($childCrews as $childCrew) {
                $users = $this->User->getMembers($childCrew['Crew']['id']);
                $crewsAndMembers[$childCrew['Crew']['name']] = $users;
            }
        }
        $this->set('showups', $crewsAndMembers);
        $this->set('title_for_layout', __("Moderate showup times"));
    }

    public function view() {
		$crews = $this->Crew->getCrewHierarchy(false);
		$members = array();
		foreach($crews as $crew) {
			$members[$crew['Crew']['id']] = $this->User->getMembers($crew['Crew']['id']);
		}
        $start = strtotime(substr($this->Wannabe->event->start, 0, 10) . ' 00:00:00') - (86400*8 + 2*60*60);
        $end = strtotime(substr($this->Wannabe->event->end, 0, 10) . ' 00:00:00');
        $showuptimedate = array();
        while ($start < $end && $start += 86400)
            $showuptimedate[date('Y-m-d', $start)] = date('Y-m-d, D', $start);
        $showups = $this->ShowupTime->getAllShowups();
        $this->set('members', $members);
        $this->set('dates', $showuptimedate);
        $this->set('showups', $showups);
        $this->set('title_for_layout', __("Show showup times"));
    }
}
