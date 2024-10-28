<?php //*** ImgX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\File;

use Illuminate\Support\Facades\Auth;

class ImgX
{
	// ◈ === profile »
	public static function profile($img = 'auth')
	{
		if ($img === 'auth' && Auth::check()) {
			return Auth::user()->profile_photo_url;
		}
		return '/storage/profile-photos/404.png';
	}



	// ◈ === signature »
	public static function signature($signature = null, $public = true)
	{
		if ($signature === 'auth' && Auth::check() && !empty(Auth::user()->signature)) {
			$signature = Auth::user()->signature;
		} else {
			$signature = 'signature/none.png';
		}

		if (!empty($signature) && FileX::inStorage($signature, $public)) {
			$signature = FileX::signature($signature, $public);
		} else {
			$signature = '/storage/signature/404.png';
		}

		return $signature;
	}

}//> end of class ~ ImgX