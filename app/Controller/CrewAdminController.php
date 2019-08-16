<?php

class CrewAdminController extends AppController {
	var $uses = array('Crew', 'User');

    var $layout = 'responsive-default';

	public function index() {
        $box_into_header = array();
        $box_into_header['Header'] = __("Create new crew");
        $box_into_header['Link'][] = array('class' => 'btn btn-default', 'href' => "/CrewAdmin/Create", 'title' => __("Create new crew"));

        $this->set('box_into_header', $box_into_header);

		$this->set('title_for_layout', __("Administer crews"));
		$this->set('crews', $this->Crew->find('all', array(
			'conditions' => array(
				'Crew.event_id' => $this->Wannabe->event->id
			),
            'order' => array('Crew.name')
		)));
	}
	public function create() {
		if($this->request->is('post')) {
			$this->request->data['Crew']['event_id'] = $this->Wannabe->event->id;
            if($this->request->data['Crew']['crew_id'] == NULL) {
                $this->request->data['Crew']['crew_id'] = 0;
            }
			if($this->Crew->save($this->request->data)) {
				$crew_id = $this->request->data['Crew']['crew_id'];
				$this->Crew->clearCrewCache($crew_id);
				$this->Flash->success(__("%s was created", $this->request->data['Crew']['name']));
				$this->redirectEvent('/CrewAdmin');
			}
		}
		$this->set('crewlist', $this->Crew->getAllCrews(true, 0, true));
		$this->set('title_for_layout', __("Create new crew"));
	}
	public function delete($id) {
		if($this->request->is('post')) {
			if($this->Crew->delete($this->request->data['Crew']['id'])) {
				$crew_id = $this->request->data['Crew']['id'];
				if($this->request->data['Crew']['crew_id']) {
					$crew_id = $this->request->data['Crew']['crew_id'];
				}
				$this->Crew->clearCrewCache($crew_id);
				$this->Flash->success(__("Crew deleted"));
				$this->redirectEvent('/CrewAdmin');
			}
		}
		if(!$id) {
			$this->Flash->warning(__("Select crew to delete"));
			$this->redirectEvent('/CrewAdmin');
		}
		$crew = $this->Crew->find('first', array(
			'conditions' => array(
				'Crew.id' => $id,
				'Crew.event_id' => $this->Wannabe->event->id
			)
		));
		if(!is_array($crew)) {
			throw new BadRequestException(__("No such crew"));
		}
		$this->set('crew', $crew);
		$this->set('title_for_layout', __("Delete crew"));
		$this->set('desc_for_layout', $crew['Crew']['name']);
	}
}
