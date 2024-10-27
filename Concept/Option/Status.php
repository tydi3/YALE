<?php //*** Status ~ option » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Concept\Option;

use Yale\Concept\Enum\Status as StatusEnum;

class Status
{
	// ◈ === option »
	public static function option($options = []): array
	{
		foreach (StatusEnum::cases() as $case) {
			$options[$case->value] = ucfirst($case->label());
		}
		return $options;
	}

}//> end of option ~ Status