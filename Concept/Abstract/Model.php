<?php //*** Model ~ abstract » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Concept\Abstract;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\QueryException;
use Yale\Concept\Trait\Model as TraitX;

abstract class Model extends Eloquent
{
	// ◈ traits
	use HasFactory;
	use SoftDeletes;
	use TraitX;


	// ◈ constants
	const CREATED_AT = 'created';
	const UPDATED_AT = 'updated';
	const DELETED_AT = 'deleted';


	// ◈ property
	protected $dates = ['deleted'];



	// ◈ === oCreateX »
	public static function oCreateX($data)
	{
		try {
			$result = parent::oCreate($data);
		} catch (QueryException $e) {
			// TODO: Log error & handle exception | Move to a handler class
			Log::error('Error::DB->Create: ' . $e->getMessage());
			return false;
		}
		return $result;
	}

}//> end of abstract ~ Model