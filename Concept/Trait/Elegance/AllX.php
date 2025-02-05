<?php //*** AllX ~ trait » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Concept\Trait\Elegance;

trait AllX
{
	// ◈ === oEvery »
	public static function oEvery($sortOrder = 'desc')
	{
		return static::orderBy('id', $sortOrder)->get();
	}



	// ◈ === oAll »
	public static function oAll(array|string $columns = ['*'], $sortOrder = 'desc', $sortColumn = 'id', $author = false)
	{
		$query = static::query();
		if ($author === true) {
			$query->with('author')->select(array_merge(self::oColumn($columns), ['oauthor']));
		} else {
			$query->select(self::oColumn($columns));
		}
		$query->orderBy($sortColumn, $sortOrder);
		return $query->get();
		// return static::query()->select(self::oColumn($columns))->orderBy($sortColumn, $sortOrder)->get();#
	}

}//> end of trait ~ AllX