<?php
/**
 * Term Model
 *
 */
class Term extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';

	public $actsAs = array(
		'Translate' => array(
            'title',
			'content'
		)
	);

	public function getTerms() {
		$terms = $this->find('first',array(
			'conditions' => array(
                'Term.event_id' => WB::$event->id,
                'Term.active' => 1
            ),
            'order' => 'updated DESC'
		));
		return $terms;
	}
}
