<?php //*** CountX ~ trait » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Concept\Trait\Elegance;

trait CountX
{
	// ◈ === oCountByValue » using a column's value count record
	public static function oCountByValue($column, $value)
	{
		return static::query()->where($column, $value)->count();
	}

}//> end of trait ~ CountX