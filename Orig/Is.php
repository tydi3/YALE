<?php //*** Is ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Orig;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class Is
{
	// ◈ === instance »
	public static function instance($var, $instanceOf)
	{
		return $var instanceof $instanceOf;
	}



	// ◈ === string »
	public static function string($var)
	{
		return is_string($var);
	}



	// ◈ === array »
	public static function array($var)
	{
		return is_array($var);
	}



	// ◈ === numeric »
	public static function numeric($var)
	{
		return is_numeric($var);
	}



	// ◈ === object »
	public static function object($var, $instanceOf = null)
	{
		if (is_object($var)) {
			if (!empty($instanceOf)) {
				return self::instance($var, $instanceOf);
			}
			return true;
		}
		return false;
	}



	// ◈ === collection »
	public static function collection($var)
	{
		return $var instanceof Collection;
	}



	// ◈ === model »
	public static function model($var)
	{
		return $var instanceof Model;
	}



	// ◈ === number »
	public static function number($var)
	{
		return ctype_digit($var);
	}



	// ◈ === alphabet »
	public static function alphabet($var)
	{
		return ctype_alpha($var);
	}



	// ◈ === lowercase »
	public static function lowercase($var)
	{
		return ctype_lower($var);
	}



	// ◈ === uppercase »
	public static function uppercase($var)
	{
		return ctype_upper($var);
	}



	// ◈ === mixedcase »
	public static function mixedcase($var)
	{
		return (preg_match('/[a-z]/', $var) && preg_match('/[A-Z]/', $var));
	}



	// ◈ === email »
	public static function email($var)
	{
		return filter_var($var, FILTER_VALIDATE_EMAIL) !== false;
	}



	// ◈ === phone »
	public static function phone($var, $country = 'NGA'): bool
	{
		if (!is_numeric($var) && !is_numeric(substr($var, 1))) {
			return false;
		}

		if ($country === 'NGA') {
			$validPatterns = [
				'0' => 11,          // ~ 09026636728
				'234' => 13,        // ~ 2349026636728
				'+234' => 14        // ~ +2349026636728
			];

			foreach ($validPatterns as $prefix => $length) {
				if (str_starts_with($var, $prefix) && strlen($var) === $length) {
					return true;
				}
			}
		}

		return false;
	}



	// ◈ === type » $var type or comparison
	public static function type(&$var, $type = null)
	{
		if (is_null($type)) {
			return gettype($var);
		}
		if (!empty($type) && strtolower(gettype($var)) === strtolower($type)) {
			return true;
		}
		return false;
	}



	// ◈ === null »
	public static function null(&$var)
	{
		return is_null($var);
	}



	// ◈ === empty »
	public static function empty(&$var)
	{

		if (!isset($var)) {
			return true;
		}

		if ((self::object($var) || is_array($var)) && empty($var)) {
			return true;
		}

		if (self::collection($var) && $var->isEmpty()) {
			return true;
		}

		if (is_string($var) && ($var == '' || strlen($var) == 0)) {
			return true;
		}

		return false;
	}

}//> end of class ~ Is