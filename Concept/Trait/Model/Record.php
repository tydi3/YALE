<?php //*** Record ~ trait » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Concept\Trait\Model;

trait Record
{
	// ◈ === oAll »
	public static function oAll($sorting = 'desc')
	{
		if ($sorting === 'desc') {
			return static::orderByDesc('id')->get();
		} elseif ($sorting === 'asc') {
			return static::orderByAsc('id')->get();
		}
		return static::orderBy('id')->get();
	}



	// ◈ === oExistByPuid »
	public static function oExistByPuid($puid)
	{
		// 	if (empty($puid)) {
		// 		throw new InvalidArgumentException('PUID cannot be empty.');
		// return false;
		// }
		return static::where('puid', $puid)->exists();
	}



	// ◈ === oFindByPuid »
	public static function oFindByPuid($puid, string|array $columns = ['*'])
	{
		return static::where('puid', $puid)->select($columns)->first();
	}



	// ◈ === oUpdateByPuid »
	public static function oUpdateByPuid($puid, array $data)
	{
		return static::where('puid', $puid)->update($data);
	}

}//> end of trait ~ Record