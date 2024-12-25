<?php //*** RouteX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\Http;

use Yale\Xeno\Data\StringX;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class RouteX
{
	// ◈ === format »
	public static function format($route = null, $param = [], $absolute = false)
	{
		if (!empty($route)) {
			if (Route::has($route)) {
				return route($route, $param, $absolute);
			}

			// TODO: improve link handling
			if (!str_starts_with($route, '/')) {
				$route = '/' . $route;
			}
		}


		// • Route for active uri
		else {
			$route = Route::currentRouteName();
			if (empty($route)) {
				$route = request()->getRequestUri();
			}
		}

		return $route;
	}



	// ◈ === current »
	public static function current($return = null)
	{
		if ($return === 'name') {
			return Route::currentRouteName();
		} elseif ($return === 'url') {
			return url()->current();
		} else {
			return Route::current();
		}
	}



	// ◈ === expired »
	public static function expired($route = 'login', $param = ['status' => 'session-expired'], $absolute = false)
	{
		return self::format($route, $param, $absolute);
	}



	// ◈ === wire »
	public static function wire($action = null, $component = null, $absolute = false)
	{
		$route = '';
		$wireRoute = Session::get('wireRoute');
		if (!empty($wireRoute)) {
			if (StringX::contain($wireRoute, '-')) {
				if (empty($component)) {
					$component = StringX::before($wireRoute, '-');
				}
			}
		}

		if (!empty($component)) {
			$route .= $component;
		}

		if (!empty($action)) {
			if (!empty($action)) {
				$route .= '-';
			}
			$route .= $action;
		}

		if ($route === $wireRoute) {
			// TODO: do refresh instead
		}

		return self::format($route, [], $absolute);
	}



	// ◈ === isGroupAuth » is route considered part of auth?
	public static function isGroupAuth($route = null)
	{
		$route = self::format();
		if (!empty($route)) {
			$route = StringX::cropBegin($route, '/');
			$routes = 'register | login | logout | password.request';
			return StringX::contain($routes, $route);
		}
		return false;
	}



	// ◈ === title »
	public static function title($title = null)
	{
		if (!$title) {
			$title = self::format();
			$title = StringX::cropBegin($title, '/');

			if (self::isGroupAuth()) {
				if (strtolower($title) === 'password.request') {
					$title = 'lost password';
				}
				$title = StringX::beforeAs($title, '.');
				$title = ucwords($title);
			}
		}
		return ucfirst($title);
	}



	// ◈ === wireNav »
	public static function wireNav($route = null, $action = null)
	{
		$nav = $route;
		if (!empty($route)) {
			$nav = StringX::beforeAs($route, '.');
			if (!empty($action)) {
				if (StringX::notEndWith($nav, '.' . $action)) {
					$nav .= '.' . $action;
				}
			}
		}
		return $nav;
	}



	// ◈ === wireNavDetail »
	public static function wireNavDetail($route = null)
	{
		return self::wireNav($route, 'detail');
	}



	// ◈ === wireGo »
	public static function wireGo($route, array|string|null $param = null, $absolute = false)
	{
		if (is_string($param) && !empty($param)) {
			$param = ['id' => $param];
		}
		return self::format($route, $param, $absolute);
	}



	// ◈ === wireGoListing »
	public static function wireGoListing($route)
	{
		$route = self::wireNav($route, 'listing');
		return self::wireGo($route, []);
	}



	// ◈ === wireGoDetail »
	public static function wireGoDetail($route, $id)
	{
		$route = self::wireNav($route, 'detail');
		return self::wireGo($route, $id);
	}

}//> end of class ~ RouteX