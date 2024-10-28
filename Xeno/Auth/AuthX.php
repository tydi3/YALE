<?php //*** AuthX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\Auth;

use Yale\Xeno\Data\StringX;
use Illuminate\Support\Facades\Auth;

class AuthX
{
	// ◈ property
	private static $init = false;
	protected static $is = false;
	protected static $auth;



	// ◈ === init »
	protected static function init()
	{
		if (!self::$init) {
			$auth = Auth::user();
			if ($auth) {
				self::$auth = $auth;
				self::$is = true;
			}
			self::$init = true;
		}
	}



	// ◈ === is »
	public static function is()
	{
		self::init();
		return self::$is;
	}



	// ◈ === name »
	public static function name()
	{
		$name = 'anonymous';
		if (self::is()) {
			$name = self::$auth->name;
		}
		return ucwords($name);
	}



	// ◈ === firstName »
	public static function firstName()
	{
		$name = self::name();
		return StringX::beforeAs($name, ' ');
	}



	// ◈ === lastName »
	public static function lastName()
	{
		$name = self::name();
		return StringX::afterLast($name, ' ');
	}



	// ◈ === otherName »
	public static function otherName()
	{
		// NOTE: Non-Tested Code
		$name = self::name();
		$hasFirstAndLast = StringX::surround($name, ' ');
		if ($hasFirstAndLast) {
			$name = StringX::swapFirst($name, self::firstName());
			if (!empty($name)) {
				$name = StringX::afterLast($name, self::lastName());
			}
			if (!empty($name)) {
				return $name;
			}
		}
		return false;
	}



	// ◈ === moniker »
	public static function moniker($length = null)
	{
		$moniker = self::name();
		return $moniker;
	}



	// ◈ === dp »
	public static function dp()
	{
		$dp = 'profile-photos/anonymous.png';
		if (self::is()) {
			$dp = self::$auth->dp ?? self::$auth->profile_photo_url;
		}
		return $dp;
	}

}//> end of class ~ AuthX