<?php

namespace App\Controllers;

use \PDO;
use \PDOException;

class DatabaseController
{
	private static $host = null;
	private static $dbname = null;
	private static $user = null;
	private static $password = null;

	private static $connection = null;

	public function __construct()
	{
		die('Init not allowed');
	}

	public static function connect()
	{
		$settings = json_decode(file_get_contents(dirname(__DIR__) . '/config/env/.database.json'));
		if (isset($settings->host) && !empty($settings->host)) {
			self::$host = $settings->host;
		}
		if (isset($settings->database) && !empty($settings->database)) {
			self::$dbname = $settings->database;
		}
		if (isset($settings->user) && !empty($settings->user)) {
			self::$user = $settings->user;
		}
		if (isset($settings->password) && !empty($settings->password)) {
			self::$password = $settings->password;
		}
		if (null == self::$connection) {
			try {
				if (!is_null(self::$dbname)) {
					self::$connection = new PDO("mysql:host=" . self::$host . ";" . "dbname=" . self::$dbname, self::$user, self::$password);
					self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				} else {
					self::$connection = 0;
				}
			} catch (PDOException $e) {
				self::$connection = $e->getCode();
			}
		}
		return self::$connection;
	}

	public static function disconnect()
	{
		self::$connection = null;
	}
}
