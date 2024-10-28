<?php //*** ModelQ » Tydi™ Library for Laravel © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//
namespace App\Zero\Helper\Trait;

use Illuminate\Database\QueryException;


trait ModelQ
{

	// • constants
	const CREATED_AT = 'created';
	const UPDATED_AT = 'updated';
	const DELETED_AT = 'deleted';





	// • property
	protected $dates = ['deleted'];





	// • ==== lastRow → ... » []
	public static function lastRow($withTrashed = false)
	{
		if ($withTrashed) {
			return parent::latest()->first();
		}
		return parent::withTrashed()->latest()->first();
	}





	// • ==== lastID → ... » []
	public static function lastID($id = 'id', $withTrashed = false)
	{
		$record = self::lastRow($withTrashed);
		if (isset($record->{$id})) {
			return $record->{$id};
		}
		return null;
	}





	// • ==== lastSN → ... » []
	public static function lastSN($column = 'guid', $withTrashed = false)
	{
		$record = self::lastRow($withTrashed);
		if (isset($record->{$column})) {
			return $record->{$column};
		}
		return null;
	}





	// • ==== findBy → ... » []
	public static function findBy($field, $value, $column = null)
	{
		if (is_array($column)) {
			$record = parent::select($column)->where($field, $value)->first();
		} else {
			$record = parent::where($field, $value)->first();
			if ($record && $column && is_string($column) && isset($record->$column)) {
				$record = $record->$column;
			}
		}
		return $record ?? null;
	}





	// • ==== findID → ... » []
	public static function findID($id, $column = null)
	{
		$record = self::find($id);
		return $record;
	}





	// • ==== findGuid → ... » []
	public static function findGuid($puid, $column = null, $field = 'guid')
	{
		return self::findBy($field, $puid, $column);
	}





	// • ==== findPuid → ... » []
	public static function findPuid($puid, $column = null, $field = 'puid')
	{
		return self::findBy($field, $puid, $column);
	}





	// • ==== findSuid → ... » []
	public static function findSuid($puid, $column = null, $field = 'suid')
	{
		return self::findBy($field, $puid, $column);
	}





	// • ==== findTuid → ... » []
	public static function findTuid($puid, $column = null, $field = 'tuid')
	{
		return self::findBy($field, $puid, $column);
	}





	// • ==== findAuthor → ... » []
	public static function findAuthor($puid, $column = null, $field = 'author')
	{
		return self::findBy($field, $puid, $column);
	}





	// • ==== create → ... » []
	public static function create($data){
		try {
			parent::create($data);
		} catch (QueryException $e) {
		}
	}




}//> end of ModelQ