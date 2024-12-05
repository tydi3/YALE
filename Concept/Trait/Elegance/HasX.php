<?php //*** HasX ~ trait » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Concept\Trait\Elegance;

trait HasX
{
	// ◈ === oHasPuid »
	public static function oHasPuid($puid)
	{
		return static::where('puid', $puid)->exists();
	}

}//> end of trait ~ HasX