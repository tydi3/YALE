<?php //*** RouteX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\Http;

use Yale\Xeno\Data\StringX;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class RouteX
{
	// ◈ === as »
	public static function as($route = null, $param = [], $absolute = false)
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
		return self:: as($route, $param, $absolute);
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

		return self:: as($route, [], $absolute);
	}



	// ◈ === isGroupAuth » is route considered part of auth?
	public static function isGroupAuth($route = null)
	{
		$route = self:: as();
		// dd($route);
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
			$title = self:: as();
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


}//> end of class ~ RouteX