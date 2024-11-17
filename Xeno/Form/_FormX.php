<?php //*** FormX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\Form;

use Yale\Xeno\Data\StringX;

// ** MAYBE THIS IS FORM COMPONENT (COMPONETX) **
class FormX
{



	// ◈ === input »
	public static function input(&$id, &$name = null, &$label = null, &$placeholder = null, &$title = null)
	{
		if (!empty($id) && is_string($id)) {
			$name = $name ?? $id;

			if ($label !== false) {
				$label = $label ?? $id;
			}

			$title = $title ?? $label ?? $name;
		}


		$label && self::label($label);
		$title && self::title($title);
	}





}//> end of class ~ FormX