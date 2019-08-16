<?php
/**
 * CfadApplicationDocument Model
 *
 */
class CfadApplicationDocument extends CfadAppModel {
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
		'CfadApplicationField' => array(
			'className' => 'CfadApplicationField',
			'foreignKey' => 'application_document_id',
			'dependent' => true,
			'order' => 'CfadApplicationField.id ASC'
		),
		'CfadApplicationChoice' => array(
			'className' => 'CfadApplicationChoice',
			'foreignKey' => 'application_document_id',
			'dependent' => true,
			'order' => 'CfadApplicationChoice.priority ASC'
		)
	);

	public function findDocument($user_id) {
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

	public function accept($document, $choice, $day) {
		if ($document['CfadApplicationDocument']['id'] != $choice['CfadApplicationChoice']['application_document_id'])
			return false;

		$document_id = $document['CfadApplicationDocument']['id'];
		$choice_id = $choice['CfadApplicationChoice']['id'];

		$this->query('update wb4_cfad_application_choices set handled=now() '
			. 'where application_document_id='.$document_id.' and !handled');

		$this->query('update wb4_cfad_application_choices set accepted=1, denied=0, handled=now() '
			. 'where application_document_id='.$document_id.' and id='.$choice_id);

		$this->query('update wb4_cfad_application_choices set accepted=0, denied=1 '
			. 'where application_document_id='.$document_id.' and id<>'.$choice_id);

		$this->query('update wb4_cfad_application_documents set handled=now() where id='.$document_id);

		// add the user to the correct crew.
		$this->query('insert into wb4_cfad_users set user_id='.$document['User']['id'].', crew_id='.$choice['CfadApplicationChoice']['crew_id'].', assigned=NOW(), date="'.$day.'"');

		// send out an email here.
		App::import('Model', 'Crew');
		$crewModel = new Crew();
		$chief = $this->findChief($choice['CfadApplicationChoice']['crew_id']);
		if(!$chief['Chief']['User']['realname']) {
			$chief = false;
		} else {
			$chief = $chief['Chief']['User']['realname']." aka ".$chief['Chief']['User']['nickname'];
		}
		$acceptEmail = new CakeEmail('default');
		$acceptEmail->viewVars(array(
			'crews' => $crewModel->getAllCrews(true, 0, true),
            'crew_id' => $choice['CfadApplicationChoice']['crew_id'],
            'chief' => $chief
		));
		$lang = $document['User']['language'];
		if(!$lang) {
			$lang = 'eng';
		}
        if($lang = 'nob') {
            $subject = "Velkommen som Crew for a day!";
        } else {
            $subject = "Velkommen som Crew for a day!";
        }
		$acceptEmail->template('cfad-accepted-'.$lang, 'plain')->emailFormat('text')->subject($subject)->to($document['User']['email'])->send();

		return true;
	}

	public function deny($document, $choice, $denialmessage = null) {
		if ($document['CfadApplicationDocument']['id'] != $choice['CfadApplicationChoice']['application_document_id'])
			return false;

		$document_id = $document['CfadApplicationDocument']['id'];
		$choice_id = $choice['CfadApplicationChoice']['id'];

		$this->query('update wb4_cfad_application_choices set handled=now(), accepted=0, denied=1 '
			. 'where application_document_id='.$document_id.' and id='.$choice_id);

		App::import('Model', 'Cfad.CfadCrew');
		$cfadCrewModel = new CfadCrew();
		$opencrews = $cfadCrewModel->getCrews(true);
		$ishandled = 0;
		foreach ($opencrews as $current_id => $current) {
			$match = false;
			foreach ($document['CfadApplicationChoice'] as & $document_choice) {
				if($document_choice['id'] == $choice['CfadApplicationChoice']['id']) {
					$document_choice['handled'] = date('Y-m-d H:i:s');
					$document_choice['denied'] = 1;
				}
				if($document_choice['crew_id'] == $current_id) {
					$match = true;
					if(!$document_choice['denied']) $ishandled++;
				}
			}
			if(!$match) $ishandled++;
		}

		if ($ishandled == 0) {
			$this->query('update wb4_cfad_application_documents set handled=now() where id='.$document_id);
		}

		App::import('Model', 'Crew');
		$crewModel = new Crew();
		$deniedEmail = new CakeEmail('default');
		$deniedEmail->viewVars(array(
			'crews' => $crewModel->getAllCrews(true, 0, true),
			'document' => $document,
			'ishandled' => $ishandled,
            'denialmessage' => $denialmessage

		));
		$lang = $document['User']['language'];
		if(!$lang) {
			$lang = 'eng';
		}
        if($lang = 'nob') {
            $subject = "Oppdatering om din søknad til Crew for a day";
        } else {
            $subject = "Oppdatering om din søknad til Crew for a day";
        }
		$deniedEmail->template('cfad-denied-'.$lang, 'plain')->emailFormat('text')->subject($subject)->to($document['User']['email'])->send();

		return true;
	}

	private function findChief($crew_id) {
		App::import('Model', 'Crew');
		$crewModel = new Crew();
		$crew = $crewModel->find('first', array(
			'conditions' => array(
				'Crew.id' => $crew_id
			)
		));
		$result = array();
		$chief = $this->query("
            SELECT
                User.*,
                Phone.number
            FROM
                wb4_users User,
                wb4_userphones Phone,
                wb4_crews_users uc,
                wb4_crews Crew
            WHERE
                Phone.user_id=User.id
                AND uc.user_id=User.id
                AND Crew.id=uc.crew_id
                AND Crew.id=".$crew_id."
                AND uc.leader = 3
            ORDER BY
                Phone.phonetype_id ASC
            LIMIT
                1
                ") ;
        if(isset($chief[0])) {
            $result['Chief'] = $chief[0];
            return $result;
        } else {
            return false;
        }
	}

	public function countActive() {
		$result = $this->query("
			SELECT
				count(`CfadApplicationDocument`.`user_id`) as `count`
			FROM
				`wb4_cfad_application_documents` `CfadApplicationDocument`,
				`wb4_cfad_application_choices` `CfadApplicationChoice`
			WHERE
				`CfadApplicationChoice`.`application_document_id` = `CfadApplicationDocument`.`id`
				AND `CfadApplicationChoice`.`handled` = '0000-00-00 00:00:00'
				AND `CfadApplicationDocument`.`draft` = 0"
		);
		if($result) {
			return $result[0][0]['count'];
		}
		return 0;
	}

}
