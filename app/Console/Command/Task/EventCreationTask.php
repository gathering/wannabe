<?php
class EventCreationTask extends Shell {
    public $uses = array('Event');
    public function execute() {
		$this->out(__d('cake_console', 'Create new event'));
		$this->hr();
		$this->out(__d('cake_console', 'Enter event details'));
        $event = array();
        do {
            if(isset($event['name']) && $this->Event->findByName($event['name'])) {
                $this->err(__d('cake_console', 'An event with that name already exits, please choose another…'));
            }
            $event['name'] = $this->in(__d('cake_console', 'Name of event'), null, "The Gathering ".(date('Y')+1));
        } while($this->Event->findByName($event['name']));
        do {
            if(isset($event['reference']) && $this->Event->findByReference($event['reference'])) {
                $this->err(__d('cake_console', 'An event with that reference already exits, please choose another…'));
            }
		    $event['reference'] = $this->in(__d('cake_console', 'Reference/shot name of event'), null, "tg".(substr(date('Y'),2)+1));
        } while($this->Event->findByReference($event['reference']));
        $event['reference'] = Inflector::slug($event['reference']);
        do {
            if(isset($event['email']) && !Validation::email($event['email'])) {
                $this->err(__d('cake_console', '%s is not a valid email.', $event['email']));
            }
            $event['email'] = $this->in(__d('cake_console', 'Support email'), null, 'wannabe@lovelan.no');
        } while(!Validation::email($event['email']));
		$event['hide'] = strtoupper($this->in(__d('cake_console', 'Should I hide the event from front page?'), array('Y', 'N'), 'Y'));
		$event['disable'] = strtoupper($this->in(__d('cake_console', 'Should the event be disabled for all users? (if yes, only superusers are allowed)'), array('Y', 'N'), 'Y'));
        if($event['hide'] == 'Y') $event['hide'] = 1;
        else $event['hide'] = 0;
        if($event['disable'] == 'Y') $event['disable'] = 1;
        else $event['disable'] = 0;
        $event['can_apply_for_crew'] = 0;
        $this->hr();
        $this->out(__d('cake_console', 'I will now create the following event:'));
        $this->hr();
        foreach($event as $key => $value) {
            if(preg_match('/^(hide|disable|can_apply_for_crew)$/', $key)) {
                if($value == 0) $value = __d('cake_console', 'No');
                else $value = __d('cake_console', 'Yes');
            }
            $this->out(Inflector::humanize($key).": ".$value);
        }
        $proceed = strtoupper($this->in(__d('cake_console', 'Look okay?'), array('Y', 'N'), 'N'));
        $event['id'] = 0;
        if($proceed == 'Y') {
            $this->Event->create(array('Event' => $event));
            if($this->Event->save()) {
                $this->out('<info>Event created!</info>');
                $event['id'] = $this->Event->getLastInsertID();
                return(array('Event' => $event));
            } else {
                $this->error('Error creating event!');
            }
        }
        else
            $this->error('User aborted!');
    }
}
