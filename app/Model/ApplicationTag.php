<?php
/**
 * ApplicationTag Model
 *
 */
class ApplicationTag extends AppModel {
/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'application_document_id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ApplicationDocument' => array(
			'className' => 'ApplicationDocument',
			'foreignKey' => 'application_document_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	public function setTags($document_id, $tagstring)
	{
		$user_id = WB::$user['User']['id'];
		$document_id = (int)$document_id;

		$this->query("DELETE FROM {$this->prefix}{$this->table} WHERE user_id = $user_id AND document_id = $document_id");

		$tags = explode(',', $tagstring);
		foreach ($tags as $tag) {
			$tag = trim($tag);
			if (empty($tag)) continue;
			$tag = addslashes($tag);
			$this->query("REPLACE INTO {$this->prefix}{$this->table} SET user_id = $user_id, document_id = $document_id, tag = '$tag'");
		}

		return true;
	}

	public function getTags($document_id)
	{
		$user_id = WB::$user['User']['id'];
		$document_id = (int)$document_id;

		$tags = array();
		$data = $this->query("SELECT tag FROM {$this->prefix}{$this->table} AS CrewapplicationTags WHERE CrewapplicationTags.user_id=$user_id AND CrewapplicationTags.document_id=$document_id");
		foreach ($data as $entry) {
			$tags[] = $entry['ApplicationTags']['tag'];
		}

		return implode(', ', $tags);
	}

	public function getUsedTags()
	{
		$user_id = WB::$user['User']['id'];
		return $this->query("SELECT DISTINCT tag FROM {$this->prefix}{$this->table} AS CrewapplicationTags WHERE CrewapplicationTags.user_id=$user_id");
	}
}
