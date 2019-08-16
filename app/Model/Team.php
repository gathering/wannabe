<?php
/**
 * Team Model
 *
 */
class Team extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

	public function lockTeam($id) {
		if(!$id)
			return false;
		$team['Team']['id'] = $id;
		$team['Team']['locked'] = 1;
		return $this->save($team);
	}

	public function unlockTeam($id) {
		if(!$id)
			return false;
		$team['Team']['id'] = $id;
		$team['Team']['locked'] = 0;
		return $this->save($team);
	}

	public function getAllTeams($selectTag=false) {
		$type = 'all';

		if($selectTag) {
			$type = 'list';
		}
		$teams = Cache::read(WB::$event->reference.'-teams-'.$type);
		if($teams === false) {
			$teams = $this->find($type, array(
				'order' => 'name',
				'recursive' => -1
			));
			Cache::write(WB::$event->reference.'-teams-'.$type, $teams);
		}
		return($teams);
	}
}
