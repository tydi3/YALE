<?php //*** RecordX ~ class » Yaic™ Library for Laravel © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace App\Yaic\Tydi\Data;

use App\Yaic\Orig\Is;

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