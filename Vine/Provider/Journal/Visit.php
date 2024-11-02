<?php //*** Visit ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Visit
{
	// ◈ === toCreate »
	public static function toCreate($param = [], Request $request)
	{
		if (!session()->has('oSessionToken')) {
			session(['oSessionToken' => Str::random(80)]);
		}
		$oSessionToken = session('oSessionToken');

		$oRoute = $request->route()->getName();
		if (empty($oRoute)) {
			$oRoute = $request->route()->uri();
		}

		$param['method'] = !empty($param['method']) ? $param['method'] : $request->method();
		$param['route'] = !empty($param['route']) ? $param['route'] : $oRoute;
		$param['token'] = !empty($param['token']) ? $param['token'] : $oSessionToken;
		$param['osession'] = !empty($param['osession']) ? $param['osession'] : session()->getId();
		$param['ip'] = !empty($param['ip']) ? $param['ip'] : $request->ip();
		//TODO: Implement OS & ISP check (only if IP isn't already stored)
		$param['device'] = !empty($param['device']) ? $param['device'] : $request->header('User-Agent');

		return $param;
	}

}//> end of class ~ Visit