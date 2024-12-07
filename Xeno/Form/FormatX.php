<?php //*** FormatX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\Form;

use Yale\Xeno\Data\StringX;

class FormatX
{
	// ◈ === id » format id
	public static function id($id)
	{
		return StringX::swap($id, '.', '_');
	}



	// ◈ === label »
	public static function label($label)
	{
		$label = StringX::contain($label, '.') ? StringX::afterLast($label, '.') : $label;
		$label = StringX::swapSpace($label, '_', true);
		return StringX::capitalize($label);
	}



	// ◈ === title »
	public static function title($title)
	{
		$title = StringX::cropEnd($title, '...');
		$title = StringX::space($title);
		if (StringX::countWord($title) == 2) {
			return ucwords($title);
		}
		return StringX::sentence($title);
	}



	// ◈ === aria »
	public static function aria($aria)
	{
		return ucfirst($aria);
	}

}//> end of class ~ FormatX