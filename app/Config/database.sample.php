<?php
class DATABASE_CONFIG {
	public $default;

	public function __construct(){
		$this->default = array(
			'datasource' => 'Database/Mysql',
			'persistent' => false,
            'host' => env('MYSQL_URL'),
			'login' => env('MYSQL_USER'),
			'password' => env('MYSQL_PASSWORD'),
			'database' => env('MYSQL_DATABASE'),
			'prefix' => 'wb4_',
			'encoding' => 'utf8',
		);
	}
}
