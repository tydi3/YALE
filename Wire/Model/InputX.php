<?php //*** InputX ~ trait » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Wire\Model;

use Yale\Xeno\Data\StringX;

trait InputX
{
	// ◈ === cleanInputX »
	protected function cleanInputX(array &$input)
	{
		if (is_array($input)) {
			foreach ($input as $field => $value) {
				if (empty($value)) {
					unset($input[$field]);
				}
			}
		}
	}

}//> end of trait ~ InputX