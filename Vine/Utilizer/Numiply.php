<?php //*** Numiply ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Vine\Utilizer;

class Numiply
{
	// ◈ === resolve »
	public static function resolve($amount, $days, $multiple = 2)
	{
		$dayAmount = $amount;
		$result = [];
		for ($day = 1; $day <= $days; $day++) {
			$result[$day] = ['amount' => number_format($dayAmount), 'day' => $day];
			$dayAmount *= $multiple;
		}
		return $result;
	}




	// ◈ === stake »
	public static function stake($amount, $days)
	{
		$stake = $amount;
		$earning = 0;
		$loss = 0;

		$stake2x = $amount;
		$earning2x = 0;

		$stake75 = $amount;
		$earning75 = 0;
		$result = [];
		for ($day = 1; $day <= $days; $day++) {
			$winning = ($stake * 2);
			$earning = $earning + ($winning - $stake);

			$winning2x = ($stake2x * 2);
			$earning2x = $earning2x + ($winning2x - $stake2x);

			$winning75 = ($stake75 * 2);
			$earning75 = $earning75 + ($winning75 - $stake75);

				// $result[$day] = [
					$result[$day] =
				// 'day' => $day,
				// 'recurring' =>
				// 	'₦' . number_format($stake) .
				// 	' • ₦' . number_format($winning) .
				// 	' → ₦' . number_format($earning),
				// 'safe' =>
				// 	'₦' . number_format($stake75) .
				// 	' • ₦' . number_format($winning75) .
				// 	' → ₦' . number_format($earning75),

				// 'double' =>
					// '₦' . number_format($stake2x) .
					' ₦' . number_format($winning2x);
					// ' • ₦' . number_format($winning2x) .
					// ' → ₦' . number_format($earning2x);
			// ];

			$stake2x = $winning2x;
			$stake75 = ($winning75 * 0.75);
		}
		return $result;
	}


}//> end of class ~ Numiply