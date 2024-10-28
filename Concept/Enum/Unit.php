<?php //*** Unit ~ enum » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Concept\Enum;

enum Unit: string
{
	// ◈ case
	case BAG = 'BAG';
	case CAN = 'CAN';
	case CRT = 'CRT';
	case DAY = 'DAY';
	case GAL = 'GAL';
	case KG = 'KG';
	case LEN = 'LEN';
	case LOT = 'LOT';
	case LTR = 'LTR';
	case MENDAY = 'MENDAY';
	case MONTH = 'MONTH';
	case MTR = 'MTR';
	case NOS = 'NOS';
	case PCS = 'PCS';
	case PER = 'PER';
	case PKT = 'PKT';
	case SET = 'SET';
	case WEEK = 'WEEK';
	case YARD = 'YARD';



	// ◈ === toArray »
	public static function toArray($status = []): array
	{
		foreach (self::cases() as $case) {
			$status[$case->name] = $case->value;
		}
		return $status;
	}



	// ◈ === toObject »
	public static function toObject(): object
	{
		return (object) self::toArray();
	}



	// ◈ === label »
	public function label(): string
	{
		return match ($this) {
			self::BAG => 'bag',
			self::CAN => 'can',
			self::CRT => 'carton',
			self::DAY => 'day',
			self::GAL => 'gallon',
			self::KG => 'kilogram',
			self::LEN => 'length',
			self::LOT => 'lot',
			self::LTR => 'litre',
			self::MENDAY => 'men days',
			self::MONTH => 'month',
			self::MTR => 'meter',
			self::NOS => 'number',
			self::PCS => 'piece',
			self::PER => 'percent',
			self::PKT => 'packet',
			self::SET => 'set',
			self::WEEK => 'week',
			self::YARD => 'yard',
		};
	}

}//> end of enum ~ Unit