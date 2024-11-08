<?php //*** PathX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Anci;

class PathX
{
	// ◈ property
	private static $DS;
	private static $init = false;



	// ◈ === DS »
	public static function DS()
	{
		self::init();
		return self::$DS;
	}



	// ◈ === app »
	public static function app(string $path = '')
	{
		return app_path($path);
	}



	// ◈ === base »
	public static function base(string $path = '')
	{
		return base_path($path);
	}



	// ◈ === config »
	public static function config(string $path = '')
	{
		return config_path($path);
	}



	// ◈ === database »
	public static function database(string $path = '')
	{
		return database_path($path);
	}



	// ◈ === lang »
	public static function lang(string $path = '')
	{
		return lang_path($path);
	}



	// ◈ === public »
	public static function public(string $path = '')
	{
		return public_path($path);
	}



	// ◈ === resource »
	public static function resource(string $path = '')
	{
		return resource_path($path);
	}



	// ◈ === storage »
	public static function storage(string $path = '')
	{
		return storage_path($path);
	}



	// ◈ === route »
	public static function route(string $path = '')
	{
		self::init();
		$directory = self::base() . self::$DS . 'routes' . self::$DS;
		if (!empty($path)) {
			$directory .= $path . self::$DS;
		}
		return $directory;
	}



	// ◈ === zero »
	public static function zero(string $path = null)
	{
		self::init();
		if ($path === 'route') {
			$path = self::route() . 'zero' . self::$DS;
		}
		return $path;
	}



	// ◈ === debug »
	public static function debug(string $path = null)
	{
		self::init();
		if ($path === 'route') {
			$path = self::route() . 'debug' . self::$DS;
		}
		return $path;
	}



	// ◈ === init »
	private static function init()
	{
		if (!self::$init) {
			self::$DS = DIRECTORY_SEPARATOR;
			self::$init = true;
		}
	}


}//> end of class ~ PathX