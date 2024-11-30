<?php //*** Kind ~ enum » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Concept\Enum\User;

enum Kind: string
{
	// ◈ case
	case GUEST = 'GUEST';
	case STAFF = 'STAFF';
	case CLIENT = 'CLIENT';
	case PARTNER = 'PARTNER';
	case CONTRACTOR = 'CONTRACTOR';
	case SUPPLIER = 'SUPPLIER';
	case PROVIDER = 'PROVIDER';
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
			self::GUEST => 'guest',
			self::STAFF => 'staff',
			self::CLIENT => 'client',
			self::PARTNER => 'partner',
			self::CONTRACTOR => 'contractor',
			self::SUPPLIER => 'supplier',
			self::PROVIDER => 'provider',
			self::ZERO => 'zero',
		};
	}

}//> end of enum ~ Kind