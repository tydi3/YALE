<?php //*** LoadX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Anci;

use Yale\Anci\DebugX;
use Yale\Xeno\Data\StringX;

class LoadX
{
	// ◈ === file »
	public static function file(string $file, bool $check = false)
	{
		if (is_file($file)) {
			require $file;
		} elseif ($check) {
			return DebugX::oversight('LoadX::File', 'File Unavailable',$file);
		}
	}



	// ◈ === files »
	public static function files(array $files, bool $check = false)
	{
		if (is_array($files)) {
			foreach ($files as $file) {
				self::file($file, $check);
			}
		}
	}



	// ◈ === directory » file/files in a directory
	public static function directory($directory, $check = false, $extension = 'php')
	{
		if (is_dir($directory)) {
			$files = glob($directory . '*.' . $extension);
			self::files($files, $check);
		}
	}



	// ◈ === router »
	public static function router(string $path)
	{
		if (StringX::beginWith($path, 'zero')) {
			$directory = PathX::zero('route');
			$files = [
				'api' => $directory . 'api.php',
				'app' => $directory . 'app.php',
				'site' => $directory . 'site.php',
			];
			if (StringX::endWith($path, '-api')) {
				unset($files['app'], $files['site']);
			} elseif (StringX::endWith($path, '-app')) {
				unset($files['api'], $files['site']);
			} elseif (StringX::endWith($path, '-site')) {
				unset($files['api'], $files['app']);
			} elseif (StringX::endWith($path, '-web')) {
				unset($files['api']);
			}
			return self::files($files, false);
		}

		if ($path === 'debug') {
			$path = PathX::debug('route');
			return self::directory($path, false, 'php');
		}

		// TODO: Implement check for $path to return appropriately

		return $path;
	}



	// ◈ === routeFile »
	public static function routeFile($file, $path = 'zero')
	{
		if ($path === 'zero') {
			$path = PathX::zero('route');
		}
		$file = $path . $file;
		if (!StringX::endWith($file, '.php')) {
			$file .= '.php';
		}
		return self::file($file, true);
	}

}//> end of class ~ LoadX