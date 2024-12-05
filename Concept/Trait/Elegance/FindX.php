<?php //*** FindX ~ trait » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Concept\Trait\Elegance;

trait FindX
{
	// ◈ === oFindByPuid »
	public static function oFindByPuid($puid, string|array $columns = ['*'])
	{
		return static::where('puid', $puid)->select($columns)->first();
	}

}//> end of trait ~ FindX