<?php
class BadgeController extends ApiAppController {
    var $uses = array('Api.ApiApplication', 'Api.ApiKey', 'Badge', 'User');
    public $components = array('RequestHandler');


    public function add() {
        if($this->request->is('post')) {
            $this->request->data['Badge']['event_id'] = $this->Wannabe->event->id;

            if($this->Badge->save($this->request->data)) {
                $this->set(array(
                    "response" => array("status" => "ok"),
                    "_serialize" => array("response")
                ));

                return;
            } else {
                $this->set(array(
                    "response" => array("status" => "failed", "object" => $this->request->data),
                    "_serialize" => array("response")
                ));
                return;
            }
        } else {
            $this->throwError("Not a valid request", '403');
        }
    }


    public function check_access() {

        $card_number = $this->request->query['card_number'];

        if(!isset($card_number)) {
            $this->set(array(
                "status" => 0,
                "meldinger" => "No card number provided",
                "_serialize" => array("status", "meldinger")
            ));
            return;
        }

        $badge = $this->get_badge_by_card_number($card_number);

        // If the badge was found, return 1 OK
        if($badge) {
            $this->set(array(
                    "status" => 1,
                    "_serialize" => array("status")
            ));
            return;
        }

        // If not, return 0 FAIL and message
        $this->set(array(
            "status" => 0,
            "meldinger" => "Card not found",
            "_serialize" => array("status", "meldinger")
        ));
        return;
    }


    // Returns JSON containing user id for provided card number if exists
    public function check_user_id_by_card_number() {

        $card_number = $this->request->query['card_number'];

        if(!isset($card_number)) {
            $this->set(array(
                "meldinger" => "No card number provided",
                "_serialize" => array("status", "meldinger")
            ));
            return;
        }

        $badge = $this->get_badge_by_card_number($card_number);

        if($badge) {
            if(isset($badge["Badge"]["user_id"])) {
              $user = $this->User->findById($badge["Badge"]["user_id"]);
            }

            $this->set(array(
                "status" => 1,
                "user_id" => $badge["Badge"]["user_id"],
                "name" => $user["User"]["realname"],
                "crew" => $user['Crew'][0]['name'],
                "_serialize" => array("status", "user_id", "name", "crew" )
            ));
            return;
        }

        // If not, return 0 FAIL and message
        $this->set(array(
            "status" => 0,
            "meldinger" => "Card not found",
            "_serialize" => array("status", "meldinger")
        ));
        return;
    }


    private function get_badge_by_card_number($card_number) {
        $badge = $this->Badge->find('first', array(
            'conditions' => array(
                'Badge.nfc_id' => $card_number,
                'Badge.event_id' => $this->Wannabe->event->id,
                'Badge.active' => 1
                )
            )
        );

        return $badge;
    }


    public function all_badges() {
        $this->Badge->recursive = -1;
        $badges = $this->Badge->find('all', array(
            'fields' => array('nfc_id', 'active'),
            'conditions' => array(
                'Badge.event_id' => $this->Wannabe->event->id,
                )
            )
        );

        $this->set(array(
                "badges" => $badges,
                "_serialize" => array("badges")
        ));
        return;
    }
}
?>
