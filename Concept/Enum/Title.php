<?php //*** Title ~ enum » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Concept\Enum;

enum Title: string
{
	// ◈ case
	case ALH = 'ALH';
	case CHIEF = 'CHIEF';
	case DR = 'DR';
	case ENGR = 'ENGR';
	case MR = 'MR';
	case MRS = 'MRS';
	case MS = 'MS';



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
			self::ALH => 'alhaji',
			self::CHIEF => 'chief',
			self::DR => 'dr.',
			self::ENGR => 'engr.',
			self::MR => 'mr.',
			self::MRS => 'mrs.',
			self::MS => 'ms.',
		};
	}

}//> end of enum ~ Title