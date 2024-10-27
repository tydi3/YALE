<?php //*** VarX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Anci;

class VarX
{
	// ◈ === is » boolean
	public static function is(&$var = null, $comparison = null, $strick = false)
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
		}
		// TODO: implement code for comparison & strick check
		return false;
	}



	// ◈ === safe »
	public static function safe(&$var = null, $default = '')
	{
		return isset($var) ? $var : $default;
	}




















	// • ==== setIfNot → ... » boolean
	public static function setIfNot(&$var, $value)
	{
		if (!self::is($var)) {
			$var = $value;
			return true;
		}
		return false;
	}



	// • ==== setIf → ... » boolean | value
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

}//> end of class ~ VarX