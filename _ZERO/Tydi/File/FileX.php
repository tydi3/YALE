<?php //*** FileX ~ class » Yaic™ Library for Laravel © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace App\Yaic\Tydi\File;

use App\Yaic\Anci\PathX;
use App\Yaic\Anci\DebugX;
use App\Yaic\Tydi\Data\StringX;
use App\Yaic\Tydi\Maker\RandomX;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;

class FileX
{
	// ◈ === name »
	public static function name()
	{
		return RandomX::filename();
	}



	// ◈ === exist »
	public static function isPublic($file)
	{
		$path = PathX::public($file);
		return file_exists($path);
	}



	// ◈ === isBlade »
	public static function isBlade($blade)
	{
		if (View::exists($blade)) {
			return true;
		}
		return false;
	}



	// ◈ === inStorage »
	public static function inStorage($file, $public = true)
	{
		if ($public) {
			return Storage::disk('public')->exists($file);
		}
		return Storage::exists($file);
	}



	// ◈ === signature »
	public static function signature($file, $public = true)
	{
		return Storage::url($file);
	}



	// ◈ === is »
	public static function is($file)
	{
		if (File::exists($file)) {
			$fileIs = realpath($file);
			if ($file !== $fileIs) {
				return DebugX::fileInconsistency($file, $fileIs);
			}
			return $file;
		}
		return false;
	}



	// ◈ === isWire »
	public static function isWire($component, &$wireComponent = null)
	{
		$component = StringX::swap($component, '/', '.');
		$component = StringX::toCamelCase($component, '.', false);
		if (StringX::contain($component, '-')) {
			$component = ucwords($component, '-');
			$component = StringX::swap($component, '-', '');
		}
		$component = ucfirst($component);
		$component = StringX::swap($component, '.', DIRECTORY_SEPARATOR);

		$wireComponent = 'App\\Livewire\\' . $component;
		$component = PathX::app('Livewire' . DIRECTORY_SEPARATOR . $component . '.php');
		return self::is($component);
	}



	// ◈ === wire »
	public static function wire($component, $directory = null, $type = null)
	{
		if (!empty($directory)) {
			$component = $directory . '.' . $component;
		}
		if (in_array($type, ['widget', 'page', 'shard'])) {
			$component = $type . '.' . $component;
		}
		$component = StringX::swap($component, '/', '.');
		$wire = null;
		if (!self::isWire($component, $wire)) {
			return DebugX::wire404(file: $component, wire: $wire);
		}
		return $component;
	}



	// ◈ === wireShard »
	public static function wireShard($component, $directory = null)
	{
		return self::wire($component, $directory, 'shard');
	}



	// ◈ === blade » blade
	public static function blade($component, $type = null)
	{
		if (in_array($type, ['widget', 'page', 'shard'])) {
			$component = $type . '.' . $component;
		}
		return StringX::swap($component, '/', '.');
	}



	// ◈ === widget »
	public static function widget($component)
	{
		return self::blade($component, 'widget');
	}



	// ◈ === page »
	public static function page($component)
	{
		return self::blade($component, 'page');
	}



	// ◈ === shard »
	public static function shard($component, $path = null)
	{
		if (!empty($path)) {
			$component = "{$path}." . $component;
		}
		return self::blade($component, 'shard');
	}



	// ◈ === format »
	private static function format($file, $append = null)
	{
		if ($append === 'blade' && StringX::notEndWith($file, '.blade.php')) {
			$file .= '.blade.php';
		} elseif ($append === 'php' && StringX::notEndWith($file, '.php')) {
			$file .= '.php';
		}
		return $file;
	}

}//> end of class ~ FileX