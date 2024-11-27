<?php //*** InX ~ FileX » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\File;

use Yale\Xeno\Data\StringX;
use Illuminate\Support\Facades\Storage;

class InX
{
	// ◈ === storage »
	public static function storage($file, $public = true)
	{
		$file = StringX::afterAs($file, 'storage/');
		if ($public) {
			return Storage::disk('public')->exists($file);
		}
		return Storage::exists($file);
	}


	// ◈ === photo »
	public static function photo($file)
	{
		// TODO: implement code
	}


}//> end of class ~ InX