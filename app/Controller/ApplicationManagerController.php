<?php
/**
 * ApplicationManager Controller
 *
 */
class ApplicationManagerController extends AppController {

	public $uses = array(
		'ApplicationField',
		'ApplicationChoice',
		'ApplicationAvailableField',
		'ApplicationPage',
		'ApplicationFieldType',
		'ApplicationDocument',
		'Crew',
		'ApplicationSetting',
		'EnrollSetting',
		'EnrollGreeting'
	);

	public function index() {
		$this->redirectEvent('/ApplicationManager/Question');
	}

	public function question($crew_id=0) {
		$this->set('title_for_layout', __("Application questions"));
		$this->set('desc_for_layout', __("Create or edit questions for your crew"));
		$change = false;
		if(isset($this->data['ApplicationAvailableField']['update'])) {
			$this->ApplicationAvailableField->save($this->data);
			$this->Flash->success(__("Question updated"));
			$change = true;
		}
		if(isset($this->data['ApplicationAvailableField']['delete'])) {
			$this->ApplicationAvailableField->delete($this->data['ApplicationAvailableField']['id'], false);
			$this->Flash->success(__("Question deleted"));
			$change = true;
		}
		if(isset($this->data['ApplicationAvailableField']['new'])) {
			if($this->data['ApplicationAvailableField']['crew_id'] != 0) {
				$this->ApplicationAvailableField->create();
				$this->ApplicationAvailableField->save($this->data);
				$this->Flash->success(__("Question created"));
			}
			$change = true;
		}
		if($change) {
			Cache::delete(WB::$event->reference.'-application_pages');
		}
		$settings = $this->ApplicationSetting->getSettings();
		if(!$settings['ApplicationSetting']['crewquestion']) {
			throw new BadRequestException('Crew Question not active for this event.');
		}

        $manageable_crews = array();

        # Super users have access to all crews
        if ($this->Acl->hasAccess('superuser', $this->Wannabe->user, '/'.$this->Wannabe->event->reference.'/Enroll')) {
            foreach ($this->Crew->find('all', array('conditions' => array('Crew.event_id' => WB::$event->id))) as $crew2){
                $manageable_crews[$crew2['Crew']['id']] = array($crew2['Crew']['id'], $crew2['Crew']['name']);
                $crews[$crew2['Crew']['id']] = $crew2['Crew']['name'];
            }
        } else {
            # Get the users crews
            foreach ($this->Wannabe->user['Crew'] as $usercrew) {
                if (0 <= $usercrew['CrewsUser']['leader']){
                    $manageable_crews[$usercrew['id']] = array($usercrew['id'], $usercrew['name']);
                    $crews[$usercrew['id']] = $usercrew['name'];
                    $crews2 = $this->Crew->query("SELECT id, crew_id, name FROM (SELECT id, crew_id, name FROM wb4_crews) Crew, (SELECT @pv := '".$usercrew['id']."') initialisation WHERE find_in_set(crew_id, @pv) > 0 AND @pv := concat(@pv, ',', id) ORDER BY name");
                    foreach ($crews2 as $crew2){
                        $manageable_crews[$crew2['Crew']['id']] = array($crew2['Crew']['id'],$crew2['Crew']['name']);
                        $crews[$crew2['Crew']['id']] = $crew2['Crew']['name'];
                    }
                }
            }
        }

		$fields = array();
		if($crew_id != 0) {
		    if(!array_key_exists ($crew_id,$crews)) {
                throw new BadRequestException(__("Not allowed"));
            }
			$fields = $this->ApplicationAvailableField->find('all', array(
				'conditions' => array(
					'ApplicationAvailableField.crew_id' => $crew_id
				)
			));
		} else {
			foreach ($manageable_crews as $crew) {
					$tempfields = $this->ApplicationAvailableField->find('all', array(
						'conditions' => array(
							'ApplicationAvailableField.crew_id' => $crew[0]
						)
					));
					if(!empty($tempfields)) {
						$fields = array_merge($fields, $tempfields);
					}
				}
		}
		$page = $this->ApplicationPage->find('first', array(
			'conditions' => array(
				'ApplicationPage.event_id' => WB::$event->id,
				'ApplicationPage.type' => 'crewquestion'
			)
		));
		if(isset($page['ApplicationPage']['id'])){
		    $this->set('pageid', $page['ApplicationPage']['id']);
        } else {
            $this->set('pageid', NULL);
        }

		$this->set('fields', $fields);
		$this->set('manageable_crews', $manageable_crews);
		$this->set('crews', $crews);
		$this->set('filter_id', $crew_id);
		$this->render('crewquestion');
	}

	public function filter() {
		$this->redirectEvent('/ApplicationManager/Question/'.$this->data['crew_id']);
	}

	public function greeting($crew_id=0) {
		$this->set('title_for_layout', __("Application greeting"));
		$this->set('desc_for_layout', __("Create or edit greeting for new crew members"));
		if(!empty($this->data)) {
			$crew = $this->Crew->find('first', array(
				'conditions' => array(
					'Crew.id' => $this->data['EnrollGreeting']['crew_id']
				)
			));
			// Check to see if user is allowed to write greeting for selected crew
			if($this->Acl->hasAccessToCrew($this->Wannabe->user, $crew)) {
				if(isset($this->data['EnrollGreeting']['save'])) {
					$this->EnrollGreeting->save($this->data);
					$this->Flash->info(__("Greeting for %s saved.", $crew['Crew']['name']));
				}
                                if(isset($this->data['EnrollGreeting']['create'])) {
					$this->EnrollGreeting->save($this->data);
                                        $this->Flash->info(__("Greeting for %s created.", $crew['Crew']['name']));
					$this->redirectEvent('/ApplicationManager/greeting/'.$this->data['EnrollGreeting']['crew_id']);
                                }
				if(isset($this->data['EnrollGreeting']['delete'])) {
					$this->EnrollGreeting->delete($this->data['EnrollGreeting']['id']);
					$this->Flash->info(__("Greeting for %s deleted.", $crew['Crew']['name']));
				}
			} else {
				$this->Flash->error(__("You do not have access to write greetings for %s.", $crew['Crew']['name']));
				$this->redirectEvent('/ApplicationManager/greeting');
			}
		}
		$settings = $this->EnrollSetting->getSettings();
		if(!$settings['EnrollSetting']['greetingactive']) {
			throw new BadRequestException(__("Greeting not active for this event."));
		}

		$this->set('crews', $this->Crew->getAllCrews(true));

		if($crew_id && is_numeric($crew_id)) {
			$this->Crew->bindEnroll();
			$crew = $this->Crew->find('first', array(
				'conditions' => array(
					'Crew.id' => $crew_id
				)
			));
			if(!empty($crew)) {
				if($this->Acl->hasAccessToCrew($this->Wannabe->user, $crew)) {
					$this->data = $crew;
					$this->render('greetingEdit');
				} else {
					$this->Flash->warning(__("You have no access to view the greeting for this crew."));
					$this->redirectEvent("/ApplicationManager/greeting");
				}
			} else {
				$this->Flash->error(__("Crew not found"));
				$this->redirectEvent("/ApplicationManager/greeting");
			}

		}

        # Super users have access to all crews
        if ($this->Acl->hasAccess('superuser', $this->Wannabe->user, '/'.$this->Wannabe->event->reference.'/Enroll')) {
            foreach ($this->Crew->find('all', array('conditions' => array('Crew.event_id' => WB::$event->id))) as $crew2){
                $manageable_crews[$crew2['Crew']['id']] = array($crew2['Crew']['id'], $crew2['Crew']['name']);
                $crews[$crew2['Crew']['id']] = $crew2['Crew']['name'];
            }
        } else {
            # Get the users crews
            foreach ($this->Wannabe->user['Crew'] as $usercrew) {
                if (0 <= $usercrew['CrewsUser']['leader']){
                    $manageable_crews[$usercrew['id']] = array($usercrew['id'], $usercrew['name']);
                    $crews[$usercrew['id']] = $usercrew['name'];
                    $crews2 = $this->Crew->query("SELECT id, crew_id, name FROM (SELECT id, crew_id, name FROM wb4_crews) Crew, (SELECT @pv := '".$usercrew['id']."') initialisation WHERE find_in_set(crew_id, @pv) > 0 AND @pv := concat(@pv, ',', id) ORDER BY name");
                    foreach ($crews2 as $crew2){
                        $manageable_crews[$crew2['Crew']['id']] = array($crew2['Crew']['id'],$crew2['Crew']['name']);
                        $crews[$crew2['Crew']['id']] = $crew2['Crew']['name'];
                    }
                }
            }
        }

		$greetings = array();
		$this->set('crew_without_greeting', $crews);
		$this->set('greetings', $greetings);
	}
}
