<?php //*** InX ~ FileX » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\File;

use Illuminate\Support\Facades\Storage;

class InX
{
	// ◈ === storage »
	public static function storage($file, $public = true)
	{
		if ($public) {
			return Storage::disk('public')->exists($file);
		}
		return Storage::exists($file);
	}

}//> end of class ~ InX