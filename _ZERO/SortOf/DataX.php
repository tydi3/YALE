<?php //*** DataX » Tydi™ Framework © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//
namespace App\Spry;

use Illuminate\Support\Facades\Auth;
use App\Yaic\Spry\RandomX;
use App\Yaic\Spry\Number\NumberX;

class DataX
{

	// • ==== create → make data ready for insert » array
	public static function create(array $input = null)
	{
		// TODO: make input safe for insert
		if (!isset($input['oauthor'])) {
			$user = Auth::user();
			if ($user && !empty($user->puid)) {
				$input['oauthor'] = $user->puid;
			}
		}
		$input['guid'] = $input['guid'] ?? RandomX::guid(12);
		$input['puid'] = $input['puid'] ?? RandomX::puid(20);
		$input['suid'] = $input['suid'] ?? RandomX::suid(40);
		$input['tuid'] = $input['tuid'] ?? RandomX::tuid(70);
		$input['oauthor'] = $input['oauthor'] ?? null;
		$input = ArrayX::stripKey($input, '_token');
		$input = ArrayX::stripEmptyKey($input);
		return $input;
	}



	// • ==== generateSN → generate sequential serial number » string
	public static function generateSN($lastSN = null, $prefix = null)
	{
		if (!$prefix) {
			$prefix = date('Ym');
		}
		$prefix .= '-';

		if (!$lastSN) {
			$lastSN = '000';
		} else {
			$lastSN = StringX::afterAs($lastSN, '-');
		}

		return $prefix . str_pad((int) $lastSN + 1, 4, '0', STR_PAD_LEFT);
	}



	// • ==== json → ... » string
	public static function json($data, $field)
	{
		// TODO: improve the code

		$array = json_decode($data, true);
		if (is_array($array)) {
			if (isset($array[$field])) {
				return $array[$field];
			}
		}
		return '';
	}



	public static function toNaira($number)
	{
		//TODO: pre-check!
		$money = NumberX::format($number, 2);
		if ($money != '') {
			return '₦' . $money;
		}
	}



	public static function toDollar($number)
	{
		//TODO: pre-check!
		$money = NumberX::format($number, 2);
		if ($money != '') {
			return '$' . $money;
		}
	}



	// • ==== setAmountToNullKey • ... »
	public static function setAmountToNullKey($array, $keys)
	{
		if (is_array($keys)) {
			foreach ($keys as $key) {
				if (!array_key_exists($key, $array) || $array[$key] < 1) {
					$array[$key] = null;
				}
			}
		} else {
			if (!array_key_exists($keys, $array) || $array[$keys] < 1) {
				$array[$keys] = null;
			}
		}
		return $array;
	}

} //> end of DataX
