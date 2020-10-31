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
			'title', 'content',
			/**
			 * During item creation on admin pages usually only norwegian or
			 * english version of each item is created. Activating `left` makes
			 * sure all of these appear in admin panels, to allow adding the
			 * translated versions without changing user language.
			 */
			'joinType' => 'left',
		)
	);
}
