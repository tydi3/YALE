<?php //*** UpdateX ~ trait » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Concept\Trait\Elegance;

trait UpdateX
{
	// ◈ === oFindByID »
	public static function oUpdateByID(int|string $id, array $input)
	{
		$filterColumn = 'id';
		self::oColumnID($id, $filterColumn);
		return static::where($filterColumn, $id)->update($input);
	}



	// ◈ === oUpdateByPuid »
	public static function oUpdateByPuid($puid, array $input)
	{
		return static::where('puid', $puid)->update($input);
	}

}//> end of trait ~ UpdateX