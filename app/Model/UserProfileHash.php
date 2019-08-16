<?php
App::uses('AppModel', 'Model');
/**
 * UserProfileHash Model
 *
 */
class UserProfileHash extends AppModel {
/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'user_id';
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'hash';
}
