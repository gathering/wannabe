<?php

    class LostAndFound extends AppModel {


        public function beforeValidate() {

            $this->validate = array(
                'event_id' => array(
                    'notempty' => array(
                        'rule' => 'notBlank',
                        'message' => __("Cannot be empty"),
                    ),
                ),
                'name' => array(
                    'notempty' => array(
                        'rule' => 'notBlank',
                        'message' => __("Cannot be empty"),
                    ),
                ),
                'type' => array(
                    'notempty' => array(
                        'rule' => 'notBlank',
                        'message' => __("Cannot be empty"),
                    ),
                ),
                'description' => array(
                    'notempty' => array(
                        'rule' => 'notBlank',
                        'message' => __("Cannot be empty"),
                    ),
                ),
                'found_where' => array(
                    'notempty' => array(
                        'rule' => 'notBlank',
                        'message' => __("Cannot be empty"),
                    ),
                ),
                'found_when' => array(
                    'notempty' => array(
                        'rule' => 'notBlank',
                        'message' => __("Cannot be empty"),
                    ),
                ),
                'reported_by' => array(
                    'notempty' => array(
                        'rule' => 'notBlank',
                        'message' => __("Cannot be empty"),
                    ),
                ),
                'found_where' => array(
                    'notempty' => array(
                        'rule' => 'notBlank',
                        'message' => __("Cannot be empty"),
                    ),
                ),
                'resolved_by' => array(
                    'valid_user_id' => array(
                        'rule' => array('validUserId'),
                        'message' => __("Must be a valid user id or"),
                     ),
                    'has_access_to_event' => array(
                        'rule' => array('hasAccessToThisEvent'),
                        'message' => __("You do not have access to this event")
                    ),
                ),
            );
        }

        public function validUserId($check) {

            App::import('Model', 'User');
            $userModel = new User();

            $user = $userModel->find('first', array(
                'conditions' => array(
                    'User.id' => $check['resolved_by']
                )
            ));

            if(!$user) return False;
            return True;
        }

        public function hasAccessToThisEvent($check) {
            App::import('Model', 'User');
            $userModel = new User();

            $user = $userModel->find('first', array(
                'conditions' => array(
                    'User.id' => $check['resolved_by']
                )
            ));

            if(!$user) return False;

            if($userModel->isCrewForEvent($user, WB::$event->id)) return True;
            return False;
        }

        public function search($query) {

           $db = $this->getDataSource();

           $where = 'AND (LostAndFound.name LIKE \'%'.addslashes($query).'%\'
                    OR LostAndFound.description LIKE \'%'.addslashes($query).'%\'
                    OR LostAndFound.found_where LIKE \'%'.addslashes($query).'%\'
                    OR LostAndFound.reported_by LIKE \'%'.addslashes($query).'%\'
                    OR LostAndFound.reported_by_contact LIKE \'%'.addslashes($query).'%\'
                    OR LostAndFound.delivered_to LIKE \'%'.addslashes($query).'%\'
                    OR LostAndFound.delivered_to_contact LIKE \'%'.addslashes($query).'%\'
                    )';

           return($this->query("SELECT LostAndFound.*
                                FROM {$db->fullTableName('lost_and_founds')} LostAndFound
                                WHERE 1 ".$where."AND LostAndFound.event_id=".WB::$event->id.' ORDER BY LostAndFound.name ASC'));
        }
    }

?>
