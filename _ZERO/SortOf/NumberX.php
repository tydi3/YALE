<?php //*** NumberX » Tydi™ Framework © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//
namespace App\Spry;


class NumberX
{












	// • ==== tensToWords → ... »
	public static function tensToWords($number)
	{
		$ones = [0 => 'zero', 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six', 7 => 'seven', 8 => 'eight', 9 => 'nine'];
		$teens = [10 => 'ten', 11 => 'eleven', 12 => 'twelve', 13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen', 16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen', 19 => 'nineteen'];
		$tens = [2 => 'twenty', 3 => 'thirty', 4 => 'forty', 5 => 'fifty', 6 => 'sixty', 7 => 'seventy', 8 => 'eighty', 9 => 'ninety'];
		$words = '';

		if ($number == '00') {
			return '';
		}
		if (strlen($number) === 2) {
			if (StringX::beginWith($number, '0') && !StringX::endWith($number, '0')) {
				$words .= $ones[$number[1]];
			} elseif (StringX::beginWith($number, '1')) {
				$words .= $teens[$number[0] . $number[1]];
			} else {
				$words .= $tens[$number[0]];
				if (!StringX::endWith($number, '0')) {
					$words .= '-' . $ones[$number[1]];
				}
			}
		}
		return $words;
	}





	// • ==== hundredToWords → ... »
	public static function hundredToWords($number)
	{
		$hundred = [1 => 'one hundred', 2 => 'two hundred', 3 => 'three hundred', 4 => 'four hundred', 5 => 'five hundred', 6 => 'six hundred', 7 => 'seven hundred', 8 => 'eight hundred', 9 => 'nine hundred'];
		$words = '';

		if (strlen($number) === 3 && $number != '000') {
			$words .= $hundred[$number[0]];
		}
		return $words;
	}





	// • ==== thousandToWords → ... »
	public static function thousandToWords($number)
	{
		$hundred = [1 => 'one hundred', 2 => 'two hundred', 3 => 'three hundred', 4 => 'four hundred', 5 => 'five hundred', 6 => 'six hundred', 7 => 'seven hundred', 8 => 'eight hundred', 9 => 'nine hundred'];
		$teens = [10 => 'ten', 11 => 'eleven', 12 => 'twelve', 13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen', 16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen', 19 => 'nineteen'];
		$ones = [0 => 'zero', 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six', 7 => 'seven', 8 => 'eight', 9 => 'nine'];
		$tens = [2 => 'twenty', 3 => 'thirty', 4 => 'forty', 5 => 'fifty', 6 => 'sixty', 7 => 'seventy', 8 => 'eighty', 9 => 'ninety'];
		$words = '';

		$hasHundredThousand = false;
		if (strlen($number) === 6) {
			if ($number != '000000' && !StringX::beginWith($number, '0')) {
				$words .= $hundred[$number[0]];
				$number = substr($number, 1);
				$hasHundredThousand = true;
			} else {
				$number = substr($number, 1);
			}
		}

		if (strlen($number) === 5) {
			if (StringX::beginWith($number, '0') && $number[1] != '0') {
				if ($hasHundredThousand) {
					$words .= ' and';
				}
				$words .= ' ' . $ones[$number[1]];
			} elseif (StringX::beginWith($number, '1')) {
				if ($hasHundredThousand) {
					$words .= ' and';
				}
				$words .= ' ' . $teens[$number[0] . $number[1]];
			} else {
				if ($number[0] != '0') {
					if ($hasHundredThousand) {
						$words .= ' and';
					}
					$words .= ' ' . $tens[$number[0]];
					if ($number[1] != '0') {
						$words .= '-' . $ones[$number[1]];
					}
				} elseif ($number[1] != '0') {
					$words .= $ones[$number[1]];
				}
			}
		} elseif (strlen($number) === 4 && !StringX::beginWith($number, '0')) {
			$words .= ' ' . $ones[$number[0]];
		}



		if (!empty($words)) {
			return $words . ' thousand';
		}
		return false;









		if (strlen($number) === 6) {
			if ($number != '000000') {
				$words .= $hundred[$number[0]];
				$number = substr($number, 1);
			}
		}

		if (strlen($number) === 5) {
			if (StringX::beginWith($number, '0')) {
				if (!StringX::endWith($number, '0')) {
					if (!empty($words)) {
						$words .= ' and ';
					}
					$words .= $ones[$number[1]];
				}
			} elseif (StringX::beginWith($number, '1')) {
				if (!empty($words)) {
					$words .= ' and ';
				}
				$words .= $teens[$number[0] . $number[1]];
			} else {
				if (!empty($words)) {
					$words .= ' and ';
				}
				$words .= $tens[$number[0]];
				if ($number[1] != '0') {
					$words .= '-' . $ones[$number[1]];
				}
			}
		}


		if (strlen($number) === 4) {
			$words .= $ones[$number[0]];
		}


	}





	// • ==== millionToWords → ... »
	public static function millionToWords($number)
	{
		$hundred = [1 => 'one hundred', 2 => 'two hundred', 3 => 'three hundred', 4 => 'four hundred', 5 => 'five hundred', 6 => 'six hundred', 7 => 'seven hundred', 8 => 'eight hundred', 9 => 'nine hundred'];
		$teens = [10 => 'ten', 11 => 'eleven', 12 => 'twelve', 13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen', 16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen', 19 => 'nineteen'];
		$ones = [0 => 'zero', 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six', 7 => 'seven', 8 => 'eight', 9 => 'nine'];
		$tens = [2 => 'twenty', 3 => 'thirty', 4 => 'forty', 5 => 'fifty', 6 => 'sixty', 7 => 'seventy', 8 => 'eighty', 9 => 'ninety'];
		$words = '';

		$hasHundredMillion = false;
		if (strlen($number) === 9) {
			if (!StringX::beginWith($number, '0')) {
				$words .= $hundred[$number[0]];
				$number = substr($number, 1);
				$hasHundredMillion = true;
			} else {
				//TODO: Test
				// $number = substr($number, 1);
			}
		}

		if (strlen($number) === 8) {
			if (StringX::beginWith($number, '0') && $number[1] != '0') {
				if ($hasHundredMillion) {
					$words .= ' and';
				}
				$words .= ' ' . $ones[$number[1]];
			} elseif (StringX::beginWith($number, '1')) {
				if ($hasHundredMillion) {
					$words .= ' and';
				}
				$words .= ' ' . $teens[$number[0] . $number[1]];
			} else {
				if ($number[0] != '0') {
					if ($hasHundredMillion) {
						$words .= ' and';
					}
					$words .= ' ' . $tens[$number[0]];
					if ($number[1] != '0') {
						$words .= '-' . $ones[$number[1]];
					}
				} elseif ($number[1] != '0') {
					$words .= $ones[$number[1]];
				}
			}
		} elseif (strlen($number) === 7 && !StringX::beginWith($number, '0')) {
			$words .= ' ' . $ones[$number[0]];
		}

		if (!empty($words)) {
			return $words . ' million';
		}
		return false;
	}





	// • ==== toWords → ... »
	public static function toWords($number, $money = true)
	{
		$number = StringX::strip($number, ',');


		$naira = StringX::beforeAs($number, '.');
		$moneyWords = '';


		// » million
		$millionWords = false;
		if (strlen($naira) <= 9 && strlen($naira) >= 7) {
			if (StringX::beginWith($naira, '0')) {
				$naira = substr($naira, 1);
			}
			$millionWords = self::millionToWords($naira);

			$count = strlen($naira);
			if ($count > 6) {
				$trim = ($count - 6);
				$naira = substr($naira, $trim);
			}

		}


		// » thousand
		$thousandWords = false;
		if (strlen($naira) <= 6 && strlen($naira) >= 4) {
			if (StringX::beginWith($naira, '0')) {
				$naira = substr($naira, 1);
			}
			$thousandWords = self::thousandToWords($naira);
			if (!empty($thousandWords)) {
				$count = strlen($naira);
				if ($count > 3) {
					$trim = ($count - 3);
					$naira = substr($naira, $trim);
				}
			}
		}


		// » hundred
		$hundredToWords = false;
		if (StringX::beginWith($naira, '00')) {
			$naira = substr($naira, 2);
		} elseif (StringX::beginWith($naira, '0')) {
			$naira = substr($naira, 1);
		}
		if (strlen($naira) === 3) {
			if (StringX::beginWith($naira, '0')) {
				$naira = substr($naira, 1);
			}
			$hundredToWords = self::hundredToWords($naira);
			if (!empty($hundredToWords)) {
				$count = strlen($naira);
				if ($count > 2) {
					$trim = ($count - 2);
					$naira = substr($naira, $trim);
				}
			}
		}



		// » tens
		$tensToWords = false;
		if (strlen($naira) < 3) {
			$tensToWords = self::tensToWords($naira);
		}


		// » kobo
		$kobo = StringX::after($number, '.');
		if ($kobo !== false) {
			if (strlen($kobo) < 2) {
				$kobo .= '0';
			}
			$koboWords = self::tensToWords($kobo);
		}


		if (!empty($millionWords)) {
			$moneyWords .= $millionWords;
		}

		if (!empty($thousandWords)) {
			if (!empty($moneyWords)) {
				$moneyWords = trim($moneyWords);
				$moneyWords .= ', ';
			}
			$moneyWords .= $thousandWords;
		}

		if (!empty($hundredToWords)) {
			if (!empty($moneyWords)) {
				$moneyWords = trim($moneyWords);
				$moneyWords .= ', ';
			}
			$moneyWords .= $hundredToWords;
		}

		if (!empty($tensToWords)) {
			if (!empty($moneyWords)) {
				$moneyWords = trim($moneyWords);
				$moneyWords .= ' and ';
			}
			$moneyWords .= $tensToWords;
		}

		if (!empty($moneyWords)) {
			$moneyWords = trim($moneyWords);
			$moneyWords .= ' naira';
		}

		if (!empty($koboWords)) {
			if (!empty($moneyWords)) {
				$moneyWords .= ', ';
			}
			$moneyWords .= $koboWords . ' kobo';
		}

		return trim($moneyWords);
	}

}//> end of NumberX