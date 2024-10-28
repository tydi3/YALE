<?php //*** FormatX ~ class » Yaic™ Library for Laravel © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace App\Yaic\Tydi\Data;

use App\Yaic\Tydi\Data\StringX;

class FormatX
{
	// ◈ === title »
	public static function title($var)
	{
		if (!empty($var)) {
			$firstChar = $var[0];
			if (StringX::isLowercase($firstChar)) {
				if (StringX::uppercaseCount($var) > 0 && !StringX::hasSpace($var)) {
					$var = StringX::uppercaseToSpace($var);
				}
			} else {
				if (StringX::uppercaseCount($var) > 1) {
					$var = StringX::uppercaseToSpace($var);
				}
				$var = StringX::singleSpace($var);
			}
			return ucwords($var);
		}
	}



	// ◈ === website »
	public static function website($var)
	{
		if (StringX::notBeginWithAny($var, ['https://', 'http://'])) {
			$var .= 'https://';
		}
		return $var;
	}



	// ◈ === capitalize »
	public static function capitalize($var)
	{
		$var = StringX::toCapitalize($var);
		$var = StringX::swap($var, '(hq)', '(HQ)');
		return $var;
	}



	// ◈ === name »
	public static function name($var)
	{
		return ucwords(trim($var));
	}



	// ◈ === uppercase »
	public static function uppercase($var)
	{
		return StringX::toUpperCase($var);
	}



	// ◈ === lowercase »
	public static function lowercase($var)
	{
		return StringX::toLowerCase($var);
	}



	// ◈ === param »
	public static function param(&$param, $key, $classMethod)
	{
		if (isset($param[$key])) {
			// $param[$key] = call_user_func($callable, $param[$key]);
			$param[$key] = call_user_func([self::class, $classMethod], $param[$key]);
		}
	}



	// ◈ === input »
	public static function input($input)
	{
		if (!empty($input) && is_array($input)) {
			self::param($input, 'name', 'name');
			self::param($input, 'acronym', 'uppercase');
			self::param($input, 'firm', 'capitalize');
			self::param($input, 'city', 'capitalize');
			self::param($input, 'email', 'lowercase');
			self::param($input, 'website', 'website');
			self::param($input, 'address', 'capitalize');
		}
		return $input;
	}

}//> end of class ~ FormatX