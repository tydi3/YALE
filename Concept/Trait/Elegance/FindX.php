<?php //*** FindX ~ trait » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Concept\Trait\Elegance;

trait FindX
{
	// ◈ === oFindByID »
	public static function oFindByID(int|string $id, array|string $columns = ['*'])
	{
		$filterColumn = 'id';
		self::oColumnID($id, $filterColumn);
		return static::query()->where($filterColumn, $id)->select(self::oColumn($columns))->first();
	}



	// ◈ === oFindByPuid »
	public static function oFindByPuid(int|string $puid, string|array $columns = ['*'])
	{
		return static::where('puid', $puid)->select(self::oColumn($columns))->first();
	}

}//> end of trait ~ FindX