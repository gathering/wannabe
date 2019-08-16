<?php
/**
 * Wikipage Model
 *
 */
class Wikipage extends AppModel {
/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'title';
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';

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
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	public function save($data) {
		$title = addslashes($data['Wikipage']['title']);
		$user_id = (int)$data['Wikipage']['user_id'];
		$comment = addslashes($data['Wikipage']['comment']);
		$content = addslashes($data['Wikipage']['content']);
		$event_id = (int)$data['Wikipage']['event_id'];
		$revision = 1;

		$resultset = $this->find('first', array(
			'conditions' => array(
				'title' => $data['Wikipage']['title']
			),
			'fields' => array(
				'revision'
			),
			'order' => 'Wikipage.revision DESC'
		));
		if ( $resultset != false )
			$revision = $resultset['Wikipage']['revision'] + 1;
		$this->query("INSERT INTO {$this->tablePrefix}{$this->table} (title, revision, created, user_id, comment, content, event_id) VALUES ('{$title}',{$revision},now(),{$user_id},'{$comment}','{$content}',{$event_id})");
	}

	public function format($data, $controller) {
		$this->controller = $controller;

		$data['Wikipage']['content'] = preg_replace_callback('|(\[\[)(.*?)(\]\])|', array($this, 'formatAddLinks'), $data['Wikipage']['content']);
		$data['Wikipage']['content'] = preg_replace_callback('|(\{\{include:)(.*?)(\}\})|', array($this, 'formatIncludes'), $data['Wikipage']['content']);

        App::import('Vendor', 'Markdown/Markdown');
		$data['Wikipage']['content'] = Markdown::defaultTransform($data['Wikipage']['content']);
		return $data;
	}

	private function formatAddLinks($data) {
		$link = $title = null;

		if ( strpos($data[2], '"') !== false && preg_match('/(.*?)"(.*?)"/', $data[2], $matches) ) {
			$link = $matches[2];
			$title = Inflector::camelize($matches[1]);
		} else {
			$link = $title = Inflector::camelize($data[2]);
		}
		return '<a href="/'.WB::$event->reference.'/Wiki/'.$title.'">'.$link.'</a>';
	}

	private function formatIncludes($data) {
		$url = $data[2];

		ob_start();
		$dispatcher = new Dispatcher();
		$dispatcher->dispatch($url, array('bare'=>true,'return'=>true));
		$data = ob_get_contents();
		ob_end_clean();

		return($data);
	}
}
