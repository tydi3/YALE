<?php //*** TimeX » Yaic™ Library for Laravel © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace App\Yaic\Tydi\Time;

class TimeX
{
	// ◈ === isString → ... » boolean
	public static function isString($string)
	{
		$timestamp = strtotime($string);
		return $timestamp !== false;
	}



	// ◈ === isTimestamp → ... » boolean
	public static function isTimestamp($timestamp)
	{
		$dateTime = \DateTime::createFromFormat('U', $timestamp);
		if (is_object($dateTime)) {
			$time = $dateTime->getLastErrors();
			if (is_array($time)) {
				return $dateTime !== false && !array_sum($time);
			}
		}
		return false;
	}



	// ◈ === timestamp → ... » timestamp|null
	public static function timestamp($time = null)
	{
		$time = $time ?? now();
		if (self::isString($time)) {
			$time = strtotime($time);
		}
		if (self::isTimestamp($time)) {
			return $time;
		}
		return $time;
	}



	// ◈ === isPast → ... » boolean
	public static function isPast($time, $due = null)
	{
		$time = Carbon::parse($time);

		if (!$due) {
			return $time->isPast();
		}

		if (strtoupper($due) === 'NOW') {
			$due = Carbon::now();
		} else {
			$due = Carbon::parse($due);
		}

		return $time->isBefore($due);
	}



	// ◈ === isFuture → ... » boolean
	public static function isFuture($time, $due = null)
	{
		$time = Carbon::parse($time);

		if (!$due) {
			return $time->isFuture();
		}

		if (strtoupper($due) === 'NOW') {
			$due = Carbon::now();
		} else {
			$due = Carbon::parse($due);
		}
		return $time->isAfter($due);
	}



	public static function isDue($time, $due = null)
	{
	}



	// ◈ === human → human readable » string
	public static function human($time)
	{
		$timestamp = self::isString($time);
		if (self::isTimestamp($timestamp)) {
			return date('F j, Y g:i A', strtotime($time));
		}
		return null;
	}



	// ◈ === dateHTML → ... »
	public static function dateHTML($timestamp = null)
	{
		$timestamp = $timestamp ?? now();
		if (self::isTimestamp($timestamp)) {
			return date('Y-m-d', $timestamp);
		}
	}

}//> end of TimeX