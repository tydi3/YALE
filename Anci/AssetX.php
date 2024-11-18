<?php //*** AssetX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Anci;

use Yale\Xeno\File\FileX;
use Yale\Xeno\Data\StringX;

class AssetX
{
	// ◈ property
	private static $init = false;
	protected static $theme;
	public static $DS = DIRECTORY_SEPARATOR;



	// ◈ === path »
	public static function path($file, $check = false, $trimBase = true)
	{
		self::init();
		if ($check === true) {
			if (!self::isFile($file)) {
				return false;
			}
		}
		$asset = asset(self::$theme . '/' . $file);
		$baseurl = url('/');
		if ($trimBase === true && !empty($baseurl)) {
			return StringX::cropBegin($asset, $baseurl);
		}
		return $asset;
	}



	// ◈ === logo »
	public static function logo($file, $check = false, $trimBase = true)
	{
		return self::path('logo/' . $file, $check, $trimBase);
	}



	// ◈ === favicon »
	public static function favicon($file, $check = false)
	{
		return self::path('favicon/' . $file, $check);
	}



	// ◈ === image »
	public static function image($file, $check = false)
	{
		// TODO: make provision for broken image
		return self::path('image/' . $file, $check);
	}



	// ◈ === media »
	public static function media($file, $check = false)
	{
		return self::path('media/' . $file, $check);
	}



	// ◈ === svg »
	public static function svg($file, $check = false)
	{
		if (StringX::notEndWith($file, '.svg')) {
			$file .= '.svg';
		}
		return self::media('svg/' . $file, $check);
	}



	// ◈ === png »
	public static function png($file, $check = false)
	{
		if (StringX::notEndWith($file, '.png')) {
			$file .= '.png';
		}
		return self::media('png/' . $file, $check);
	}



	// ◈ === js »
	public static function js($file, $check = false)
	{
		return self::path('js/' . $file, $check);
	}



	// ◈ === css »
	public static function css($file, $check = false)
	{
		return self::path('css/' . $file, $check);
	}



	// ◈ === vendor »
	public static function vendor($file, $check = false)
	{
		return self::path('vendor/' . $file, $check);
	}



	// ◈ === fontawesome »
	public static function fontawesome($file, $check = false)
	{
		return self::vendor('fontawesome/' . $file, $check);
	}



	// ◈ === fa » fontawesome css or js
	public static function fa($file, $extension, $check = false)
	{
		if (StringX::notEndWith($file, '.' . $extension)) {
			$file .= '.' . $extension;
		}
		return self::fontawesome($extension . '/' . $file, $check);
	}



	// ◈ === href »
	public static function href($href, $tag = null)
	{
		if ($tag === 'vendor') {
			$href = self::vendor($href);
		} elseif ($tag === 'fontawesome') {
			$href = self::fontawesome($href);
		} elseif ($tag === 'css') {
			$href = self::css($href);
			if (StringX::notEndWith($href, '.css')) {
				$href .= '.css';
			}
		} elseif ($tag === 'js') {
			$href = self::js($href);
			if (StringX::notEndWith($href, '.js')) {
				$href .= '.js';
			}
		}
		return $href;
	}



	// ◈ === isFile »
	public static function isFile($file)
	{
		self::init();
		$file = self::$DS . self::$theme . self::$DS . StringX::swap($file, '/', self::$DS);
		return FileX::is()->public($file);
	}



	// ◈ === init »
	private static function init()
	{
		if (!self::$init) {
			self::$theme = strtolower(EnvX::project('theme'));
			self::$init = true;
		}
	}

}//> end of class ~ AssetX