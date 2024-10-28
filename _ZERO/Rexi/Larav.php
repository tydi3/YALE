<?php //*** Laravel » Tydi™ Framework © 2024 ∞ AO™ • @osawereAO • www.osawere.com ∞ Apache License ***//
namespace App\Spry;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Spry\StringX;

class Larav
{

	// • property





	// • ==== isAuth → ... »
	public static function isAuth()
	{
		return Auth::check();
	}





	// • ==== routeIs → ... »
	public static function routeIs($route = null)
	{
		if (is_null($route)) {
			return Route::currentRouteName();
		} elseif (!empty($route)) {
			$activeRoute = Route::currentRouteName();
			if (is_string($route) && ($route === $activeRoute)) {
				return true;
			} elseif (is_array($route) && in_array($activeRoute, $route)) {
				return true;
			}
		}
		return false;
	}





	// • ==== routeTo → ... »
	public static function routeTo($routeName)
	{
		return redirect()->route($routeName);
	}





	// • ==== isAuthGoTo → ... »
	public static function isAuthGoTo($onTrue, $onFalse = null)
	{
		if (self::isAuth()) {
			return self::routeTo($onTrue);
		}
		if (!empty($onFalse)) {
			return self::routeTo($onFalse);
		}
	}






	// • ==== uriBeginWith → ... »
	public static function uriBeginWith(string $path, Request $request = null)
	{
		if ($request === null) {
			$request = request();
		}
		$uri = $request->path();
		return StringX::beginWith($uri, $path);
	}

}//> end of Laravel