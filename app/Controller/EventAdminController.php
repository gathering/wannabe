<?

class EventAdminController extends AppController
{
    public $uses = array('Event','KanduMembershipSettings');
    private $urlmodes = array(
        'path' => 'Mappenavn',
        'domain' => 'Domene'
    );

    public function index()
    {
        // Get the current event
        $this->event = $this->Event->findById(WB::$event->id);

        // Handle form
        if($this->request->is('post')) {
            if($this->Event->save($this->request->data)) {

                //Store the kandu membership form
                $kandusettings = $this->request->data['KanduMembershipSetting'];


                $kandu_expire_date = $kandusettings['expires']['year']."-".$kandusettings['expires']['month']."-".$kandusettings['expires']['day']." ".$kandusettings['expires']['hour'].":".$kandusettings['expires']['min'];

                $this->KanduMembershipSettings->query("UPDATE  `wannabe`.`wb4_kandu_membership_settings` SET
                                                        `enabled` =  '".$kandusettings['enabled']."',
                                                        `expires` =  '".$kandu_expire_date."',
                                                        `year` =  '".$kandusettings['year']."'
                                                        WHERE `event_id` = ".WB::$event->id);

                Cache::delete('events');
                //$this->Flash->success(__("The event was saved."));
                $this->Flash->success(__("The event was saved."));
                $this->redirectEvent("/EventAdmin/");
            }
        }

        //Kandu Membership

        $kandusettings = $this->KanduMembershipSettings->query('SELECT * FROM wb4_kandu_membership_settings WHERE event_id ='.WB::$event->id)[0]['wb4_kandu_membership_settings'];

        #If it the settings don't exist in the database, lets create it
        if($kandusettings == null){
            $this->KanduMembershipSettings->query("INSERT INTO  `wannabe`.`wb4_kandu_membership_settings` (`event_id` ,`enabled` ,`year` ,`expires`)
                                                    VALUES ('".WB::$event->id."',  '0',  '".date("Y")."',  '".date("Y")."-01-01 23:59:00')");

            //HiHi
            $this->redirectEvent("/EventAdmin/");
        }


        // Variables for the view
        $this->set('title_for_layout', __("Edit the event %s", $this->Wannabe->event->name));
        $this->set('desc_for_layout', "");
        $this->set('urlmodes', $this->urlmodes);
        $this->set('data', $this->event);
        $this->set('kandu',$kandusettings);
        $this->set('savebutton', __("Save event"));
    }
}
?>
