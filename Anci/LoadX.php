<?php //*** LoadX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Anci;

use Yale\Anci\PathX;

class LoadX
{
	// ◈ === file »
	public static function file(string $file, bool $check = false)
	{
		if (is_file($file)) {
			require $file;
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
		if ($path === 'zero') {
			$path = PathX::zero('route');
			$files = [
				$path . 'api.php',
				$path . 'app.php',
				$path . 'site.php',
			];
			return self::files($files, false);
		}

		if ($path === 'debug') {
			$path = PathX::debug('route');
			return self::directory($path, false, 'php');
		}
	}

}//> end of class ~ LoadX