<?php //*** FormX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\Form;

class FormX
{
	// ◈ === input »
	public static function input(...$argument)
	{
		return new InputX();
	}



	// ◈ === format »
	public static function format(...$argument)
	{
		return new FormatX();
	}



	// ◈ === set »
	public static function set(...$argument)
	{
		return new SetX();
	}



	// ◈ === validateJS »
	public static function validateJS($id, $btnID = 'sendID', $validateJS)
	{
		if ($validateJS === true) {
			$attr = ' onchange="jsInputValidate({';
			$attr .= "elemID: '" . $id . "', btnID: '" . $btnID . "'";
			$attr .= '})"';
			return $attr;
		}
		return '';
	}

}//> end of class ~ FormX