<?php
/**
 * Member Controller
 *
 */
class MemberController extends CfadAppController {
	public $uses = array(
		'Cfad.CfadCrew',
		'Cfad.CfadUser',
        'Crew',
        'User',
        'Phonetype'
	);

	public function index() {
		$box_into_header = array();
		$box_into_header['Header'] = __("Actions");
		$box_into_header['Link'] = array();
		$box_into_header['Link'][] = array('class' => 'btn primary', 'href' => '/cfad/Member/edit', 'title' => __("Edit"));
		$box_into_header['Link'][] = array('class' => 'btn', 'href' => '/cfad/', 'title' => __("Back"));
		$this->set('box_into_header', $box_into_header);
        $dates = $this->dates();
		$crews = $this->Crew->getCrewHierarchy(false,false);
		$members = array();
        foreach($dates as $index => $date) {
            foreach($crews as $crew) {
                $members[$index][$crew['Crew']['id']] = $this->CfadUser->getMembers($crew['Crew']['id'], $index);
            }
        }
        $this->set('dates', $dates);
		$this->set('phonetypes', $this->Phonetype->find('list'));
        $this->set('members', $members);
        $this->set('crews', $crews);
		$this->set('title_for_layout', __("Crew for a day members"));
	}

    public function edit() {
        if($this->request->is('post')) {
            foreach($this->request->data['CfadUser'] as $user) {
                $this->CfadUser->save(array('CfadUser' => $user));
            }
            $this->Flash->success(__("Members updated"));
        }
		$box_into_header = array();
		$box_into_header['Header'] = __("Back");
		$box_into_header['Link'] = array();
		$box_into_header['Link'][] = array('class' => 'btn primary', 'href' => '/cfad/Member', 'title' => __("Back"));
		$this->set('box_into_header', $box_into_header);
        $this->set('dates', $this->dates());
        $this->set('members', $this->CfadUser->getAllMembers());
        $this->set('crewnames', $this->Crew->getAllCrews(true, 0, true));
		$this->set('title_for_layout', __("Edit crew for a day members"));
    }

    public function remove($id) {
        if($this->request->is('post') && isset($this->request->data['verify-yes'])){
            //TODO: CLEAN THIS UP
            //Get user ID
            $user_id = $this->CfadUser->query("SELECT user_id FROM wb4_cfad_users WHERE id =".$id);
            $user_id = $user_id[0]['wb4_cfad_users']['user_id'];
            $this->CfadCrew->deleteMember($this->request->data['Delete']['User']);
            $this->CfadUser->query("DELETE FROM wb4_cfad_application_documents WHERE user_id = ".$user_id." AND event_id = ".$this->Wannabe->event->id);


            $this->Flash->success(__("Crew member deleted"));
            $this->redirectEvent('/cfad/Member/edit');
        } else {
            $this->set( 'header', __("Delete member"));
            $this->set( 'text', __("This action cannot be undone. Are you completely sure you want to continue?"));
            $this->set( 'hidden', array('Delete.User' => $id));
            $this->render('_verifyaction');
        }
    }

    private function dates() {
        // Calculate possible dates and prepare for view
        $start = strtotime(substr($this->Wannabe->event->show_time, 0, 10) . ' 00:00:00');
        $end = strtotime(substr($this->Wannabe->event->end, 0, 10) . ' 00:00:00');
        $dates = array();
        do $dates[date('Y-m-d H:i:s', $start)] = date('l, M j', $start);
        while ($start < $end && $start += 86400);
        return $dates;
    }
}
