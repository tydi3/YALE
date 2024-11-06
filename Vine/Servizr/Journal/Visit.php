<?php //*** Visit ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Vine\Servizr\Journal;

use Illuminate\Http\Request;
use Yale\Xeno\Data\GenerateX;
use Yale\Vine\Modelizr\Journal\Visit as VisitModelizr;
use Yale\Vine\Utilizr\Session as SessionUtilizr;

class Visit
{
	// ◈ === make »
	public static function make(Request $request, array $param = [])
	{
		$data = self::toCreate($request, $param);
		// TODO: ensure $data is clean & safe
		// TODO: implement try and catch exceptions

		return VisitModelizr::create($data);
	}



	// ◈ === toCreate »
	private static function toCreate(Request $request, array $param = [])
	{
		// • session token identifier
		if (!session()->has('oSessionToken')) {
			session(['oSessionToken' => GenerateX::token()]);
		}
		$oSessionToken = session('oSessionToken');

		// • route name or uri
		$routeObj = $request->route();
		$route = callObjectMethodX($routeObj, 'getName');
		if (empty($route)) {
			$route = callObjectMethodX($routeObj, 'uri');
		}

		// • session id
		if (!empty($param['osession'])) {
			$osession = $param['osession'];
		} else {
			$osession = session()->getId();
		}

		// • parameter
		$param['method'] = !empty($param['method']) ? $param['method'] : $request->method();
		$param['route'] = !empty($param['route']) ? $param['route'] : $route;
		$param['token'] = !empty($param['token']) ? $param['token'] : $oSessionToken;
		$param['device'] = !empty($param['device']) ? $param['device'] : $request->header('User-Agent');
		$param['ip'] = !empty($param['ip']) ? $param['ip'] : $request->ip();

		// SALIENT: resolves [integrity constraint violation]
		if (self::safeToCreateWithSession($param['token'], $osession)) {
			$param['osession'] = $osession;
		}

		//TODO: Implement OS & ISP check (only if IP isn't already stored)

		return $param;
	}



	// ◈ === safeToCreate »
	private static function safeToCreateWithSession($token, $session)
	{
		if (!SessionUtilizr::hasID($session)) {
			return false;
		}

		$tokenCount = VisitModelizr::oCountByValue('token', $token);
		if ($tokenCount < 1) {
			return false;
		}

		return true;
	}



}//> end of class ~ Visit