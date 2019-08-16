<?php
/**
 * ApplicationTag Model
 *
 */
class ApplicationComment extends AppModel {
/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = "id";

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		"ApplicationDocument" => array(
			"className" => "ApplicationDocument",
			"foreignKey" => "application_document_id",
			"conditions" => "",
			"fields" => "",
			"order" => ""
		),
		"User" => array(
			"className" => "User",
			"foreignKey" => "user_id",
			"conditions" => "",
			"fields" => "",
			"order" => ""
		)
	);

	public function addComment($document_id, $comment) {
		$this->save(array(
			"user_id" => WB::$user["User"]["id"],
			"application_document_id" => (int)$document_id,
			"content" => $comment
		));
		return true;
	}

	public function getComments($document_id) {
		$document_id = (int)$document_id;

		return $this->find("all", array(
			"contain" => array("User"),
			"conditions" => array(
				"{$this->name}.application_document_id" => $document_id
			),
			"order" => array("{$this->name}.created DESC")
        ));
	}

}
