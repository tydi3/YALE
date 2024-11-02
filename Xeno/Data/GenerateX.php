<?php //*** GenerateX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\Data;

class GenerateX
{
	// ◈ === serial » generate sequential serial number
	public static function serial($lastSN = null, $prefix = null)
	{
		if (!$prefix) {
			$prefix = date('Ym');
		}
		if (!empty($prefix)) {
			$prefix .= '-';
		}

		if (!$lastSN) {
			$lastSN = '000';
		} else {
			$lastSN = StringX::afterAs($lastSN, '-');
		}

		return $prefix . str_pad((int) $lastSN + 1, 4, '0', STR_PAD_LEFT);
	}



	// ◈ === token » 30 alpha numeric characters
	public static function token($length = 30)
	{
		return RandomX::token($length);
	}

}//> end of class ~ GenerateX