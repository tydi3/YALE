<?php //*** TemplateX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Anci;

use Yale\Xeno\File\FileX;
use Yale\Xeno\Data\StringX;
use function PHPUnit\Framework\isTrue;

class TemplateX
{
	// ◈ property
	private static $init = false;
	private static $theme;



	// ◈ === check »
	public static function check($file, $flag404 = true){
		$blade = FileX::is()->blade($file);
		if($blade){
			return $file;
		}
		if ($flag404 === true) {
			DebugX::blade404($file);
		}
		return false;
	}



	// ◈ === theme »
	public static function theme($file = null)
	{
		return self::path('theme', $file);
	}



	// ◈ === page »
	public static function page($file = null)
	{
		return self::path('page', $file);
	}



	// ◈ === layout »
	public static function layout($file = null)
	{
		return self::path('layout', $file);
	}



	// ◈ === bit »
	public static function bit($file = null)
	{
		return self::layout('bit.' . $file);
	}



	// ◈ === region »
	public static function region($file = null)
	{
		return self::layout('region.' . $file);
	}



	// ◈ === piece »
	public static function piece($file = null)
	{
		return self::layout('piece.' . $file);
	}



	// ◈ === silo »
	public static function silo($file = null)
	{
		return self::piece('silo.' . $file);
	}



	// ◈ === collop »
	public static function collop($file = null, $module = null, $check = null)
	{
		if (!empty($module)) {
			$file = $module . '.' . $file;
		}
		$collop = self::path('collop.' . $file);
		if ($check) {
			return self::check($collop, $check);
		}
		return $collop;
	}



	// ◈ === form »
	public static function form($file = null)
	{
		return self::collop('form.' . $file);
	}



	// ◈ === slice »
	public static function slice($file = null)
	{
		return self::layout('slice.' . $file);
	}



	// ◈ === slab »
	public static function slab($file, $component = null, $path = 'collop')
	{
		$file = 'slab.' . $file;
		if (!empty($component)) {
			$file = $component . '.' . $file;
		}
		if (!empty($path)) {
			$paths = ['page', 'collop'];
			if (in_array($path, $paths)) {
				$file = self::{$path}($file);
			}
		}
		return $file;
	}



	// ◈ === nav »
	public static function nav($file = null)
	{
		if ($file) {
			return self::piece('nav.' . $file);
		}

		return new class extends TemplateX {

			// ~ bottom »
			public function bottom($file = null)
			{
				return self::piece('nav.bottom.' . $file);
			}

			// ~ primary »
			public function primary($file = null)
			{
				return self::piece('nav.primary.' . $file);
			}

			// ~ secondary »
			public function secondary($file = null)
			{
				return self::piece('nav.secondary.' . $file);
			}

			// ~ sidebar »
			public function sidebar($file = null)
			{
				return self::piece('nav.sidebar.' . $file);
			}

			// ~ topbar »
			public function topbar($file = null)
			{
				return self::piece('nav.topbar.' . $file);
			}

			// ~ header »
			public function header($file = null)
			{
				return self::piece('nav.header.' . $file);
			}
		};
	}



	// ◈ === path »
	protected static function path($path, $file = null)
	{
		self::init();
		$location = self::$theme;
		if (in_array($path, ['page', 'layout'])) {
			$location .= ".{$path}.";
		} elseif ($path != 'theme') {
			// NOTE: repetitive [makeshift] - feature is TODO
			$location .= '.' . $path;
		}
		$location .= $file;
		return self::format($location);
	}



	// ◈ === format »
	private static function format($path)
	{
		if (!empty($path)) {
			$path = StringX::swap($path, '/', '.');
		}
		return $path;
	}



	// ◈ === init »
	private static function init()
	{
		if (!self::$init) {
			self::$theme = strtolower(EnvX::project('theme'));
			self::$init = true;
		}
	}

}//> end of class ~ TemplateX