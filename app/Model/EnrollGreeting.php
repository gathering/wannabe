<?php
/**
 * EnrollGreeting Model
 *
 */
class EnrollGreeting extends AppModel {

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Crew' => array(
			'className' => 'Crew',
			'foreignKey' => 'crew_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
       public function findGreeting($crew_id) {
                $crew = $this->Crew->find('first', array('conditions' =>array('id'=>$crew_id)));
                $result = array();
$chief = $this->query("SELECT User.*, Phone.number from wb4_users User, wb4_userphones Phone,
wb4_crews_users uc, wb4_crews Crew WHERE Phone.user_id=User.id AND uc.user_id=User.id
AND Crew.id=uc.crew_id AND Crew.id=".$crew_id." AND uc.leader = 3 order by Phone.phonetype_id ASC limit 1") ;
$chiefgreet = $this->query("SELECT `EnrollGreeting`.`id`, `EnrollGreeting`.`crew_id`,
`EnrollGreeting`.`message` FROM `wb4_enroll_greetings` AS `EnrollGreeting` WHERE `EnrollGreeting`.`crew_id` =
 ".$crew_id." LIMIT 1");
                if(!empty($chiefgreet)):
                        $result['Chief'] = array_merge($chief[0], $chiefgreet[0]);
                else:
                        $result['Chief'] = $chief[0];
                endif;
                if(!$crew['Crew']['crew_id']) $crew['Crew']['crew_id'] = $crew['Crew']['id'];
                $organizer = $this->query("SELECT User.*, Phone.number from wb4_users User,
wb4_userphones Phone, wb4_crews_users uc, wb4_crews Crew WHERE Phone.user_id=User.id AND uc.user_id=User.id AND Crew.id=uc.crew_id AND Crew.id=".$crew['Crew']['crew_id']." AND
uc.leader = 4 order by Phone.phonetype_id ASC limit 1");
$orggreet = $this->query("SELECT `EnrollGreeting`.`id`, `EnrollGreeting`.`crew_id`,
`EnrollGreeting`.`message` FROM `wb4_enroll_greetings` AS `EnrollGreeting` WHERE `EnrollGreeting`.`crew_id` =
".$crew['Crew']['crew_id']." LIMIT 1");
                if(!empty($orggreet)):
                        $result['Organizer'] = array_merge($organizer[0], $orggreet[0]);
                else:
                        $result['Organizer'] = $organizer[0];
                endif;
                debug($result);
                return $result;
        }

}
