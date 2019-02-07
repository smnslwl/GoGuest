<?php

require_once('app_config.php');

class DB extends PDO {

	protected function __construct()
	{
		try {
			parent::__construct("mysql:host=" . DB_HOSTNAME . ";dbname=" . DB_DATABASE, DB_USERNAME, DB_PASSWORD);
			parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch(PDOException $e) {
			die("Connection failed: " . $e->getMessage());
		}
	}

	public static function instance()
	{
		static $_instance = null;
		if ($_instance == null) {
			$_instance = new self;
		}
		return $_instance;
	}

};
