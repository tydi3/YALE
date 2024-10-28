<?php //*** CollectionX ~ class » Yaic™ Library for Laravel © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace App\Yaic\Tydi\Data;

use App\Yaic\Orig\Is;
use App\Yaic\Tydi\Data\ArrayX;
use App\Yaic\Tydi\Data\StringX;
use Illuminate\Support\Collection;

class CollectionX
{
	// ◈ === is »
	public static function is($var)
	{
		return Is::collection($var);
	}



	// ◈ === make »
	public static function make($var)
	{
		$collection = Collection::make($var);
		if (self::is($collection)) {
			return $collection;
		}
		return false;
	}



	// ◈ === toArray »
	public static function toArray($collection)
	{
		if (self::is($collection)) {
			$data = $collection->toArray();
			if (ArrayX::isMultiWithOne($data)) {
				return $data[0];
			}
			return $data;
		}
		return false;
	}



	// • ==== isOkay → handle checks for collection - model » boolean
	public static function isOkay($result)
	{
		if (is_numeric($result)) {
			if ($result > 0) {
				return true;
			}
		} elseif ($result !== null && $result !== false) {
			return true;
		} elseif ($result instanceof Collection) {
			if ($result->isNotEmpty()) {
				return true;
			}
		}
		return false;
	}

}//> end of class ~ CollectionX