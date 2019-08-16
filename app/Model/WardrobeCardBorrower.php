<?php
/**
 * WardrobeCardBorrower Model
 *
 */
class WardrobeCardBorrower extends AppModel {
    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'card';

    public $belongsTo = array(
        'WardrobeCard'      => array(
            'className'     => 'WardrobeCard',
            'foreignKey'    => 'wardrobe_card_id'
        )
    );


    /**
     * Validation rules
     *
     * @var array
     */
    public function beforeValidate() {
        $this->validate = array(
            /*'name' => array(
                'notempty' => array(
                    'rule' => array('notBlank'),
                    'message' => __("Cannot be empty")
                ),
                'maxlength' => array(
                    'rule' => array('maxlength', 100),
                    'message' => __("Max length is 100")
                ),
            ),
            'seat' => array(
                'notempty' => array(
                    'rule' => array('notBlank'),
                    'message' => __("Cannot be empty")
                ),
                'maxlength' => array(
                    'rule' => array('maxlength', 30),
                    'message' => __("Max length is 30")
                ),
            ),
            'row' => array(
                'notempty' => array(
                    'rule' => array('notBlank'),
                    'message' => __("Cannot be empty")
                ),
                'maxlength' => array(
                    'rule' => array('maxlength', 30),
                    'message' => __("Max length is 30")
                ),
            ),*/
            'deposit' => array(
                'notempty' => array(
                    'rule' => array('notBlank'),
                    'message' => __("Cannot be empty")
                ),
                'maxlength' => array(
                    'rule' => array('maxlength', 100),
                    'message' => __("Max length is 100")
                ),
            ),
/*            'deposit_comment' => array(
                'notempty' => array(
                    'rule' => array('notBlank'),
                    'message' => __("Cannot be empty")
                ),
                'maxlength' => array(
                    'rule' => array('maxlength', 100),
                    'message' => __("Max length is 100")
                ),
            ),*/
            /*'phone' => array(
                'notempty' => array(
                    'rule' => array('notBlank'),
                    'message' => __("Cannot be empty")
                ),
                'maxlength' => array(
                    'rule' => array('maxlength', 100),
                    'message' => __("Max length is 100")
                ),
            ),*/
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
                            {$db->fullTableName('wardrobe_card_borrowers')}.wardrobe_key=".$id);
        }
    }

    public function getFirstCard($id) {
        return $this->find('first', array(
            'conditions' => array(
                'WardrobeCard.id' => $id
            )
        ));
    }
}

?>
