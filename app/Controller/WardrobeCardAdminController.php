<?

class WardrobeCardAdminController extends AppController {

    public $uses = array('WardrobeCard');

    public function index() {
        $this->set('title_for_layout', __("Wardrobe cards admin"));
        $this->set('desc_for_layout', __("Select card to administrate, or create new"));
        $this->set('cards', $this->WardrobeCard->find('all', array(
            'conditions' => array(
                'WardrobeCard.event_id' => $this->Wannabe->event->id
            ),
            'order' => 'wardrobe, card ASC'
        )));
    }


    public function create() {

        if($this->request->is('post')) {
            $this->request->data['WardrobeCard']['event_id'] = $this->Wannabe->event->id;

            if($this->WardrobeCard->save($this->request->data)) {
                $this->Flash->success(__("Card was created"));
                $this->redirectEvent('/WardrobeCardAdmin');
            }
        }

        $this->set('title_for_layout', __("Register new card"));
    }

    public function delete($id=0) {
        if($this->request->is('post')) {
            if($this->WardrobeCard->delete($id)) {
                $this->Flash->success(__("Card was deleted"));
                $this->redirectEvent('/WardrobeCardAdmin');
            }
        }

        if(!$id) {
            $this->Flash->warning(__("Select card to delete"));
            $this->redirectEvent('/WardrobeCardAdmin');
        }

        $this->set('title_for_layout', __("Delete card"));
        $this->set('channel', $this->WardrobeCard->getFirstCard($id));
    }

    public function edit($id=0) {
        if($this->request->is('post')) {
            $this->request->data['WardrobeCard']['event_id'] = $this->Wannabe->event->id;

            if($this->request->data['WardrobeCard']['id'] != 0) {
                if(!$this->WardrobeCard->save($this->request->data)) {
                    $this->Flash->warning(__("Card could not be saved"));
                }
                else {
                    $this->Flash->success(__("Card was successfully saved"));
                    $this->redirectEvent("/WardrobeCardAdmin");
                }
            }
        }

        if(!$id) {
            $this->Flash->warning(__("Select card to edit"));
            $this->redirectEvent("/WardrobeCardAdmin");
        }

        $this->set('title_for_layout', __("Edit card"));
        $this->set('card', $this->WardrobeCard->getFirstCard($id));
    }
}
