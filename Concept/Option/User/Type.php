<?php //*** Type ~ option » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Concept\Option\User;

use Yale\Concept\Enum\User\Type as TypeEnum;

class Type
{
	// ◈ === option »
	public static function option($options = []): array
	{
		foreach (TypeEnum::cases() as $case) {
			$options[$case->value] = ucfirst($case->label());
		}
		return $options;
	}

}//> end of option ~ Type