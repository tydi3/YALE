<?php //*** PrivilegeX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\Auth;

use Yale\Xeno\Auth\AuthX;

class PrivilegeX
{
	// ◈ property
	private static $privilege;



	// ◈ === init »
	private static function init()
	{
		self::$privilege = AuthX::privilege();
	}



	// ◈ === zero »
	public static function zero()
	{
		self::init();
		if (is_array(self::$privilege) && in_array('ZERO', self::$privilege)) {
			return true;
		}
		return false;
	}



	// ◈ === is »
	public static function is($privilege)
	{
	}





}//> end of class ~ PrivilegeX