<?php //*** Record ~ trait » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Concept\Trait\Model;

trait Record
{
	// ◈ === oAll »
	public static function oAll($sorting = 'desc')
	{
		if ($sorting === 'desc') {
			return static::orderByDesc('id')->get();
		} elseif ($sorting === 'asc') {
			return static::orderByAsc('id')->get();
		}
		return static::orderBy('id')->get();
	}

}//> end of trait ~ Record