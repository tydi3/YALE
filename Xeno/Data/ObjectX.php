<?php //*** ObjectX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\Data;

use Yale\Orig\Can;

class ObjectX
{
	// ◈ === is » .. → boolean
	public static function is($object)
	{
		return is_object($object);
	}



	// ◈ === empty » is object & empty → boolean
	public static function empty(&$var)
	{
		return is_object($var) && empty(get_object_vars($var));
	}



	// ◈ === append » ... → boolean
	public static function append(&$object, $param)
	{
		if (Can::iterate($param)) {
			if (empty($object)) {
				$object = new \stdClass();
			} elseif (!is_object($object)) {
				return false;
			}
			foreach ($param as $key => $value) {
				$object->{$key} = $value;
			}
			return true;
		}
		return false;
	}



	// ◈ === toArray »
	public static function toArray($object){
		return (array)$object;
	}


}//> end of class ~ ObjectX