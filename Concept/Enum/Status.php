<?php //*** Status ~ enum » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Concept\Enum;

enum Status: string
{
	// ◈ case
	case ACTIVE = 'ACTIVE';
	case SHELVED = 'SHELVED';



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
		// NOTE: How to use > Status::ACTIVE->label();
		return match ($this) {
			self::ACTIVE => 'active',
			self::SHELVED => 'shelved',
		};
	}

}//> end of enum ~ Status