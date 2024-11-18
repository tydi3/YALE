<?php //*** FileX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\File;

use Yale\Anci\PathX;
use Yale\Anci\DebugX;
use Yale\Xeno\Data\StringX;
use Yale\Xeno\Data\RandomX;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;

class FileX
{
	// ◈ === exist »
	public static function exist($file)
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



	// ◈ === is »
	public static function is($file = null)
	{
		if (!empty($file)) {
			return self::exist($file);
		}
		return new IsX();
	}



	// ◈ === in »
	public static function in()
	{
		return new InX();
	}



	// ◈ === name » generate filename
	public static function name($extension = null)
	{
		$name = RandomX::filename();
		if (!empty($extension)) {
			$name .= '.' . $extension;
		}
		return $name;
	}



	// ◈ === storage »
	public static function storage($file)
	{
		return Storage::url($file);
	}



	// ◈ === blade » return blade view name
	public static function blade($blade, $directory = null, $type = null)
	{
		if (!empty($directory)) {
			$blade = $directory . '.' . $blade;
		}
		if (in_array($type, ['page', 'shard', 'widget'])) {
			$blade = $type . '.' . $blade;
		}
		return StringX::swap($blade, '/', '.');
	}



	// ◈ === page » as blade name
	public static function page($blade, $directory = null)
	{
		return self::blade($blade, $directory, 'page');
	}



	// ◈ === shard » as blade name
	public static function shard($blade, $directory = null)
	{
		return self::blade($blade, $directory, 'shard');
	}



	// ◈ === widget » as blade name
	public static function widget($blade, $directory = null)
	{
		return self::blade($blade, $directory, 'widget');
	}



	// ◈ === wire » livewire component class file
	public static function wire($component = null, $check = true)
	{
		if (!empty($component)) {
			$component = StringX::swap($component, '/', '.');
			$component = StringX::camelCase($component, '.', false);
			if (StringX::contain($component, '-')) {
				$component = ucwords($component, '-');
				$component = StringX::swap($component, '-', '');
			}
			$component = ucfirst($component);
			$component = StringX::swap($component, '.', DIRECTORY_SEPARATOR);
			$component = PathX::app('Livewire' . DIRECTORY_SEPARATOR . $component . '.php');

			if ($check === true) {
				return IsX::wire($component);
			}
			return self::component($component);
		}

		return new class {

			// » page
			public function page($component = null, $directory = null, $check = true)
			{
				$component = FileX::page($component, $directory);
				return FileX::wire($component, $check);
			}


			// » shard
			public function shard($component = null, $directory = null, $check = true)
			{
				$component = FileX::shard($component, $directory);
				return FileX::wire($component, $check);
			}


			// » widget
			public function widget($component = null, $directory = null, $check = true)
			{
				$component = FileX::widget($component, $directory);
				return FileX::wire($component, $check);
			}

		};
	}



	// ◈ === component »
	public static function component($component)
	{
		$component = StringX::cropEnd($component, '.php');
		$component = StringX::cropEnd($component, '.blade');

		if (StringX::contain($component, DIRECTORY_SEPARATOR . 'Livewire' . DIRECTORY_SEPARATOR)) {
			$component = StringX::afterAs($component, 'Livewire' . DIRECTORY_SEPARATOR);
		}
		$component = StringX::swapDS($component, '.');
		$component = StringX::swapPS($component, '.');
		return strtolower($component);
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