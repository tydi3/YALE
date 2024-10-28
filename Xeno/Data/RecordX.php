<?php //*** RecordX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\Data;

use Yale\Orig\Is;

class RecordX
{
	// ◈ === array »
	public static function array($record)
	{
		if (Is::collection($record) && $record->isNotEmpty()) {
			return $record->toArray();
		}
		return [];
	}



	// ◈ === object »
	public static function object($record)
	{
		if (Is::collection($record) && $record->isNotEmpty()) {
			return $record;
		}
		return null;
	}


}//> end of class ~ RecordX