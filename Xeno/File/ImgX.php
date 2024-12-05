<?php //*** ImgX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\File;

use Yale\Xeno\File\ImgX;
use Yale\Xeno\Data\StringX;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ImgX
{
	// ◈ === asPath »
	public static function asPath($link, $trimStorage = false)
	{
		if (!empty($link)) {
			if (StringX::beginWithAny($link, ['http://', 'https://'])) {
				$position = StringX::occurrenceNth($link, '/', 3);
				$link = StringX::cropBeginNth($link, $position);
			}

			if ($trimStorage === true && StringX::beginWithAny($link, ['/storage/', 'storage/'])) {
				$link = StringX::afterAs($link, 'storage/');
			}
		}
		return $link;
	}



	// ◈ === profile »
	public static function profile($image = null)
	{
		if (!empty($image)) {
			if ($image === 'auth') {
				if (Auth::check()) {
					$image = Auth::user()->profile_photo_url;
				} else {
					$image = null;
				}
			}
			$image = self::asPath($image, true);
			$isFile = FileX::in()->storage($image, true);
			if ($isFile) {
				return FileX::storage($image);
			}
		}
		return FileX::photo('user/no-dp.png');
	}



	// ◈ === auth »
	public static function auth()
	{
		return self::profile('auth');
	}



	// ◈ === signature »
	public static function signature($signature = null, $public = true)
	{
		if ($signature === 'auth' && Auth::check() && !empty(Auth::user()->signature)) {
			$signature = Auth::user()->signature;
		} else {
			$signature = 'signature/none.png';
		}

		if (!empty($signature) && FileX::in()->storage($signature, $public)) {
			$signature = FileX::storage($signature);
		} else {
			$signature = '/storage/signature/404.png';
		}

		return $signature;
	}



	// ◈ === noCover »
	public static function noCover()
	{
		return FileX::photo('user/no-cover.jpg');
	}



	// ◈ === asset »
	public static function asset($theme = true)
	{
		if ($theme === true) {
			$path = EnvX::project('theme');
		}
		$image = $path . '/i' . $image;
	}


}//> end of class ~ ImgX