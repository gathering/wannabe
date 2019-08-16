<?php
class HomeController extends AppController {
	var $uses = array('ApplicationDocument', 'EnrollSetting', 'IrcChannelKey', 'User', 'SmsBudget', 'Cfad.CfadApplicationSetting');
    var $components = array('GeocodeCache');
		var $layout = 'responsive-default';
	public function index() {
		$this->set('geocode', $this->GeocodeCache);
		$this->set('crewmember', $this->Acl->hasMembershipToEvent($this->Wannabe->user));
		$this->set('title_for_layout', __("Welcome, %s", h($this->Wannabe->user['User']['nickname'])));
		$this->set('desc_for_layout', __("…to Wannabe for %s.", h($this->Wannabe->event->name)));
		$this->set('application', $this->ApplicationDocument->findDocumentNotDraft($this->Wannabe->user['User']['id']));
		$this->set('accessToEnroll', $this->Acl->hasAccess('manage', $this->Wannabe->user, '/'.$this->Wannabe->event->reference.'/Enroll'));
		$this->set('settings', $this->EnrollSetting->getSettings());
        $this->set('cfadSettings', $this->CfadApplicationSetting->getSettings());
        $this->set('accessToCfad', $this->Acl->hasAccess('read', $this->Wannabe->user, '/'.$this->Wannabe->event->reference.'/cfad/CfadApplication'));
        $this->set('cfadMembership', $this->User->getCfadForEvent($this->Wannabe->user['User']['id'], $this->Wannabe->event->id));
        $this->set('smsbudget', $this->SmsBudget->getBudgetForUser($this->Wannabe->user['User']['id']));
        $this->set('birthdays', $this->User->getTodaysBirthdays());
        // Checks if user is in a crew.
        if(isset($this->Wannabe->user['Crew'][0]['id'])) {
            $activeApplicationsList = array();
            $allActiveCrews = $this->Wannabe->user['Crew'];
            foreach($allActiveCrews as $activeCrews){
                $activeApplicationsList[] = $this->ApplicationDocument->countActive($activeCrews['id']);
            }
            $this->set('activeApplicationsList', $activeApplicationsList);
            $this->set('availableIrcChannels', $this->IrcChannelKey->getAvailableChannels($this->Wannabe->user));
            $this->set('activeUsers', $this->User->getLatestActivity());
        }
	}
}
?>
