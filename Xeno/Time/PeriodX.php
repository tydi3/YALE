<?php //*** PeriodX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\Time;

use Exception;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Yale\Xeno\Time\TimeX;

class PeriodX
{
	// ◈ property
	private static $format = 'Y-m-d H:i:s';



	// ◈ === parse »
	public static function parse($time = null, $exception = false, $timezone = null)
	{
		try {
			return Carbon::parse($time, $timezone);
		} catch (InvalidFormatException $e) {
			if (!$exception) {
				return false;
			}
			dd('Date/Time: invalid format');
		} catch (Exception $e) {
			if (!$exception) {
				return false;
			}
			dd('Exception: ', $e->getMessage());
		}
	}



	// ◈ === carbon » [carbon::object | boolean]
	public static function carbon($time, $exception = true)
	{
		return self::parse($time, $exception);
	}



	// ◈ === is » [carbon::object | boolean]
	public static function is($time, bool $asCarbon = false)
	{
		if (!$asCarbon) {
			return self::parse($time, false);
		}
		return self::parse($time, true);
	}



	// ◈ === isCarbon » [boolean]
	public static function isCarbon($var)
	{
		if ($var instanceof Carbon) {
			return true;
		} else {
			$carbon = self::parse($var, false);
			return $carbon instanceof Carbon;
		}
	}



	// ◈ === startOfDay » resets time to 00:00:00 → [carbon::object | boolean::false]
	public static function startOfDay($time = 'today')
	{
		$carbon = self::carbon($time, false);
		if (self::isCarbon($carbon)) {
			return $carbon->startOfDay();
		}
		return false;
	}



	// ◈ === stringTo »
	public static function stringTo($string, $format = null)
	{
		$format = $format ?? self::$format;
		$carbon = self::carbon($string, false);
		if (self::isCarbon($carbon)) {
			$date = Carbon::createFromFormat($format, $carbon);
			return $date->format($format);
		}
		return false;
	}



	// ◈ === difference »
	public static function difference($time, $reference = 'now')
	{
		$time = self::carbon($time, false);
		if (strtolower($reference) === 'now') {
			$reference = Carbon::now();
		} else {
			$reference = self::carbon($reference, false);
		}

		if (self::isCarbon($reference) && self::isCarbon($time)) {
			$o['second'] = $reference->diffInSeconds($time, false);
			$o['minute'] = $reference->diffInMinutes($time, false);
			$o['hour'] = $reference->diffInHours($time, false);
			$o['day'] = $reference->diffInDays($time, false);
			$o['week'] = $reference->diffInWeeks($time, false);
			$o['month'] = $reference->diffInMonths($time, false);
			$o['year'] = $reference->diffInYears($time, false);
			return $o;
		}

		return false;
	}



	// ◈ === toString »
	public static function toString($time, $reference = 'now', $in = null)
	{
		$difference = self::difference($time, $reference);
		if (is_array($difference)) {
			return $difference;
		}
		return false;
	}



	// ◈ === toDate »
	public static function toDate($format, $timestamp)
	{
		return date($format, $timestamp);
	}



	// ◈ === fulldate » human readable → string
	public static function fulldate($datetime)
	{
		return self::toDate('F j, Y g:i A', strtotime($datetime));
	}



	// ◈ === log »
	public static function log($period, $format = 'datetime')
	{
		$timestamp = TimeX::timestamp($period);

		if ($format === 'date') {
			$timestamp = self::toDate('Y-m-d', $timestamp);
		} elseif ($format === 'time') {
			$timestamp = self::toDate('h:i:s A', $timestamp);
		} elseif ($format === 'datetime') {
			$timestamp = self::toDate('Y-m-d h:i:s A', $timestamp);
		}

		return $timestamp;
	}

}//> end of PeriodX n