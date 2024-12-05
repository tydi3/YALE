<?php //*** EleganceX ~ abstract » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Concept\Abstract;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yale\Concept\Trait\Model as ModelX;
use Yale\Orig\Is;

// use Illuminate\Support\Facades\Log;
// use Illuminate\Database\QueryException;

abstract class EleganceX extends Eloquent
{
	// ◈ traits
	use HasFactory;
	use SoftDeletes;
	use ModelX;



	// ◈ constants
	const CREATED_AT = 'created';
	const UPDATED_AT = 'updated';
	const DELETED_AT = 'deleted';


	// ◈ property
	protected $dates = ['deleted'];



	// ◈ === oColumnID » determine column from id's value
	protected static function oColumnID($id, &$column)
	{
		$length = strlen($id);
		if ($length === 20) {
			$column = 'puid';
		}
	}



	// ◈ === oColumn »
	protected static function oColumn(array|string $columns = ['*'])
	{
		$columns = !empty($columns) ? $columns : self::$columns;
		$columns = is_array($columns) ? $columns : [$columns];
		return $columns;
	}



	// ◈ === oArray »
	protected static function oArray($result)
	{
		if (Is::model($result) || Is::collection($result)) {
			return $result->toArray();
		} elseif (empty($result)) {
			return [];
		}
		return $result;
	}

}//> end of abstract ~ EleganceX