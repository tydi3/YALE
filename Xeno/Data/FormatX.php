<?php //*** FormatX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\Data;

use Yale\Anci\VarX;
use Yale\Xeno\Time\PeriodX;
use Yale\Concept\Enum\Gender as GenderEnum;

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
		$var = StringX::capitalize($var);
		$var = StringX::swap($var, '(hq)', '(HQ)');
		return $var;
	}



	// ◈ === var »
	public static function var(&$var, $format = 'string', $default = '')
	{
		$o = VarX::safe($var, $default);
		if (!empty($o)) {
			if ($format === 'capitalize') {
				return self::capitalize($o);
			}
		}
		return $o;
	}



	// ◈ === date »
	public static function date($date, $format = null)
	{
		if ($format === 'log') {
			$format = 'datetime';
		}
		if ($format === 'logdate') {
			$format = 'date';
		}
		if ($format === 'logtime') {
			$format = 'time';
		}
		return PeriodX::log($date, $format);
	}



	// ◈ === name »
	public static function name($var)
	{
		return ucwords(trim($var));
	}



	// ◈ === gender »
	public static function gender($gender)
	{
		return StringX::firstCap(GenderEnum::toValue($gender));
	}



	// ◈ === email »
	public static function email($email)
	{
		return StringX::lowercase($email);
	}



	// ◈ === phone »
	public static function phone($phone, $country = 'NG')
	{
		if ($country === 'NG') {
			if (StringX::beginWith($phone, '0')) {
				$phone = StringX::swapFirst($phone, '0', '+234');
			} elseif (StringX::beginWith($phone, '234')) {
				$phone = '+' . $phone;
			}
		}
		return ($phone);
	}



	// ◈ === uppercase »
	public static function uppercase($var)
	{
		return StringX::uppercase($var);
	}



	// ◈ === lowercase »
	public static function lowercase($var)
	{
		return StringX::lowercase($var);
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