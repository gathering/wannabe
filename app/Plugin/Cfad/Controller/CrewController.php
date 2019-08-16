<?php
/**
 * Crew Controller
 *
 */
class CrewController extends CfadAppController {
	public $uses = array(
		'Cfad.CfadCrew',
		'Crew'
	);

	public function index() {
        if($this->request->is('post')) {
            if($this->request->data['CfadCrew']['crew_id']) {
                $cfad = $this->CfadCrew->find('first', array(
                    'conditions' => array(
                        'CfadCrew.crew_id' => $this->request->data['CfadCrew']['crew_id']
                    )
                ));
                if(empty($cfad)) {
                    $crew = $this->Crew->find('first', array(
                        'conditions' => array(
                            'Crew.id' => $this->request->data['CfadCrew']['crew_id']
                        )
                    ));
                    if(!empty($crew) && $crew['Crew']['event_id'] == $this->Wannabe->event->id) {
                        $this->request->data['CfadCrew']['event_id'] = $this->Wannabe->event->id;
                        if($this->CfadCrew->save($this->request->data)) {
                            $this->Flash->success(__("Crew %s added", $crew['Crew']['name']));
                        }
                    } else {
                        $this->Flash->error(__("No such crew"));
                    }
                } else {
                    $this->Flash->error(__("Crew already opened"));
                }
            }
        }
		$box_into_header = array();
		$box_into_header['Header'] = __("Back");
		$box_into_header['Link'] = array();
		$box_into_header['Link'][] = array('class' => 'btn primary', 'href' => '/cfad/', 'title' => __("Back"));
		$this->set('box_into_header', $box_into_header);
        $this->set('crews', $this->Crew->getAllCrews(true, 0, true));
        $this->set('cfads', $this->CfadCrew->getCrews(false));
		$this->set('title_for_layout', __("Administer open crew for a day crews"));
	}

    public function remove($crew_id) {
        $cfad = $this->CfadCrew->find('first', array(
            'conditions' => array(
                'CfadCrew.crew_id' => $crew_id,
                'CfadCrew.event_id' => $this->Wannabe->event->id
            )
        ));
        if(!empty($cfad)) {
            if($this->CfadCrew->deleteAll(array('CfadCrew.crew_id' => $crew_id), false)) {
                $this->Flash->info(__("Crew removed"));
            }
        } else {
            $this->Flash->error(__("No such crew"));
        }
        $this->redirectEvent('/cfad/Crew');
    }
}
