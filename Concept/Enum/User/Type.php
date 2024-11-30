<?php //*** Type ~ enum » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Concept\Enum\User;

enum Type: string
{
	// ◈ case
	case BASIC = 'BASIC';
	case STANDARD = 'STANDARD';
	case SUPERVISOR = 'SUPERVISOR';
	case HOD = 'HOD';
	case MANAGER = 'MANAGER';
	case ADMIN = 'ADMIN';
	case ZERO = 'ZERO';



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
			self::BASIC => 'basic',
			self::STANDARD => 'standard',
			self::SUPERVISOR => 'supervisor',
			self::HOD => 'hod',
			self::MANAGER => 'manager',
			self::ADMIN => 'admin',
			self::ZERO => 'zero',
		};
	}

}//> end of enum ~ Type