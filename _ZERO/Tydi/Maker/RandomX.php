<?php //*** RandomX ~ class » Yaic™ Library for Laravel © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace App\Yaic\Tydi\Maker;

use App\Yaic\Tydi\Number\NumberX;

class RandomX
{
	// ◈ === length » randomize length
	public static function length($max = 100, $min = 1)
	{
		return mt_rand($min, $max);
	}



	// ◈ === string » randomize string
	public static function string($string, $length = 'auto')
	{
		$string = str_shuffle($string);
		if ($length === 'auto' || $length == 'ALL') {
			return $string;
		} elseif (is_numeric($length)) {
			$isLength = strlen($string);
			if ($length <= $isLength) {
				return substr($string, 0, $length);
			} else {
				$count = $length - $isLength;
				return $string . self::string($string, $count);
			}
		}
		return false;
	}



	// ◈ === array » randomize array
	public static function array($array, $length = 'auto')
	{
		shuffle($array);
		$string = '';
		foreach ($array as $value) {
			$string .= $value;
		}
		return self::string($string, $length);
	}



	// ◈ === initialize » initialize randomization
	public static function initialize($input, $length = 'auto')
	{
		if (!empty($input)) {
			if (is_array($input)) {
				return self::array($input, $length);
			} else {
				return self::string($input, $length);
			}
		}
		return false;
	}



	// ◈ === digit » generate numbers
	public static function digit($length = 4)
	{
		return self::initialize('1234567890', $length);
	}



	// ◈ === numeric » generate numbers
	public static function numeric($length = 4)
	{
		return self::digit($length);
	}



	// ◈ === pin » generate pin
	public static function pin($length = 5)
	{
		return self::digit($length);
	}



	// ◈ === alpha » generate alphabet
	public static function alpha($length = 4, $case = 'auto')
	{
		if ($case === 'lowercase') {
			$alpha = range('a', 'z');
			shuffle($alpha);
		} elseif ($case === 'uppercase') {
			$alpha = range('A', 'Z');
			shuffle($alpha);
		} else {
			$alpha = array_merge(range('a', 'z'), range('A', 'Z'));
			shuffle($alpha);
		}
		return self::initialize($alpha, $length);
	}



	// ◈ === uppercase »
	public static function uppercase($length = 4)
	{
		return self::alpha($length, 'uppercase');
	}



	// ◈ === lowercase »
	public static function lowercase($length = 4)
	{
		return self::alpha($length, 'lowercase');
	}



	// ◈ === alphanumeric » generate alpha-numeric
	public static function alphanumeric($length = 4, $case = 'auto')
	{
		$alpha = self::alpha($length, $case);
		$digit = self::digit($length);
		return self::initialize($alpha . $digit, $length);
	}



	// ◈ === char » generate special character
	public static function char($length = 1)
	{
		return self::initialize('(_=@#$[%{&*?)]!}', $length);
	}



	// ◈ === uid » generate unique id
	public static function uid()
	{
		$lower = self::alpha('auto', 'lowercase');
		$upper = self::alpha('auto', 'uppercase');
		$digit = self::digit('auto');
		$time = time();
		$rand = mt_rand();
		$o = $rand . $lower . $digit . $upper . $time;
		return str_shuffle($o);
	}



	// ◈ === ruid » Random Unique ID
	public static function ruid($length = 10)
	{
		return substr(self::uid(), 0, $length);
	}



	// ◈ === guid »
	public static function guid($length = 12)
	{
		if ($length <= 10) {
			return self::digit($length);
		}

		$length = $length - 10;
		if ($length <= 3) {
			return self::digit(10) . self::uppercase($length);
		}

		$length = $length - 3;
		return self::uppercase(3) . self::digit(10) . self::uppercase($length);
	}



	// ◈ === puid » primary unique id
	public static function puid($length = 20)
	{
		return substr(self::uid(), 0, $length);
	}



	// ◈ === suid » secondary unique id
	public static function suid($length = 40)
	{
		return substr(self::uid(), 0, $length);
	}



	// ◈ === tuid » tertiary unique id
	public static function tuid($length = 70)
	{
		return substr(self::uid(), 0, $length);
	}



	// ◈ === luid » log unique id
	public static function luid($length = 50)
	{
		return substr(self::uid(), 0, $length);
	}



	// ◈ === filename » generate unique filename
	public static function filename($length = 20, $case = 'auto')
	{
		if (strtoupper($case) === 'DIGIT') {
			return self::digit($length);
		}
		return self::alphanumeric($length, $case);
	}



	// ◈ === username » generate unique username
	public static function username($length = 'auto')
	{
		if ($length == 'auto') {
			$o = self::alpha(8, 'lowercase') . self::digit(4);
		} else {
			$o = self::alpha($length, 'lowercase');
		}
		return $o;
	}



	// ◈ === simple » generate simple randomization
	public static function simple()
	{
		$alpha = chr(rand() > 0.5 ? rand(65, 90) : rand(97, 122));
		return $alpha . mt_rand(100, 999) . date('sdm') . mt_rand(10, 99) . self::alpha(3);
	}



	// ◈ === ten » generate 10 characters
	public static function ten($flag = 'auto')
	{
		return self::digit(8) . self::alpha(2, $flag);
	}



	// ◈ === ban » generate bank account number
	public static function ban()
	{
		return mt_rand(1000000000, 9999999999);
	}



	// ◈ === token » 50 alphanumeric characters
	public static function token($length = 'RAND')
	{
		if ($length === 'RAND') {
			$length = mt_rand(20, 30);
		}
		return substr(self::uid(), 0, $length);
	}



	// ◈ === key » 20 alphanumeric characters
	public static function key($length = 20)
	{
		return substr(self::uid(), 0, $length);
	}



	// ◈ === password » 20 alphanumeric characters
	public static function password($length = 12)
	{
		if (NumberX::isEven($length)) {
			$A = self::length($length / 2);
		} else {
			$A = self::length(($length - 1) / 2);
		}
		$partA = substr(self::uid(), 0, $A);

		$B = self::length(2);
		$partB = self::initialize('(=_@#[{*)]}', $B);

		$lengthNow = $A + $B;
		if ($length > $lengthNow) {
			$length = $length - $lengthNow;
		}

		$partC = self::alphanumeric($length);
		return $partA . $partB . $partC;
	}



	// ◈ === word »
	public static function word(array $words, $number = 1)
	{
		shuffle($words);
		$max = count($words);
		$key = mt_rand(0, $max);
		if ($key == $max) {
			$index = $key - 1;
		} else {
			$index = $key;
		}
		if ($number === 1) {
			return $words[$index];
		}
	}



	// ◈ === otp »
	public static function otp($num = 6)
	{
		$pin = '';
		$digits = range(0, 9);
		shuffle($digits);
		for ($i = 0; $i < $num; $i++) {
			$pin .= $digits[$i];
		}
		return $pin;
	}



	// ◈ === id » [string, integer]
	public static function id($num = null, $alphaNumeric = true)
	{
		if (is_null($num)) {
			$num = mt_rand(5, 8);
		}
		if ($alphaNumeric) {
			return self::alphanumeric($num);
		}
		return self::digit($num);
	}



	// ◈ === serial » string
	public static function serial()
	{
		return date('Ym') . self::alphanumeric(4, 'uppercase') . self::alpha(2, 'uppercase');
	}
}//> end of class ~ RandomX