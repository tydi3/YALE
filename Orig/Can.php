<?php //*** Can ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Orig;

class Can
{
	// ◈ === is »
	public static function is(&$var = null, $comparison = null, $strictCheck = false)
	{
		if (is_null($var)) {
			return false;
		}

		if (is_null($comparison)) {
			if ($var === 0) {
				return true;
			}
			if (!empty($var)) {
				return true;
			}
		} else {
			if ($strictCheck) {
				return $var === $comparison;
			} else {
				return $var == $comparison;
			}
		}

		return false;
	}



	// ◈ === iterate »
	public static function iterate(&$var): bool
	{
		return is_iterable($var);
	}



	// ◈ === string »
	public static function string(&$var): bool
	{
		if (!blank($var)) {

			// ~ is scalar [string, integer, float, or boolean]
			if (is_scalar($var)) {
				return true;
			}

			// ~ is an object that implements __toString
			if (is_object($var) && method_exists($var, '__toString')) {
				return true;
			}
		}

		return false;
	}



	// ◈ === setIfNot »
	public static function setIfNot(&$var, $value)
	{
		if (!self::is($var)) {
			$var = $value;
			return true;
		}
		return false;
	}



	// ◈ === setIf »
	public static function setIf($var, &$check, $value = null)
	{
		if (self::is($check)) {
			if (is_null($value)) {
				$var = $check;
			} else {
				$var = $value;
			}
			return $var;
		}
		return null;
	}

}//> end of class ~ Can