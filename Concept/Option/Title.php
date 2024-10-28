<?php //*** Title ~ option » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Concept\Option;

use Yale\Concept\Enum\Title as TitleEnum;

class Title
{
	// ◈ === option »
	public static function option($options = []): array
	{
		foreach (TitleEnum::cases() as $case) {
			$options[$case->value] = ucfirst($case->label());
		}
		return $options;
	}

}//> end of option ~ Title