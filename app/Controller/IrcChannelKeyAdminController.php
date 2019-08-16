<?

class IrcChannelKeyAdminController extends AppController {

    public $uses = array('IrcChannelKey', 'IrcChannelKeyCrew', 'Crew');

    public function index() {
        $this->set('title_for_layout', __("IRC channel admin"));
        $this->set('desc_for_layout', __("Select channel to administrate, or create new"));
        $this->set('channelList', $this->IrcChannelKey->find('all', array(
            'conditions' => array(
                'IrcChannelKey.event_id' => $this->Wannabe->event->id
                ),
                'order' => 'channelname ASC'
            )));
    }

    public function create() {
        if($this->request->is('post')) {
            $this->request->data['IrcChannelKey']['event_id'] = $this->Wannabe->event->id;

            if($this->IrcChannelKey->save($this->request->data)) {
                $this->Flash->success(__("Channel was saved"));
                $this->redirectEvent('/IrcChannelKeyAdmin');
            }
        }

        $this->set('title_for_layout', __("Create new channel"));
        $this->set('crews', $this->Crew->getAllCrews(true, 0, true));
    }

    public function delete($id=0) {
        if($this->request->is('post')) {
            if($this->IrcChannelKey->delete($id)) {
                $this->Flash->success(__("Channel was deleted"));
                $this->redirectEvent('/IrcChannelKeyAdmin');
            }
        }

        if(!$id) {
            $this->Flash->warning(__("Select channel to delete"));
            $this->redirectEvent('/IrcChannelKeyAdmin');
        }

        $this->set('title_for_layout', __("Delete channel"));
        $this->set('channel', $this->IrcChannelKey->find('first', array(
            'conditions' => array(
                'IrcChannelKey.id' => $id
                )
            )));
    }

    public function deletecrew($channel_id, $crew_id) {

        if($this->IrcChannelKeyCrew->deleteCrew($channel_id, $crew_id)) {
            $this->Flash->success(__("Crew was successfully deleted"));
            $this->redirectEvent("/IrcChannelKeyAdmin/edit/$channel_id");
        }

        $this->Flash->warning(__("Crew was not deleted"));
        $this->redirectEvent("/IrcChannelKeyAdmin/edit/$channel_id");
    }

    public function edit($id=0) {
        if($this->request->is('post')) {
            $this->request->data['IrcChannelKey']['event_id'] = $this->Wannabe->event->id;

            if($this->request->data['IrcChannelKey']['id'] != 0) {
                if(!$this->IrcChannelKey->save($this->request->data)) {
                    $this->Flash->warning(__("Something unexpected happened"));
                    $this->redirectEvent('/IrcChannelKeyAdmin');

                }
                else {
                    $this->Flash->success(__("Channel was successfully saved"));
                }

                if($this->request->data['IrcChannelKeyCrew']['crew_id'] != 0) {

                    if($this->IrcChannelKeyCrew->save($this->request->data)) {
                        $this->Flash->success(__("Changes to channel was successfully saved"));
                        $this->redirectEvent("/IrcChannelKeyAdmin/edit/{$id}");
                    }
                    else {
                        $this->Flash->warning(__("This crew is already added or something went mysteriously wrong"));
                        $this->redirectEvent("/IrcChannelKeyAdmin/edit/{$id}");
                    }
                }
            }
        }

        if(!$id) {
            $this->Flash->warning(__("Select channel to edit"));
            $this->redirectEvent("/IrcChannelKeyAdmin");
        }

        $this->set('title_for_layout', __("Edit channel"));
        $this->set('channel', $this->IrcChannelKey->find('first', array(
            'conditions' => array(
                'IrcChannelKey.id' => $id
                )
            )));
        $this->set('enabled_crews', $this->IrcChannelKeyCrew->find('all', array(
            'conditions' => array(
                'IrcChannelKeyCrew.irc_channel_key_id' => $id
                )
            )));

        $this->set('crews', $this->Crew->getAllCrews(true, 0, true));
    }
}
?>
