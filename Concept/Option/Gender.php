<?php //*** Gender ~ option » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Concept\Option;

use Yale\Concept\Enum\Gender as GenderEnum;

class Gender
{
	// ◈ === option »
	public static function option($options = []): array
	{
		foreach (GenderEnum::cases() as $case) {
			$options[$case->value] = ucfirst($case->label());
		}
		return $options;
	}

}//> end of option ~ Gender