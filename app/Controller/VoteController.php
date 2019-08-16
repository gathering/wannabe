<?

class VoteController extends AppController {
    public $uses = array('Crew', 'User', 'VoteCampaign', 'VoteVote', 'VoteOption');

    /**
	 * Set requireLogin to false if result is accessed.
	 */
	public function beforeFilter() {
		if(
			$this->request->params['action'] == 'Result' ||
			$this->request->params['action'] == 'result'
		) {
			$this->requireLogin = false;
		}
		parent::beforeFilter();
	}

    public function index() {
        $this->set('title_for_layout',__("Voting system"));
        $this->set('campaigns', $this->VoteCampaign->find('all', array(
            'conditions' => array(
                'event_id' => $this->Wannabe->event->id
            )
        )));
    }

    public function view($id=0) {
        if (!$id) {
            return $this->redirectEvent('/Vote');
        }

        $campaign = $this->VoteCampaign->find('first', array(
            'conditions' => array(
                'id' => $id
            )
        ));
        if ($campaign['VoteCampaign']['event_id'] != $this->Wannabe->event->id) {
            return $this->redirectEvent('/Vote');
        }
        if (strtotime($campaign['VoteCampaign']['starts']) > time()) {
            throw new BadRequestException(__("Campaign not yet open. Opens %s", strftime(__("%b %e %G, %H:%M"), strtotime($campaign['VoteCampaign']['starts']))));
        }
        $this->set('campaign', $campaign);
        $this->set('campaignvalid', $this->campaignValidation($campaign));
        $this->set('vote', $this->VoteVote->find('first', array(
            'conditions' => array(
                'VoteVote.user_id' => $this->Wannabe->user['User']['id'],
                'VoteVote.campaign_id' => $id
            )
        )));
        $this->set('title_for_layout', $campaign['VoteCampaign']['name']);
        $this->set('desc_for_layout', $campaign['VoteCampaign']['short_desc']);
    }

    public function registerVote() {
        $this->request->data['VoteVote']['user_id'] = $this->Wannabe->user['User']['id'];
        if($this->VoteVote->save($this->request->data)) {
            $this->Flash->success(__("Saved"));
            $this->redirectEvent('/Vote/View/'.(int)$this->request->data['VoteVote']['campaign_id']);
        }
    }

    public function result($id=0) {
        $this->set('title_for_layout',__("Voting system"));
        $this->set('desc_for_layout','');
        if (!$id) {
            return $this->redirectEvent('/');
        }
        $campaign = $this->VoteCampaign->find('first', array(
            'conditions' => array(
                'id' => $id
            )
        ));
        if ($campaign['VoteCampaign']['event_id'] != $this->Wannabe->event->id) {
            return $this->redirectEvent('/');
        }
        if (strtotime($campaign['VoteCampaign']['starts']) > time()) {
            throw new BadRequestException(__("Campaign not yet open. Opens %s", strftime(__("%b %e %G, %H:%M"), strtotime($campaign['VoteCampaign']['starts']))));
        }
        if(!$this->Auth->isLoggedIn) {
            $this->layout = 'front-generic-long';
        }
        if(isset($_POST['passphrase'])) {
            $passphrase = $_POST['passphrase'];
            if ($campaign['VoteCampaign']['passphrase'] != $passphrase) {
                $this->Flash->error(__("Auth failed"));
                $this->render('login');
            }
            $crews = $this->Crew->getCrewHierarchy(false);
            $members = array();
            foreach($crews as $crew) {
                $members[$crew['Crew']['id']] = $this->User->getMembers($crew['Crew']['id']);
            }
            $cleanmemberlist = array();

            foreach ( $members as $crew_id => $crewmembers ){
                foreach ( $crewmembers as $member ) {
                    $cleanmemberlist[$member['User']['id']] = $member;
                }
            }
            $this->set('crewcount', count($cleanmemberlist));
            $this->set('campaign', $campaign);
            $this->set('campaignvalid', $this->campaignValidation($campaign));
            $this->set('title_for_layout', $campaign['VoteCampaign']['name']);
            $this->set('desc_for_layout', $campaign['VoteCampaign']['short_desc']);
        } else {
            $this->render('login');
        }
    }

    private function campaignValidation($campaign) {
        $now = time();
        $begins = strtotime($campaign['VoteCampaign']['starts']);
        $ends = strtotime($campaign['VoteCampaign']['ends']);
        if ($now >= $begins && $now <= $ends) {
            return true;
        }
        return false;
    }

}
