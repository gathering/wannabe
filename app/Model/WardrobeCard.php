<?php
/**
 * WardrobeCard Model
 *
 */
class WardrobeCard extends AppModel {
    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'card';

    /**
     * Validation rules
     *
     * @var array
     */
    public function beforeValidate() {
        $this->validate = array(
            'event_id' => array(
                'notempty' => array(
                    'rule' => array('notBlank'),
                    'message' => __("Cannot be empty")
                ),
            ),
            'card' => array(
                'notempty' => array(
                    'rule' => array('notBlank'),
                    'message' => __("Cannot be empty")
                ),
                'maxlength' => array(
                    'rule' => array('maxlength', 30),
                    'message' => __("Max length is 30")
                ),
                'unique' => array(
                    'rule' => array('isEventUnique'),
                    'message' => __('A card with that name already exists.')
                )
            ),
            'wardrobe' => array(
                'notempty' => array(
                    'rule' => array('notBlank'),
                    'message' => __("Cannot be empty")
                ),
                'maxlength' => array(
                    'rule' => array('maxlength', 30),
                    'message' => __("Max length is 30")
                ),
            ),
        );
    }

    public function delete($id) {
        if(!$id) return false;

        $this->deleteBorrower($id);

        $db = $this->getDataSource();
        $db->query("DELETE FROM
                        {$db->fullTableName('wardrobe_cards')}
                    WHERE
                        {$db->fullTableName('wardrobe_cards')}.id=".$id);

        return true;
    }

    public function deleteBorrower($id) {
        $card = $this->getFirstCard($id);

        if($card['WardrobeCard']['in_use']) {
            $db = $this->getDataSource();
            $db->query("DELETE FROM
                            {$db->fullTableName('wardrobe_card_borrowers')}
                        WHERE
                            {$db->fullTableName('wardrobe_card_borrowers')}.wardrobe_card_id=".$id);
        }
    }

    public function setInUse($id, $in_use) {
        $this->save(array(
            'id' => $id,
            'in_use' => $in_use ? 1 : 0
        ));
    }

    public function getFirstCard($id) {
        return $this->find('first', array(
            'conditions' => array(
                'WardrobeCard.id' => $id
            )
        ));
    }

    public function getCardsNotInUse() {
        return $this->find('all', array(
            'conditions' => array(
                'WardrobeCard.event_id' => WB::$event->id,
                'WardrobeCard.in_use' => 0
            ),
            'order' => 'wardrobe, card ASC'
        ));
    }

    public function getCardsInUse() {
        return $this->find('all', array(
            'conditions' => array(
                'WardrobeCard.event_id' => WB::$event->id,
                'WardrobeCard.in_use' => 1
            ),
            'order' => 'wardrobe, card ASC'
        ));
    }

    public function getWardrobeOverview() {
        $wardrobes = $this->find('all', array(
	    'conditions' => array(
		'WardrobeCard.event_id' => WB::$event->id
	    ),
            'fields' => 'DISTINCT wardrobe'
            )
        );

        $overview = array();

        foreach($wardrobes as $wardrobe) {
            $overview[$wardrobe['WardrobeCard']['wardrobe']] = $this->find('count', array(
                'conditions' => array(
                    'WardrobeCard.wardrobe' => $wardrobe['WardrobeCard']['wardrobe'],
                    'WardrobeCard.in_use' => 1
                )
            ));
        }

        return $overview;
    }
}

?>
