<?php
/**
 * MailinglistaddressesNotopt Model
 *
 */
class MailinglistaddressesNotopt extends AppModel {
/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'address';
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'mailinglist';

    public $tableIsView = true;
}
