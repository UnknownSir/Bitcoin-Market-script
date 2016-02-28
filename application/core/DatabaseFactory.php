<?php

/**
 * Class DatabaseFactory
 *
 * Use it like this:
 * $database = DatabaseFactory::getFactory()->getConnection();
 *
 * That's my personal favourite when creating a database connection.
 * It's a slightly modified version of Jon Raphaelson's excellent answer on StackOverflow:
 * http://stackoverflow.com/questions/130878/global-or-singleton-for-database-connection
 */
class DatabaseFactory
{
	private static $factory;
	private $database;

	public static function getFactory()
	{
		if (!self::$factory) {
			self::$factory = new DatabaseFactory();
		}
		return self::$factory;
	}

	public function getConnection() {
		if (!$this->database) {
			$options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
			$this->database = new PDO(
				Config::get('DB_TYPE') . ':host=' . Config::get('DB_HOST') . ';dbname=' .
				Config::get('DB_NAME') . ';port=' . Config::get('DB_PORT') . ';charset=' . Config::get('DB_CHARSET'),
				Config::get('DB_USER'), Config::get('DB_PASS'), $options
			);
		}
		return $this->database;
	}
}