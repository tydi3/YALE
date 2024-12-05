<?php //*** DataX ~ trait » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Wire\Model;

trait DataX
{
	// ◈ === listing »
	public static function listing(array|string $columns = [], $sortOrder = 'desc', $sortColumn = 'id')
	{
		if (empty($columns) && isset(self::$columns)) {
			$columns = self::$columns;
		}
		$result = self::oAll($columns, $sortOrder, $sortColumn);
		return self::oArray($result);
	}



	// ◈ === detail »
	public static function detail(int|string $id, array|string $columns = [])
	{
		if (empty($columns) && isset(self::$columns)) {
			$columns = self::$columns;
		}
		$result = self::oFindByID($id, $columns);
		return self::oArray($result);
	}

}//> end of trait ~ DataX
