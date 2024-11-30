<?php //*** Role ~ enum » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Concept\Enum\User;

enum Role: string
{
	// ◈ case
	case GUARDIAN = 'GUARDIAN';
	case ADMIN = 'ADMIN';
	case HR = 'HR';
	case ICT = 'ICT';



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
			self::GUARDIAN => 'guardian',
			self::ADMIN => 'admin',
			self::HR => 'human resource',
			self::ICT => 'ICT',
		};
	}

}//> end of enum ~ Role