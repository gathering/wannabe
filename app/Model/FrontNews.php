<?php
/**
 * FrontNews Model
 *
 */
class FrontNews extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
	public $actsAs = array(
		'Translate' => array(
			'title', 'content'
		)
	);
}
