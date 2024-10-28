<?php //*** IpX ~ class » Yaic™ Library for Laravel © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace App\Yaic\Tydi\Http;

use Illuminate\Support\Facades\Http;

class IpX
{
	// ◈ === address » get client ip address →
	public static function ip()
	{
		$request = app('request');
		return $request->ip();
	}




	// ◈ === data » get client isp → string, boolean
	public static function data($ip = null)
	{
		$ip = empty($ip) ? self::ip() : $ip;
		$url = "http://ip-api.com/json/" . $ip . '?fields=timezone,country,regionName,city,zip,isp';
		$response = Http::get($url);
		if ($response->successful()) {
			return $response->json();
		}
		return false;
	}




	// ◈ === isp » get client isp → string
	public static function isp($ip = null)
	{
		$ip = empty($ip) ? self::ip() : $ip;
		if ($ip == '127.0.0.1') {
			return 'localhost';
		}
		$json = self::data($ip);
		if (!empty($json)) {
			if (is_array($json)) {
				$data = (object) $json;
			}
			if (!empty($data->isp)) {
				return $data->isp;
			}
		}
		return false;
	}

}//> end of class ~ IpX