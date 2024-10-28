<?php //*** Currency ~ enum » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Concept\Enum;

enum Currency: string
{
	// ◈ case
	case EUR = 'EUR';
	case GBP = 'GBP';
	case NGN = 'NGN';
	case USD = 'USD';



	// ◈ === toArray »
	public static function toArray($gender = []): array
	{
		foreach (self::cases() as $case) {
			$gender[$case->name] = $case->value;
		}
		return $gender;
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
			self::EUR => 'euro (€)',
			self::GBP => 'pounds (£)',
			self::NGN => 'naira (₦)',
			self::USD => 'dollars ($)',
		};
	}

}//> end of enum ~ Currency