<?php
/**
 * Cfad Controller
 *
 */
class CfadController extends CfadAppController {
	public $uses = array(
		'Cfad.CfadCrew',
        'Cfad.CfadUser',
        'Crew',
        'Cfad.CfadApplicationDocument'
	);

	public function index() {
        $this->set('crews', $this->Crew->getAllCrews(true, 0, true));
        $this->set('cfads', $this->CfadApplicationDocument->find('all', array(
            'conditions' => array(
                'CfadApplicationDocument.event_id' => $this->Wannabe->event->id,
                'CfadApplicationDocument.draft' => 0
            )
        )));
		$this->set('title_for_layout', __("Administer open crew for a day applications"));
	}
}
