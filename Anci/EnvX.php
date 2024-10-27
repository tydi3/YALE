<?php //*** EnvX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Anci;

use App\Yaic\Xena\Data\StringX;
use Illuminate\Support\Facades\App;

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
		if ($env === null) {
			return self::$env;
		}

		if (!empty($env) && is_string($env)) {
			self::init();
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
			return null;
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



	// ◈ === properties » get all values in .env
	public static function properties()
	{
		self::init();

		$path = PathX::base('.env');
		if (!file_exists($path)) {
			return [];
		}
		$lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		$properties = [];
		$multi = '';
		list($label, $value) = [null, null];
		foreach ($lines as $index => $line) {
			if (empty($line) || $line[0] === '#') {
				unset($lines[$index]);
				continue;
			}
			$multi .= self::line($lines, $index, $line, $label, $value);
			if (isset($label)) {
				$properties[$label] = $value;
			}
		}
		self::lines($multi, $properties);
		return $properties;
	}



	// ◈ === init »
	private static function init()
	{
		if (!self::$init) {
			self::$env = strtolower(App::environment());
			self::$firm = self::toObject('firm');
			self::$project = self::toObject('project');
			self::$developer = self::toObject('developer');
			self::$init = true;
		}
	}



	// ◈ === toObject »
	private static function toObject($property)
	{
		$properties = ['firm', 'project', 'developer'];
		if (in_array($property, $properties)) {
			$array = array_reduce(
				array_filter(array_map('trim', explode(';', trim(env($property, ''))))),
				function ($parsed, $item) {
					if (strpos($item, '=') !== false) {
						list($key, $value) = explode('=', $item, 2);
						$parsed[$key] = $value;
					}
					return $parsed;
				},
				[]
			);
			return (object) $array;
		}
	}



	// ◈ === lineToArray »
	private static function lineToArray($string)
	{
		$result = [];
		$pairs = explode(';', $string);
		foreach ($pairs as $pair) {
			$pair = trim($pair);
			if (!$pair) {
				continue;
			}
			list($key, $value) = explode('=', $pair, 2);
			$key = trim($key);
			$value = isset($value) ? trim($value) : '';
			if ($key !== '') {
				$result[$key] = $value;
			}
		}
		return $result;
	}



	// ◈ === lines »
	private static function lines($lines, &$array = [])
	{
		$pattern = '/(\w+)=(?:"(.*?)"|(true|false|\d+|[\w\-.]+))/';
		preg_match_all($pattern, $lines, $matches, PREG_SET_ORDER);
		foreach ($matches as $match) {
			$key = $match[1];
			$value = $match[2] !== '' ? $match[2] : ($match[3] !== '' ? $match[3] : $match[4]);
			$array[$key] = self::lineToArray($value);
		}
	}



	// ◈ === line »
	private static function line(&$lines, $index, $line, &$label, &$value)
	{
		if (StringX::contain($line, '="') && StringX::endWith($line, '"') && !StringX::endWith($line, '="')) {
			$label = StringX::before($line, '="');
			$value = StringX::cropEnd(StringX::after($line, '="'), '"');
			unset($lines[$index]);
		} elseif (StringX::contain($line, '=') && !StringX::endWithAny($line, [';', '="'])) {
			$label = StringX::before($line, '=');
			$value = StringX::after($line, '=');
			unset($lines[$index]);
		} else {
			return trim($line);
		}
	}

}//> end of class ~ EnvX