<?php

class LostItem extends AppModel {

    public $belongsTo = array(
        'LostAndFoundCategory' => array(
            'className' => 'LostAndFoundCategory',
            'foreignKey' => 'category_id'
        ),
        'LostAndFoundStoragePlace' => array(
            'className' => 'LostAndFoundStoragePlace',
            'foreignKey' => 'storage_place_id'
        )
    );

    public function beforeValidate() {

        $this->validate = array(
            'event_id' => array(
                'notempty' => array(
                    'rule' => 'notBlank',
                    'message' => __("Cannot be empty"),
                ),
            ),
            'category_id' => array(
                'notempty' => array(
                    'rule' => 'notBlank',
                    'message' => __("Cannot be empty"),
                )
            ),
            'description' => array(
                'notempty' => array(
                    'rule' => 'notBlank',
                    'message' => __("Cannot be empty"),
                )
            ),
            'lost_by' => array(
                'notempty' => array(
                    'rule' => 'notBlank',
                    'message' => __("Cannot be empty"),
                )
            ),
            'lost_registered_logged_in_user' => array(
                'notempty' => array(
                    'rule' => 'notBlank',
                    'message' => __("Cannot be empty"),
                ),
                'valid_user_id' => array(
                    'rule' => array('loggedInValidUserId'),
                    'message' => __("Must be a valid user id or"),
                ),
                'has_access_to_event' => array(
                    'rule' => array('loggedInHasAccessToThisEvent'),
                    'message' => __("You do not have access to this event")
                ),
            ),
            'lost_registered_by' => array(
                'notempty' => array(
                    'rule' => 'notBlank',
                    'message' => __("Cannot be empty"),
                ),
                'valid_user_id' => array(
                    'rule' => array('registeredByValidUserId'),
                    'message' => __("Must be a valid user id or"),
                ),
                'has_access_to_event' => array(
                    'rule' => array('registeredByHasAccessToThisEvent'),
                    'message' => __("You do not have access to this event")
                ),
            ),
            'found_by' => array(
                'notempty' => array(
                    'rule' => 'notBlank',
                    'message' => __("Cannot be empty"),
                )
            ),
            'found_logged_in_user' => array(
                'notempty' => array(
                    'rule' => 'notBlank',
                    'message' => __("Cannot be empty"),
                ),
                'valid_user_id' => array(
                    'rule' => array('foundLoggedInValidUserId'),
                    'message' => __("Must be a valid user id or"),
                ),
                'has_access_to_event' => array(
                    'rule' => array('foundLoggedInHasAccessToThisEvent'),
                    'message' => __("You do not have access to this event")
                ),
            ),
            'found_registered_by' => array(
                'notempty' => array(
                    'rule' => 'notBlank',
                    'message' => __("Cannot be empty"),
                ),
                'valid_user_id' => array(
                    'rule' => array('foundRegisteredBy'),
                    'message' => __("Must be a valid user id or"),
                ),
                'has_access_to_event' => array(
                    'rule' => array('foundRegisteredByHasAccessToThisEvent'),
                    'message' => __("You do not have access to this event")
                ),
            ),
            'resolved_logged_in_user' => array(
                'notempty' => array(
                    'rule' => 'notBlank',
                    'message' => __("Cannot be empty"),
                ),
                'valid_user_id' => array(
                    'rule' => array('resolvedLoggedInValidUserId'),
                    'message' => __("Must be a valid user id or"),
                ),
                'has_access_to_event' => array(
                    'rule' => array('resolvedLoggedInHasAccessToThisEvent'),
                    'message' => __("You do not have access to this event")
                ),
            ),
            'resolved_registered_by' => array(
                'notempty' => array(
                    'rule' => 'notBlank',
                    'message' => __("Cannot be empty"),
                ),
                'valid_user_id' => array(
                    'rule' => array('resolvedRegisteredValidUserId'),
                    'message' => __("Must be a valid user id or"),
                ),
                'has_access_to_event' => array(
                    'rule' => array('resolvedRegisteredHasAccessToThisEvent'),
                    'message' => __("You do not have access to this event")
                ),
            ),
            'resolved_delivered_by' => array(
                'notempty' => array(
                    'rule' => 'notBlank',
                    'message' => __("Cannot be empty"),
                ),
                'valid_user_id' => array(
                    'rule' => array('resolvedDeliveredByValidUserId'),
                    'message' => __("Must be a valid user id or"),
                ),
                'has_access_to_event' => array(
                    'rule' => array('resolvedDeliveredHasAccessToThisEvent'),
                    'message' => __("You do not have access to this event")
                ),
            ),
            'resolved_description' => array(
                'notempty' => array(
                    'rule' => 'notBlank',
                    'message' => __("Cannot be empty"),
                )
            ),
            'storage_place_id' => array(
                'notempty' => array(
                    'rule' => 'notBlank',
                    'message' => __("Cannot be empty"),
                )
            )
        );
    }

    public function loggedInValidUserId($check) {
        return $this->validUserId($check, "lost_registered_logged_in_user");
    }

    public function registeredByValidUserId($check) {
        return $this->validUserId($check, "lost_registered_by");
    }

    public function foundLoggedInValidUserId($check) {
        return $this->validUserId($check, "found_logged_in_user");
    }

    public function foundRegisteredBy($check) {
        return $this->validUserId($check, "found_registered_by");
    }

    public function resolvedLoggedInValidUserId($check) {
        return $this->validUserId($check, "resolved_logged_in_user");
    }

    public function resolvedRegisteredValidUserId($check) {
        return $this->validUserId($check, "resolved_registered_by");
    }

    public function resolvedDeliveredByValidUserId($check) {
        return $this->validUserId($check, "resolved_delivered_by");
    }


    public function validUserId($check, $index) {

        App::import('Model', 'User');
        $userModel = new User();

        $user = $userModel->find('first', array(
            'conditions' => array(
                'User.id' => $check[$index]
            )
        ));

        if(!$user) return False;
        return True;
    }

    public function loggedInHasAccessToThisEvent($check) {
        return $this->hasAccessToThisEvent($check, "lost_registered_logged_in_user");
    }

    public function registeredByHasAccessToThisEvent($check) {
        return $this->hasAccessToThisEvent($check, "lost_registered_by");
    }

    public function foundLoggedInHasAccessToThisEvent($check) {
        return $this->hasAccessToThisEvent($check, "found_logged_in_user");
    }

    public function foundRegisteredByHasAccessToThisEvent($check) {
        return $this->hasAccessToThisEvent($check, "found_registered_by");
    }

    public function resolvedLoggedInHasAccessToThisEvent($check) {
        return $this->hasAccessToThisEvent($check, "resolved_logged_in_user");
    }

    public function resolvedRegisteredHasAccessToThisEvent($check) {
        return $this->hasAccessToThisEvent($check, "resolved_registered_by");
    }

    public function resolvedDeliveredHasAccessToThisEvent($check) {
        return $this->hasAccessToThisEvent($check, "resolved_delivered_by");
    }

    public function hasAccessToThisEvent($check, $index) {
        App::import('Model', 'User');
        $userModel = new User();

        $user = $userModel->find('first', array(
            'conditions' => array(
                'User.id' => $check[$index]
            )
        ));

        if(!$user) return False;

        if($userModel->isCrewForEvent($user, WB::$event->id)) return True;
        return False;
    }
}
?>
