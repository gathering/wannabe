<?

class WardrobeCardController extends AppController {

    public $uses = array('WardrobeCard', 'WardrobeCardBorrower');

    public function index() {
        $this->set('title_for_layout', __("Pawn shop"));
        $this->set('desc_for_layout', __("Hand out or hand in items"));
        $this->set('cards_not_in_use', $this->WardrobeCard->getCardsNotInUse());
        $this->set('cards_in_use', $this->WardrobeCard->getCardsInUse());
        $this->set('cards_overview', $this->WardrobeCard->getWardrobeOverview());
    }

    public function handout($id) {

        $this->set('usesRFID', 1);

        if($this->request->is('post')) {
            $this->request->data['WardrobeCardBorrower']['wardrobe_card_id'] = $id;

            $validData = true;
            $usesRFID = isset($this->request->data['UsesRFID']) and $this->request->data['UsesRFID'];

            if($usesRFID) {
                $this->set('usesRFID', 1);
                $rfidTrimmed = trim($this->request->data['WardrobeCardBorrower']['RFID']);
                if(!empty($rfidTrimmed)) {
                    $this->request->data['WardrobeCardBorrower']['name'] = $this->request->data['WardrobeCardBorrower']['RFID'];
                    $this->request->data['WardrobeCardBorrower']['seat'] = "#placeholder#";
                    $this->request->data['WardrobeCardBorrower']['row'] = "#placeholder#";
                    $this->request->data['WardrobeCardBorrower']['phone'] = "#placeholder#";
                }
                else {
                    $this->request->data['WardrobeCardBorrower']['RFID'] = "";
                    $this->WardrobeCardBorrower->validationErrors['rfid'] = array(__("Cannot be empty"));
                }
            }
            else {
                $this->set('usesRFID', 0);

                $nameTrimmed = trim($this->request->data['WardrobeCardBorrower']['name']);
                $phoneTrimmed = trim($this->request->data['WardrobeCardBorrower']['phone']);
                $seatTrimmed = trim($this->request->data['WardrobeCardBorrower']['seat']);
                $rowTrimmed = trim($this->request->data['WardrobeCardBorrower']['row']);

                if(empty($nameTrimmed)) {
                    $this->WardrobeCardBorrower->validationErrors['name'] = array(__("Cannot be empty"));
                    $validData = false;
                }
                if(empty($phoneTrimmed)) {
                    $this->WardrobeCardBorrower->validationErrors['phone'] = array(__("Cannot be empty"));
                    $validData = false;
                }
                if(empty($rowTrimmed)) {
                    $this->WardrobeCardBorrower->validationErrors['row'] = array(__("Cannot be empty"));
                    $validData = false;
                }
                if(empty($seatTrimmed)) {
                    $this->WardrobeCardBorrower->validationErrors['seat'] = array(__("Cannot be empty"));
                    $validData = false;
                }
            }

            if($validData) {
                if($this->WardrobeCardBorrower->save($this->request->data)) {
                    $this->WardrobeCard->setInUse($id, true);
                    $this->Flash->success(__("Item was handed out"));
                    $this->redirectEvent('/WardrobeCard');
                }
            }
        }

        if(!$id) {
            $this->Flash->error(__("Select item to hand out"));
            $this->redirectEvent('/WardrobeCard');
        }

        $card = $this->WardrobeCard->getFirstCard($id);

        $this->set('title_for_layout', __("Hand out item"));
        $this->set('card_id', $card['WardrobeCard']['card']);
        $this->set('wardrobe', $card['WardrobeCard']['wardrobe']);
    }

    public function handin($id) {

        if($this->request->is('post')) {
            $this->WardrobeCard->deleteBorrower($id);
            $this->WardrobeCard->setInUse($id, false);
            $this->Flash->success(__("Item was handed in"));
            $this->redirectEvent('/WardrobeCard');
        }

        if(!$id) {
            $this->Flash->error(__("Select item to hand out"));
            $this->redirectEvent('/WardrobeCard');
        }

        $card = $this->WardrobeCard->getFirstCard($id);

        $this->set('title_for_layout', __("Hand in item"));
        $this->set('card_id', $card['WardrobeCard']['card']);
        $this->set('wardrobe', $card['WardrobeCard']['wardrobe']);
        $this->set('borrower', $this->WardrobeCardBorrower->find('first', array(
            'conditions' => array(
                'WardrobeCardBorrower.wardrobe_card_id' => $id
            )
        )));
    }
}
