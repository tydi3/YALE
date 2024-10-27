<?php //*** Gender ~ enum » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Concept\Enum;

enum Gender: string
{
	// ◈ case
	case MALE = 'M';
	case FEMALE = 'F';



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
			self::MALE => 'male',
			self::FEMALE => 'female',
		};
	}



	// ◈ === number »
	public function number(): string
	{
		return match ($this) {
			self::MALE => '1',
			self::FEMALE => '0',
		};
	}

}//> end of enum ~ Gender