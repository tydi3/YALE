<?php //*** JsonX ~ class » Yaic™ Library for Laravel © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace App\Yaic\Tydi\Data;

class JsonX
{
	// ◈ === is »
	public static function is($input)
	{
		if (!empty($input)) {
			json_decode($input);
			$o = (json_last_error() === JSON_ERROR_NONE);
			if ($o === true || $o === 1) {
				return true;
			}
		}
		return false;
	}



	// ◈ === handler »
	public static function handler($data, array $report, $input)
	{
		// TODO: Improve on this
		if ($report['code'] === JSON_ERROR_NONE) {
			return $data;
		} elseif (!empty($report['code'])) {
			return ['error' => $report, 'input' => $input];
		}
		return false;
	}



	// ◈ === encode »
	public static function encode($input, $flag = 0)
	{
		if (!empty($input)) {
			$data = json_encode($input, $flag);
			$report = ['code' => json_last_error(), 'message' => json_last_error_msg(), 'type' => gettype($input)];
			return self::handler($data, $report, $input);
		}
		return false;
	}



	// ◈ === decode »
	public static function decode($input, $flow = 'OBJECT')
	{
		if (!empty($input)) {
			if (is_array($input)) {
				$input = json_encode($input);
			}

			// ~ Convert json string to Array
			if ($flow === 'ARRAY') {
				$data = json_decode($input, true);
			}

			// ~ Convert json string to Object
			elseif ($flow === 'OBJECT') {
				$data = json_decode($input);
			}

			$report = ['code' => json_last_error(), 'message' => json_last_error_msg(), 'type' => gettype($input)];
			return self::handler($data, $report, $input);
		}
		return false;
	}



	// ◈ === pretty »
	public static function pretty($input = '')
	{
		return self::encode($input, JSON_PRETTY_PRINT);
	}



	// ◈ === display »
	public static function display($json)
	{
		if (!empty($json)) {
			header('Content-Type: application/json');
			echo $json;
			exit;
		}
	}



	// ◈ === toArray »
	public static function toArray($input)
	{
		if (self::is($input)) {
			return json_decode($input, true);
		}
		return false;
	}



	// ◈ === toObj »
	public static function toObj($input)
	{
		if (self::is($input)) {
			return json_decode($input);
		}
		return false;
	}

}//> end of class ~ JsonX
