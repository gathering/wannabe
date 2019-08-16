<?php

class KeycardCard extends AppModel {

    public $validate = array(
        'card_number' => array(
            'rule' => 'notBlank'
        ));

    public function getCards($eventid)
    {
        $cards =  $this->query('SELECT Card.id, Card.card_number FROM wb4_keycard_cards Card WHERE Card.event_id='.$eventid.' AND Card.handed_out=0 ORDER by Card.card_number ASC');
        //sort($cards);
        $cardsForView = array();
        foreach($cards as $card)
            $cardsForView[$card['Card']['card_number']] = $card['Card']['card_number'];
        return $cardsForView;
    }

    public function setHandedOut($number, $eventid)
    {
        return $this->query('UPDATE wb4_keycard_cards SET handed_out=1 WHERE card_number='.$number.' AND event_id='.$eventid);
    }

    public function setHandedIn($id, $eventid)
    {
        return $this->query('UPDATE wb4_keycard_cards SET handed_out=0 WHERE card_number='.$id.' AND event_id='.$eventid);
    }
}
