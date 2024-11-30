<?php //*** Role ~ option » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Concept\Option\User;

use Yale\Concept\Enum\User\Role as RoleEnum;

class Role
{
	// ◈ === option »
	public static function option($options = []): array
	{
		foreach (RoleEnum::cases() as $case) {
			$options[$case->value] = ucfirst($case->label());
		}
		return $options;
	}

}//> end of option ~ Role