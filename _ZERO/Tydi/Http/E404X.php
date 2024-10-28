<?php //*** E404X ~ class » Yaic™ Library for Laravel © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace App\Yaic\Tydi\Http;

class E404X
{
	// ◈ property
	public static $data;
	public static $view;



	// ◈ === init »
	public static function init($data = null)
	{
		if (is_array($data)) {
			self::$data = $data;
			if (!empty($data['view'])) {
				self::$view = $data['view'];
			}
		}
	}

}//> end of class ~ E404X