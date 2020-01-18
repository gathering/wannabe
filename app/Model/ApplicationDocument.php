<?php
App::uses('WbLog', 'Lib');
/**
 * ApplicationDocument Model
 *
 */
class ApplicationDocument extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'user_id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ApplicationField' => array(
			'className' => 'ApplicationField',
			'foreignKey' => 'application_document_id',
			'dependent' => true,
			'order' => 'ApplicationField.id ASC'
		),
		'ApplicationChoice' => array(
			'className' => 'ApplicationChoice',
			'foreignKey' => 'application_document_id',
			'dependent' => true,
			'order' => 'ApplicationChoice.priority ASC'
		),
		'ApplicationTag' => array(
			'className' => 'ApplicationTag',
			'foreignKey' => 'application_document_id',
			'dependent' => true
		),
		'ApplicationComment' => array(
			'className' => 'ApplicationComment',
			'foreignKey' => 'application_document_id',
			'dependent' => true,
			'order' => 'ApplicationComment.created DESC'
		)
	);

	public function findDocument($user_id) {
		if($user_id == WB::$user['User']['id']) {
			$this->unbindModel(
				array('hasMany' => array('ApplicationTag'))
			);
		}
		$application = $this->find('first', array(
			'conditions' => array(
				"{$this->name}.event_id" => WB::$event->id,
				"{$this->name}.user_id" => (int)$user_id
			)
        ));
        if(is_array($application) && $application) {
            $return = $this->find('first', array(
                'conditions' => array(
                    "{$this->name}.event_id" => WB::$event->id,
                    "{$this->name}.user_id" => (int)$user_id
                )
            ));
            return $return;
        } else {
            return $application;
        }
	}

	public function findDocumentNotDraft($user_id) {
		return $this->find('first', array(
			'conditions' => array(
				"{$this->name}.event_id" => WB::$event->id,
				"{$this->name}.user_id" => (int)$user_id,
				"{$this->name}.draft" => 0
			)
		));
	}

	public function setTags($document_id, $tagstring) {
		$user_id = WB::$user['User']['id'];
		$document_id = (int)$document_id;

		$this->query("DELETE FROM wb4_application_tags WHERE user_id = $user_id AND application_document_id = $document_id");

		$tags = explode(',', $tagstring);
		foreach ($tags as $tag) {
			$tag = trim($tag);
			if (empty($tag)) continue;
			$tag = addslashes($tag);
			$this->query("REPLACE INTO wb4_application_tags SET user_id = $user_id, application_document_id = $document_id, tag = '$tag'");
		}

		return true;
	}

	public function getTags($document_id) {
		$user_id = WB::$user['User']['id'];
		$document_id = (int)$document_id;

		$tags = array();
		$data = $this->query("SELECT tag FROM wb4_application_tags AS ApplicationTag WHERE ApplicationTag.user_id=$user_id AND ApplicationTag.application_document_id=$document_id");
		foreach ($data as $entry) {
			$tags[] = $entry['ApplicationTag']['tag'];
		}

		return implode(', ', $tags);
	}

	public function getUsedTags() {
		$user_id = WB::$user['User']['id'];
		return $this->query("SELECT DISTINCT tag FROM wb4_application_tags AS ApplicationTag WHERE ApplicationTag.user_id=$user_id");
	}

	public function setPriority($document_id, $priority) {
		$document_id = (int)$document_id;
		$priority = (int)$priority;

		$this->query("UPDATE wb4_application_documents SET priority = '$priority' WHERE id = $document_id");
		return true;
	}

	public function accept($document, $choice, $chief=0, $organizer=0, $acceptmail) {
		if ($document['ApplicationDocument']['id'] != $choice['ApplicationChoice']['application_document_id'])
			return false;

		$document_id = $document['ApplicationDocument']['id'];
		$choice_id = $choice['ApplicationChoice']['id'];

		$this->query('update wb4_application_choices set handled=now() '
			. 'where application_document_id='.$document_id.' and !handled');

		$this->query('update wb4_application_choices set accepted=1, denied=0, waiting=0, disabled=0, handled=now() '
			. 'where application_document_id='.$document_id.' and id='.$choice_id);

		$this->query('update wb4_application_choices set accepted=0, denied=1, waiting=0, disabled=0 '
			. 'where application_document_id='.$document_id.' and id<>'.$choice_id);

		$this->query('update wb4_application_documents set handled=now() where id='.$document_id);

		// add the user to the correct crew.
		$this->query('insert into wb4_crews_users set user_id='.$document['User']['id'].', crew_id='.$choice['ApplicationChoice']['crew_id'].', assigned=NOW()');
        WbLog::log('crew', $choice['ApplicationChoice']['crew_id']. ' Application accepted for userid ' . $document['User']['id']. ' performed by: '.WB::$user['User']['id']);

        // Clear crew cahce
		App::import('Model', 'Crew');
		$crewModel = new Crew();
		$crewModel->clearCrewListCache($choice['ApplicationChoice']['crew_id']);
        $crewModel->clearUserCache($choice['ApplicationChoice']['crew_id']);

		// get chief and organizer

		$leaders = $this->findGreeting($choice['ApplicationChoice']['crew_id']);
		if(!$leaders['Chief']['User']['realname']) {
			$chief = false;
		} else {
			$chief = $leaders['Chief']['User']['realname']." aka ".$leaders['Chief']['User']['nickname'];
		}
		if(!$leaders['Organizer']['User']['realname']) {
			$organizer = false;
		} else {
			$organizer = $leaders['Organizer']['User']['realname']." aka ".$leaders['Organizer']['User']['nickname'];
		}

		// send out an email here.
		$acceptEmail = new CakeEmail('default');
		$acceptEmail->viewVars(array(
			'leaders' => $leaders,
			'chief' => $chief,
			'organizer' => $organizer,
			'crews' => $crewModel->getAllCrews(true),
			'crew_id' => $choice['ApplicationChoice']['crew_id'],
			'enrollmail' => $acceptmail
		));
		$lang = $document['User']['language'];
		if(!$lang) {
			$lang = 'eng';
		}
		$acceptEmail->template('enroll-'.$lang, 'plain')->emailFormat('text')->subject($acceptmail['EnrollMail']['subject'])->to($document['User']['email'])->send();

		return true;
	}
	public function wait($document, $choice, $mail, $message) {
		if ($document['ApplicationDocument']['id'] != $choice['ApplicationChoice']['application_document_id'])
			return false;

		$document_id = $document['ApplicationDocument']['id'];
		$choice_id = $choice['ApplicationChoice']['id'];

		$this->query('update wb4_application_choices set handled=now(), accepted=0, denied=0, waiting=1, disabled=0 '
			. 'where application_document_id='.$document_id.' and id='.$choice_id);

        WbLog::log('crew', $choice['ApplicationChoice']['crew_id']. ' Application set to wait for userid ' . $document['User']['id']. ' performed by: '.WB::$user['User']['id']);
		foreach ($document['ApplicationChoice'] as & $document_choice) {
			if($document_choice['id'] == $choice['ApplicationChoice']['id']) {
				$document_choice['waiting'] = 1;
			}
        }

		App::import('Model', 'Crew');
		$crewModel = new Crew();
		$waitEmail = new CakeEmail('default');
		$waitEmail->viewVars(array(
			'crews' => $crewModel->getAllCrews(true),
			'document' => $document,
			'message' => $message,
			'enrollmail' => $mail
		));
		$lang = $document['User']['language'];
		if(!$lang) {
			$lang = 'eng';
		}
		$waitEmail->template('enroll-'.$lang, 'plain')->emailFormat('text')->subject($mail['EnrollMail']['subject'])->to($document['User']['email'])->send();

		return true;
    }

	public function deny($document, $choice, $deniedmail, $pendingmail, $denialmessage) {
		if ($document['ApplicationDocument']['id'] != $choice['ApplicationChoice']['application_document_id'])
			return false;

		$document_id = $document['ApplicationDocument']['id'];
		$choice_id = $choice['ApplicationChoice']['id'];

		$this->query('update wb4_application_choices set handled=now(), accepted=0, denied=1, waiting=0, disabled=0 '
			. 'where application_document_id='.$document_id.' and id='.$choice_id);

        WbLog::log('crew', $choice['ApplicationChoice']['crew_id']. ' Application denied for userid ' . $document['User']['id']. ' performed by: '.WB::$user['User']['id']);
		App::import('Model', 'Crew');
		$crewModel = new Crew();
		$opencrews = $crewModel->getOpenCrews(true);
		$ishandled = 0;
		foreach ($opencrews as $current_id => $current) {
			$match = false;
			foreach ($document['ApplicationChoice'] as & $document_choice) {
				if($document_choice['id'] == $choice['ApplicationChoice']['id']) {
					$document_choice['handled'] = date('Y-m-d H:i:s');
					$document_choice['denied'] = 1;
				}
				if($document_choice['crew_id'] == $current_id) {
					$match = true;
					if(!$document_choice['denied'] && !$document_choice['disabled']) $ishandled++;
				}
			}
			if(!$match) $ishandled++;
		}

		if ($ishandled == 0) {
			$this->query('update wb4_application_documents set handled=now() where id='.$document_id);
		}

		// send out an email here.
		if($ishandled > 0) {
			$enrollmail = $pendingmail;
		} else {
			$enrollmail = $deniedmail;
		}
		$deniedEmail = new CakeEmail('default');
		$deniedEmail->viewVars(array(
			'crews' => $crewModel->getAllCrews(true),
			'document' => $document,
			'denialmessage' => $denialmessage,
			'enrollmail' => $enrollmail
		));
		$lang = $document['User']['language'];
		if(!$lang) {
			$lang = 'eng';
		}
		$deniedEmail->template('enroll-'.$lang, 'plain')->emailFormat('text')->subject($enrollmail['EnrollMail']['subject'])->to($document['User']['email'])->send();

		return true;
	}

	public function disable($document, $choice) {
		if ($document['ApplicationDocument']['id'] != $choice['ApplicationChoice']['application_document_id'])
			return false;

		$document_id = $document['ApplicationDocument']['id'];
		$choice_id = $choice['ApplicationChoice']['id'];

		// Set choice to disabled
		$this->query('update wb4_application_choices set handled=now(), accepted=0, denied=0, waiting=0, disabled=1 '
			. 'where application_document_id='.$document_id.' and id='.$choice_id);

        WbLog::log('crew', $choice['ApplicationChoice']['crew_id']. ' Application disabled for userid ' . $document['User']['id']. ' performed by: '.WB::$user['User']['id']);
		App::import('Model', 'Crew');
		$crewModel = new Crew();
		$opencrews = $crewModel->getOpenCrews(true);
		$ishandled = 0;
		// Checking if all applications are either denied or disabled
		foreach ($opencrews as $current_id => $current) {
			$match = false;
			foreach ($document['ApplicationChoice'] as & $document_choice) {
				if($document_choice['id'] == $choice['ApplicationChoice']['id']) {
					$document_choice['handled'] = date('Y-m-d H:i:s');
					$document_choice['disabled'] = 1;
				}
				if($document_choice['crew_id'] == $current_id) {
					$match = true;
					if(!$document_choice['denied'] && !$document_choice['disabled']) $ishandled++;
				}
			}
			if(!$match) $ishandled++;
		}
		// Set application document to handled if there are no open choices left
		if ($ishandled == 0) {
			$this->query('update wb4_application_documents set handled=now() where id='.$document_id);
		}
		return true;

	}

	private function findGreeting($crew_id) {
		App::import('Model', 'Crew');
		$crewModel = new Crew();
		$crew = $crewModel->find('first', array(
			'conditions' => array(
				'Crew.id' => $crew_id
			)
		));
		$result = array();
		$chief = $this->query("SELECT User.*, Phone.number from wb4_users User, wb4_userphones Phone,
wb4_crews_users uc, wb4_crews Crew WHERE Phone.user_id=User.id AND uc.user_id=User.id
AND Crew.id=uc.crew_id AND Crew.id=".$crew_id." AND uc.leader IN (3,4) order by uc.leader DESC limit 1") ;
		$chiefgreet = $this->query("SELECT `EnrollGreeting`.`id`, `EnrollGreeting`.`crew_id`,
`EnrollGreeting`.`message` FROM `wb4_enroll_greetings` AS `EnrollGreeting` WHERE `EnrollGreeting`.`crew_id` =
 ".$crew_id." LIMIT 1");
		if(!empty($chiefgreet)) {
			$result['Chief'] = array_merge($chief[0], $chiefgreet[0]);
		} else {
			$result['Chief'] = $chief[0];
		}
		if(!$crew['Crew']['crew_id'])
			$crew['Crew']['crew_id'] = $crew['Crew']['id'];
		$organizer = $this->query("SELECT User.*, Phone.number from wb4_users User,
wb4_userphones Phone, wb4_crews_users uc, wb4_crews Crew WHERE Phone.user_id=User.id AND uc.user_id=User.id AND Crew.id=uc.crew_id AND Crew.id=".$crew['Crew']['crew_id']." AND
uc.leader = 4 order by Phone.phonetype_id ASC limit 1");
		$orggreet = $this->query("SELECT `EnrollGreeting`.`id`, `EnrollGreeting`.`crew_id`,
`EnrollGreeting`.`message` FROM `wb4_enroll_greetings` AS `EnrollGreeting` WHERE `EnrollGreeting`.`crew_id` =
".$crew['Crew']['crew_id']." LIMIT 1");
		if(!empty($orggreet)) {
			$result['Organizer'] = array_merge($organizer[0], $orggreet[0]);
		} else {
			if(count($organizer) > 0) {
				$result['Organizer'] = $organizer[0];
			} else {
				$result['Organizer'] = NULL;
			}
		}
		return $result;
	}

	public function denyAll($crew, $deniedmail, $pendingmail, $denialmessage) {
		$applications = $this->query("select ApplicationDocument.id, ApplicationDocument.user_id,
ApplicationChoice.id, ApplicationChoice.application_document_id from
wb4_application_documents ApplicationDocument,
wb4_application_choices ApplicationChoice where
ApplicationDocument.id=ApplicationChoice.application_document_id and
ApplicationChoice.crew_id=".$crew." and
ApplicationDocument.handled =
'0000-00-00 00:00:00' and ApplicationChoice.denied = 0 and ApplicationChoice.accepted = 0  and
ApplicationDocument.draft = 0
order by
ApplicationDocument.id ASC");

		foreach($applications as $application) {
			$current = $this->findDocument($application['ApplicationDocument']['user_id']);
			//debug($current);$deniedmail, $pendingmail, $denialmessage
			$this->deny($current, $application, $deniedmail, $pendingmail, $denialmessage);
		}

	}
	public function countActive($crew_id) {
		$crew_id = (int)$crew_id;

		$result = $this->query("
			SELECT
				count(`ApplicationDocument`.`user_id`) as `count`
			FROM
				`wb4_application_documents` `ApplicationDocument`,
				`wb4_application_choices` `ApplicationChoice`
			WHERE
				`ApplicationChoice`.`application_document_id` = `ApplicationDocument`.`id`
				AND `ApplicationChoice`.`handled` = '0000-00-00 00:00:00'
				AND `ApplicationDocument`.`draft` = 0
				AND `ApplicationChoice`.`crew_id` = {$crew_id}"
		);
		if($result) {
			return $result[0][0]['count'];
		}
		return 0;
	}
	public function countWaiting($crew_id) {
		$crew_id = (int)$crew_id;

		$result = $this->query("
			SELECT
				count(`ApplicationDocument`.`user_id`) as `count`
			FROM
				`wb4_application_documents` `ApplicationDocument`,
				`wb4_application_choices` `ApplicationChoice`
			WHERE
				`ApplicationChoice`.`application_document_id` = `ApplicationDocument`.`id`
				AND `ApplicationChoice`.`waiting` = '1'
				AND `ApplicationDocument`.`draft` = 0
				AND `ApplicationChoice`.`crew_id` = {$crew_id}"
		);
		if($result) {
			return $result[0][0]['count'];
		}
		return 0;
	}

}
