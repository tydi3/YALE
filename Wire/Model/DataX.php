<?php //*** DataX ~ trait » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Wire\Model;

trait DataX
{
	// ◈ === getFields »
	public static function getFields()
	{
		if (!empty(self::$columns)) {
			return self::$columns;
		}
		return [];
	}



	// ◈ === listing »
	public static function listing(array|string $columns = [], $sortOrder = 'desc', $sortColumn = 'id', $author = false)
	{
		if (empty($columns) && isset(self::$columns)) {
			$columns = self::$columns;
		}
		$result = self::oAll($columns, $sortOrder, $sortColumn, $author);
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



	// ◈ === modify »
	public static function modify(int|string $id, array $input)
	{
		return self::oUpdateByID($id, $input);
	}

}//> end of trait ~ DataX
