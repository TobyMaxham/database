<?php

namespace TobyMaxham;

use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Class Connector
 * @package TobyMaxham
 * @author Tobias Maxham <git2015@maxham.de>
 */
class DBConnector
{
	const CHARSET = 'utf8';
	const COLLATION = 'utf8_unicode_ci';
	const DRIVER = 'mysql';

	private static $connections = [];

	/**
	 * @var Capsule $capsule
	 */
	private static $capsule;

	/**
	 * @param array $config
	 * @param string $name
	 */
	public static function connect($config, $name = 'default')
	{
		$capsule = self::addCapsule();
		self::addConnection($config, $name);
		$capsule->bootEloquent();
	}

	/**
	 * @return Capsule $capsule
	 */
	private static function addCapsule()
	{
		self::$capsule = new Capsule();
		return self::$capsule;
	}

	/**
	 * @param array $config
	 * @param string $name
	 */
	public static function addConnection($config, $name = 'default')
	{
		if (is_null(self::$capsule)) self::addCapsule();

		if(!isset($config['collation'])) $config['collation'] = self::COLLATION;
		if(!isset($config['charset'])) $config['charset'] = self::CHARSET;
		if(!isset($config['prefix'])) $config['prefix'] = '';
		if(!isset($config['driver'])) $config['driver'] = self::DRIVER;

		self::$capsule->addConnection($config, $name);
		self::$connections[] = $name;
	}

} 