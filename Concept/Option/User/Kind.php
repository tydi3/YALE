<?php //*** Kind ~ option » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Concept\Option\User;

use Yale\Concept\Enum\User\Kind as KindEnum;

class Kind
{
	// ◈ === option »
	public static function option($options = []): array
	{
		foreach (KindEnum::cases() as $case) {
			$options[$case->value] = ucfirst($case->label());
		}
		return $options;
	}

}//> end of option ~ Kind