<?php
class EventShell extends AppShell {
    public $uses = array('User', 'Aclobject', 'AclobjectUser', 'AclobjectRole');
    public $tasks = array('EventCreation', 'EventTemplate');
    public $event = array();
    public function main() {
        $this->event = $this->EventCreation->execute();
        $this->EventTemplate->execute($this->event);
        system(ROOT.DS."hooks".DS."post-checkout");
    }
    public function template() {
        $this->EventTemplate->execute();
        system(ROOT.DS."hooks".DS."post-checkout");
    }
}
