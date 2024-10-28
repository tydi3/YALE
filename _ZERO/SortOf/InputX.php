<?php

namespace App\Spry;

use Illuminate\Support\Str;

class InputX
{

	// ◇ === genderOptions :: ... »
	public static function genderOptions()
	{
		return [
			'MALE' => 'Male',
			'FEMALE' => 'Female'
		];
	}



	// ◇ === titleOptions :: ... »
	public static function titleOptions()
	{
		return [
			'DR' => 'Dr.',
			'ENGR' => 'Engr.',
			'MR' => 'Mr.',
			'MRS' => 'Mrs.',
			'MS' => 'Ms.',
			'ALH' => 'Alhaji',
			'CHIEF' => 'Chief'
		];
	}



	// ◇ === currencyOptions :: ... »
	public static function currencyOptions()
	{
		return [
			'NGN' => 'Naira (₦)',
			'USD' => 'Dollars ($)',
			'GBP' => 'Pounds (£)',
			'EUR' => 'Euro (€)'
		];
	}



	// ◇ === unitOptions :: ... »
	public static function unitOptions()
	{
		return [
			'BAG' => 'Bag',
			'CRT' => 'Carton',
			'CAN' => 'Can',
			'DAY' => 'Day',
			'GAL' => 'Gallon',
			'KG' => 'Kilogram',
			'LEN' => 'Length',
			'LTR' => 'Litre',
			'LOT' => 'Lot',
			'MENDAY' => 'Men Days',
			'MONTH' => 'Month',
			'MTR' => 'Meter',
			'NOS' => 'Number',
			'PKT' => 'Packet',
			'PER' => 'Percent',
			'PCS' => 'Piece',
			'SET' => 'Set',
			'WEEK' => 'Week',
			'YARD' => 'Yard',
		];
	}



	// ◇ === extractParam :: ... »
	public static function extractParam(array &$param, string $field, array &$input = [], $swapKey = null)
	{
		if (isset($param[$field])) {
			if (is_array($input)) {
				if (!is_null($swapKey)) {
					$input[$swapKey] = $param[$field];
				} else {
					$input[$field] = $param[$field];
				}
			}
			unset($param[$field]);
		}
		return $input;
	}



	// • ==== paramToJson • ... » boolean
	public static function paramToJson(array &$param, string $column, array &$input = [])
	{
		$input = ArrayX::stripEmptyKey($input);
		if (!empty($input)) {
			if (empty($param[$column])) {
				$param[$column] = ArrayX::toJSON($input);
			} elseif (!empty($param[$column])) {
				// TODO: check if its JSON and convert to Array
				if (is_array($param[$column])) {
				}
			}
		}
	}



	// • ==== jsonToArray • ... » boolean
	public static function jsonToArray($json, $keyPrefix = null)
	{
		$array = JsonX::toArray($json);
		if ($array) {
			return ArrayX::prefixKey($array, $keyPrefix);
		}
		return $array;
	}



	// • ==== isID • ... » boolean
	public static function isID($input)
	{
		if (!empty($input) && is_numeric($input) && $input > 0) {
			return true;
		}
		return false;
	}



	// • ==== isPuid • ... » boolean
	public static function isPuid($input)
	{
		if (!empty($input) && is_string($input) && strlen($input) === 20) {
			return true;
		}
		return false;
	}



	// • ==== toTel • ... » boolean
	public static function toTel($number)
	{
		if (StringX::contain($number, '(0)')) {
			$number = StringX::strip($number, '(0)');
		}
		return StringX::noSpace($number);
	}



	// • ==== toUnit → ... » string
	public static function toUnit($quantity, $unit, $tag = null)
	{
		$units = self::unitOptions();
		if (!empty($units) && is_array($units) && ArrayX::isKey($units, $unit)) {
			$unit = $units[$unit];
		}

		$quantityIs = number_format($quantity);
		if ($quantity > 1) {
			$unitIs = ucfirst(Str::plural($unit));
		} else {
			$unitIs = ucfirst($unit);
		}

		if (!empty($tag)) {
			return $quantityIs . ' <' . $tag . '>' . $unitIs . '</' . $tag . '>';
		}
		return $quantityIs . ' ' . $unitIs;
	}



	// • ==== asUnit → ... » string
	public static function asUnit($unit, $quantity = 1)
	{
		if ($unit === 'MENDAY') {
			$unit = 'MEN-DAYS';
		}
		return $unit;
	}
}
