<?php //*** DataX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno;

use Yale\Orig\Is;

class DataX
{
	// ◈ property
	private static $init = false;
	private static $model;



	// ◈ === init »
	public static function init($model = null)
	{
		if (!empty($model) && Is::model($model)) {
			self::$model = new $model;
			self::$init = true;
		}
	}

}//> end of class ~ DataX