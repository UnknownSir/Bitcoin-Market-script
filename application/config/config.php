<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

/**
 * Returns the full configuration.
 * This is used by the core/Config class.
 */
 
DEFINE('SITE_NAME', 'Bitcoin buy sell');
DEFINE('SITE_EMAIL', 'test"gmail.com');


return array(
	'URL' => 'http://' . $_SERVER['HTTP_HOST'] . str_replace('public', '', dirname($_SERVER['SCRIPT_NAME'])),
	'PATH_CONTROLLER' => realpath(dirname(__FILE__).'/../../') . '/application/controller/',
	'PATH_VIEW' => realpath(dirname(__FILE__).'/../../') . '/application/view/',
	'PATH_LIBS' => realpath(dirname(__FILE__).'/../../') . '/application/libs/',
	'DEFAULT_CONTROLLER' => 'index',
	'DEFAULT_ACTION' => 'index',
	'DB_TYPE' => 'mysql',
	'DB_HOST' => '127.0.0.1',
	'DB_NAME' => 'btc',
	'DB_USER' => 'root',
	'DB_PASS' => '',
	'DB_PORT' => '3306',
	'DB_CHARSET' => 'utf8',
	'COOKIE_RUNTIME' => 1209600,
	'COOKIE_PATH' => '/',
	'EMAIL_USED_MAILER' => 'phpmailer',
	'EMAIL_USE_SMTP' => true,
	'EMAIL_SMTP_HOST' => 'smtp.gmail.com',
	'EMAIL_SMTP_AUTH' => true,
	'EMAIL_SMTP_USERNAME' => 'test"gmail.com',
	'EMAIL_SMTP_PASSWORD' => 'test',
	'EMAIL_SMTP_PORT' => 465,
	'EMAIL_SMTP_ENCRYPTION' => 'ssl'
);
