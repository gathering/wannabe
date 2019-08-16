<?php
class CfadCrew extends CfadAppModel {
	public $belongsTo = array(
		'Crew' => array(
			'className' => 'Crew',
			'foreignKey' => 'crew_id',
			'dependent' => false,
		)
	);
	public function getCrews($selectTag=true, $crew_id=0) {
		$type = 'all';

		if($selectTag) {
			$type = 'list';
		}

		$crews = $this->find($type, array(
			'conditions' => array(
				'CfadCrew.event_id' => WB::$event->id
			),
			'fields' => array(
				'CfadCrew.crew_id',
				'Crew.name'
			),
            'order' => 'Crew.name ASC',
            'recursive' => 1
		));

		return($crews);
	}
	/**
	 * Add member.
	 *
	 * @param u_int $crew_id
	 * @param u_int $user_id
	 */
	public function addMember($crew_id, $user_id) {
		$crew_id = (int) $crew_id;
		$user_id = (int) $user_id;
		$this->query("insert into wb4_cfad_users (crew_id, user_id, assigned) values ($crew_id, $user_id, now())");
	}

	/**
	 * Delete member.
	 *
	 * @param u_int $id
	 */
	public function deleteMember($id) {
		$id = (int) $id;
		$this->query("DELETE FROM wb4_cfad_users WHERE id=$id");
	}

	/**
	 * Delete member.
	 *
	 * @param u_int $crew_id
	 * @param u_int $user_id
	 */
    public function updateMember($user_id, $crew_id, $date) {
		$crew_id = (int) $crew_id;
		$user_id = (int) $user_id;
		$this->query("UPDATE wb4_cfad_users SET crew_id=$crew_id, date=$date WHERE crew_id=$crew_id AND user_id=$user_id");
	}
}
