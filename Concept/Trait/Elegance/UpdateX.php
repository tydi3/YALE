<?php //*** UpdateX ~ trait » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Concept\Trait\Elegance;

trait UpdateX
{
	// ◈ === oFindByID »
	public static function oUpdateByID(int|string $id, array $data)
	{
		$filterColumn = 'id';
		self::oColumnID($id, $filterColumn);
		return static::where($filterColumn, $id)->update($data);
	}



	// ◈ === oUpdateByPuid »
	public static function oUpdateByPuid($puid, array $data)
	{
		return static::where('puid', $puid)->update($data);
	}

}//> end of trait ~ UpdateX