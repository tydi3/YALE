<?php //*** DateX ~ class » Yaic™ Library for Laravel © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace App\Yaic\Tydi\Time;

use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class DateX
{
	// ◈ === is »
	public static function is($date, $asCarbon = false)
	{
		try {
			$carbon = Carbon::parse($date);
		} catch (InvalidFormatException $e) {
			return false;
		} catch (\Exception $e) {
			return false;
		}

		if (!$asCarbon) {
			return true;
		}
		return $carbon;
	}



	// ◈ === carbon »
	public static function carbon($date)
	{
		return Carbon::parse($date)->startOfDay();
	}



	// ◈ === format »
	public static function format($format = null, $separator = '-')
	{
		switch ($format) {
			case 'SQL':
			case 'HTML':
				return 'Y-m-d';
			case 'SHORT':
				return 'M. jS, Y';
			case 'SHORTROW':
				return 'jS M, Y';
			case 'LETTER':
				return 'd F, Y';
			case 'US':
				return 'm' . $separator . 'd' . $separator . 'Y';
			case 'UK':
				return 'd' . $separator . 'm' . $separator . 'Y';
			default:
				return $format;
		}
	}



	// ◈ === isEqual ['YYYY-MM-DD'] »
	public static function isEqual($date, $reference = null)
	{
		$date = self::carbon($date);
		$reference = self::reference($reference);
		if ($date->equalTo($reference)) {
			return true;
		}
		return false;
	}



	// ◈ === isPast ['YYYY-MM-DD'] »
	public static function isPast($date, $reference = null)
	{
		if (self::isEqual($date, $reference)) {
			return false;
		}
		$date = self::carbon($date);
		$reference = self::reference($reference);
		return $date->isBefore($reference);
	}



	// ◈ === isFuture ['YYYY-MM-DD'] »
	public static function isFuture($date, $reference = null)
	{
		if (self::isEqual($date, $reference)) {
			return false;
		}
		$date = self::carbon($date);
		$reference = self::reference($reference);
		return $date->isAfter($reference);
	}



	// ◈ === isDue » boolean
	public static function isDue($date, $reference = 'today')
	{
		if (!self::isFuture($date, $reference)) {
			return true;
		}
		return false;
	}



	// ◈ === isActual date ['YYYY-MM-DD'] »
	public static function isActual($input, $format = 'Y-m-d')
	{
		try {
			$date = Carbon::createFromFormat($format, $input);
		} catch (InvalidFormatException $e) {
			return false;
		}
		return $date && $date->format($format) === $input;
	}



	// ◈ === isSQL » boolean
	public static function isSQL($date)
	{
		return self::isActual($date, 'Y-m-d');
	}



	// ◈ === sql (mysql date type) » boolean
	public static function sql($time = null)
	{
		$timestamp = TimeX::timestamp($time);
		if ($timestamp) {
			return date('Y-m-d', $timestamp);
		}
		return $time;
	}



	// ◈ === short »
	public static function short($date = null)
	{
		$date = TimeX::timestamp($date);
		if ($date) {
			$format = self::format('SHORT');
			return date($format, $date);
		}
		return $date;
	}



	// ◈ === shortrow »
	public static function shortrow($date = null, $superscript = false)
	{
		$date = TimeX::timestamp($date);
		if ($date) {
			$format = self::format('SHORTROW', $superscript);
			return date($format, $date);
		}
		return $date;
	}



	// ◈ === letter »
	public static function letter($date = null, $superscript = false)
	{
		$date = TimeX::timestamp($date);
		if ($date) {
			$format = self::format('LETTER', $superscript);
			return date($format, $date);
		}
		return $date;
	}



	// ◈ === month »
	public static function month($date = null)
	{
		$date = TimeX::timestamp($date);
		if ($date) {
			return date('m', $date);
		}
		return $date;
	}



	// ◈ === year »
	public static function year($date = null)
	{
		$date = TimeX::timestamp($date);
		if ($date) {
			return date('Y', $date);
		}
		return $date;
	}



	// ◈ === day »
	public static function day($date = null)
	{
		$date = TimeX::timestamp($date);
		if ($date) {
			return date('d', $date);
		}
		return $date;
	}



	// ◈ === from »
	public static function from($string, $date = null, $method = null)
	{
		$date = TimeX::timestamp($date);
		$timestamp = strtotime($string, $date);
		if (!empty($method) && method_exists(__CLASS__, $method)) {
			return self::$method($timestamp);
		}
		return $timestamp;
	}



	// ◈ === addDuration »
	public static function addDuration($date, $duration, $format = null)
	{
		if (!$format) {
			$format = 'm/d/Y';
		}
		if ($format === 'SQL') {
			$format = 'Y-m-d';
		}
		$date = Carbon::createFromFormat($format, $date);
		$date->add($duration);
		return $date->format($format);
	}



	// ◈ === string »
	public static function string($string, $format = 'Y-m-d')
	{
		$date = Carbon::now();
		$date = $date->add($string);
		$format = self::format($format);
		return $date->format($format);
	}



	// ◈ === toHTML »
	public static function toHTML($date = null)
	{
		$date = TimeX::timestamp($date);
		if ($date) {
			$format = self::format('HTML');
			return date($format, $date);
		}
		return $date;
	}



	// ◈ === reference »
	protected static function reference($date = null)
	{
		if (is_null($date) || in_array(strtolower($date), ['today', 'now'])) {
			$date = Carbon::now()->startOfDay();
		} else {
			$date = self::carbon($date);
		}
		return $date;
	}

}//> end of class ~ DateX
