<?php //*** CreateX ~ trait » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Concept\Trait\Elegance;

trait CreateX
{
	// ◈ === oCreate »
	public static function oCreate($input, $option = null)
	{
		$result = static::create($input);

		if (!$option || $option === 'result') {
			return $result;
		}

		if (is_array($option)) {
			$row['id'] = $result->id;
			foreach ($option as $column) {
				if (isset($result->$column)) {
					$row[$column] = $result->$column;
				}
			}
			return $row;
		}

		if (is_string($option) && isset($result->$option)) {
			return $result->$option;
		}
	}

}//> end of trait ~ CreateX