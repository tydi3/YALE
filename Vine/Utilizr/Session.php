<?php //*** Session ~ utilizr » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Vine\Utilizr;

use Illuminate\Support\Facades\DB;

class Session
{
	// ◈ === hasID »
	public static function hasID($id)
	{
		return DB::table('sessions')->where('id', $id)->exists();
	}

}//> end of utilizr ~ Session