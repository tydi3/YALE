<?php //*** EnvX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Anci;

use Illuminate\Support\Facades\App;
use Yale\Xeno\Data\StringX;

class EnvX
{
	// ◈ property
	private static $init = false;
	private static $env;
	private static $firm;
	private static $project;
	private static $developer;



	// ◈ === is »
	public static function is($env = null)
	{
		self::init();

		if ($env === null) {
			return self::$env;
		}

		if (!empty($env) && is_string($env)) {
			if (self::$env === strtolower($env)) {
				return true;
			}
		}

		return false;
	}



	// ◈ === dev » is development (local) environment
	public static function dev()
	{
		return self::is('local');
	}



	// ◈ === stage » is staging (testing) environment
	public static function stage()
	{
		return self::is('staging');
	}



	// ◈ === prod » is production (live) environment
	public static function prod()
	{
		return self::is('production');
	}



	// ◈ === property »
	public static function property($property, $key = null)
	{
		self::init();

		if (isset(self::${$property})) {
			$property = self::${$property};
		} else {
			return DebugX::oversight('Env', 'property not set', $property);
		}

		if (is_object($property)) {
			if (!is_null($key) && property_exists($property, $key)) {
				return $property->{$key};
			} elseif (is_null($key)) {
				return $property;
			}
		}

		return null;
	}



	// ◈ === firm »
	public static function firm($key = null)
	{
		return self::property('firm', $key);
	}



	// ◈ === project »
	public static function project($key = null)
	{
		return self::property('project', $key);
	}



	// ◈ === developer »
	public static function developer($key = null)
	{
		return self::property('developer', $key);
	}



	// ◈ === init »
	private static function init()
	{
		if (!self::$init) {
			self::$env = strtolower(App::environment());
			self::$firm = self::toObject('FIRM');
			self::$project = self::toObject('PROJECT');
			self::$developer = self::toObject('DEVELOPER');
			self::$init = true;
		}
	}



	// ◈ === lineToArray »
	private static function lineToArray($input)
	{
		$result = [];
		$pairs = array_filter(array_map('trim', explode(';', $input)));
		foreach ($pairs as $pair) {
			if (strpos($pair, '=') !== false) {
				list($key, $value) = explode('=', $pair, 2);
				$key = trim($key);
				$value = trim($value);
				if (isset($result[$key])) {
					if (!is_array($result[$key])) {
						$result[$key] = [$result[$key]];
					}
					$result[$key][] = $value;
				} else {
					$result[$key] = $value;
				}
			}
		}
		return $result;
	}



	// ◈ === toObject »
	private static function toObject($property)
	{
		// ~ List of properties we want to parse from the .env file
		$properties = ['FIRM', 'PROJECT', 'DEVELOPER'];

		// ~ Check if the provided property is valid
		if (!in_array($property, $properties)) {
			return DebugX::oversight('Env', 'invalid property', $property);
		}

		// ~ Fetch the multi-line environment variable and trim whitespace
		$property = strtolower($property);
		$value = config('app.' . $property);


		// ~ If the environment variable is empty, return an empty object
		if (empty($value)) {
			return DebugX::oversight('Env', 'property should not be empty', $property);
		}

		// ~ Parse the environment variable into an associative array
		$array = self::lineToArray($value);



		// ~ convert array to object
		return (object) $array;
	}

}//> end of class ~ EnvX