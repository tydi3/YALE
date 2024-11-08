<?php //*** InputX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\Form;

class InputX
{
	// ◈ === value » form field input value
	public static function value($field)
	{
		return old($field) ?? ($_REQUEST[$field] ?? null);
	}

}//> end of class ~ InputX