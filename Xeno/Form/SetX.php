<?php //*** SetX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\Form;

use Yale\Xeno\Data\StringX;

class SetX
{
	// ◈ === label »
	public static function label($label = null, $for = null)
	{
		if (empty($label) && !empty($for)) {
			$label = $for;
		}
		if (!empty($label)) {
			$label = FormatX::label($label);
		}
		return $label;
	}




	// ◈ === placeholder »
	public static function placeholder($id, $placeholder = null, $onFocusBlur = true)
	{
		if (!empty($placeholder) && !empty($id)) {
			$placeholder = StringX::space($placeholder);
			$placeholder = StringX::sentence(trim($placeholder)) . '...';
			if ($onFocusBlur !== false) {
				$id = 'on' . $id;
				$attr = ' x-bind:placeholder=';
				$attr .= '"' . $id . " ? '' : '";
				$attr .= $placeholder . "'" . '"';
			} else {
				$attr = ' placeholder="' . $placeholder . '"';
			}
			return $attr;
		}
		return '';
	}



	// ◈ === attribute »
	public static function attribute(array $attribute = [])
	{
		$var = '';
		if (!empty($attribute['title'])) {
			$var = ' title="' . FormatX::title($attribute['title']) . '"';
		}
		if (!empty($attribute['id'])) {
			$var = ' id="' . FormatX::id($attribute['id']) . '"';
		}
		if (!empty($attribute['name'])) {
			$var = ' name="' . FormatX::id($attribute['name']) . '"';
		}
		if (!empty($attribute['textrows'])) {
			$var = ' rows="' . $attribute['textrows'] . '"';
		}
		if (!empty($attribute['aria_label'])) {
			$var = ' aria-label ="' . FormatX::aria($attribute['aria_label']) . '"';
		}
		if (isset($attribute['disable']) && $attribute['disable'] === true) {
			$var = ' disabled';
		}
		if (!empty($attribute['obind'])) {
			$var = ' wire:model="' . $attribute['obind'] . '"';
		}
		if (!empty($attribute['ochange'])) {
			$var = ' wire:change="' . $attribute['ochange'] . '"';
		}
		return $var;
	}



	// ◈ === autocomplete »
	public static function autocomplete($ocomplete = null)
	{
		if (is_bool($ocomplete) || !empty($ocomplete)) {
			$attr = ' autocomplete="';
			if ($ocomplete === true) {
				$attr .= 'on';
			} elseif ($ocomplete === false) {
				$attr .= 'off';
			} else {
				$attr .= $ocomplete;
			}
			$attr .= '"';
			return $attr;
		}
		return '';
	}



	// ◈ === disable »
	public static function disable($disabled = false)
	{
		if ($disabled === true) {
			return ' disabled';
		}
		return '';
	}



	// ◈ === value »
	public static function value($value = null, $type = '')
	{
		if (!empty($value)) {
			if ($type === 'textarea') {
				return $value;
			} elseif (in_array($type, ['text', 'password', 'percent', 'number', 'date', 'email'])) {
				$attr = ' value="';
				$attr .= $value;
				$attr .= '"';
				return ' value="' . $value . '"';
			}
		}
		return '';
	}



	// ◈ === ochange » for wire-change
	public static function ochange($ochange = null, $name = null, $id = null)
	{
		if ($ochange !== false && (!empty($ochange) || $ochange === true)) {
			$ochange = !empty($name) ? $name : (!empty($id) ? $id : $ochange);
		}
		return $ochange;
	}



	// ◈ === obind » for wire-change
	public static function obind($obind = null, $name = null, $id = null)
	{
		if ($obind === true) {
			$obind = !empty($name) ? $name : (!empty($id) ? $id : $obind);
		}
		return $obind;
	}



	// ◈ === tag » naming form input, etc
	public static function tag(&$type = null, &$id = null, &$name = null, &$label = null, &$placeholder = null, &$title = null): void
	{

		// » type | id | name | label | placeholder | title

		// • for type - date
		if ($type === 'date') {
			$name = !empty($name) ? $name : 'date';
		}

		// • for type - password
		if ($type === 'password') {
			$id = !empty($id) ? $id : 'password';
			$name = !empty($name) ? $name : $id;
		}

		// • name from id
		if (empty($name) && !empty($id)) {
			$name = $id;
		}

		// • default
		if (!empty($name)) {
			$id = !empty($id) ? $id : $name;
			if ($label !== false) {
				$label = !empty($label) ? $label : $name;
			}
			if ($placeholder !== false) {
				if (!empty($label)) {
					$placeholder = !empty($placeholder) ? $placeholder : $label;
				} else {
					$placeholder = !empty($placeholder) ? $placeholder : $name;
				}
			}

			if ($title === true || is_null($title)) {
				if (!empty($label) && (StringX::countWord($label) > 1)) {
					$title = $label;
				} elseif (!empty($placeholder)) {
					$title = $placeholder;
				} else {
					$title = $name;
				}
			}

		}

		// • formatting
		if (!empty($id)) {
			$id = FormatX::id($id);
		}
		if (!empty($label)) {
			$label = FormatX::label($label);
		}

		if (!empty($title)) {
			$title = FormatX::title($title);
		}

	}



	// ◈ === button »
	public static function button(&$label = 'Save', &$id = null, &$module = null, &$title = null, &$type = 'submit', &$scheme = 'primary')
	{
		if (empty($label) && !empty($id) && !StringX::isNumber($id)) {
			$label = $id;
		}

		if (!empty($label)) {
			if ($label === 'reset') {
				$type = 'reset';
			}

			if (!empty($module) && !StringX::isNumber($module)) {
				$label .= ' ' . $module;
			}
			$label = StringX::capitalize($label);

			if (empty($title)) {
				$title = $label;
			}
		}

		if ($type === 'submit') {
			$type = in_array($label, ['reset', 'clear'], true) ? 'reset' : $type;
		}

		if ($type === 'reset') {
			if (empty($label)) {
				$label = 'clear';
			}
			$scheme = StringX::swap($scheme, 'primary', 'gray');
		}

		if(!empty($title)){
			$title = StringX::capitalize($title);
		}

		$scheme = $scheme === 'gray' ? 'gray-100' : $scheme;
		$scheme = $scheme === 'outline-gray' ? 'outline-gray-200' : $scheme;
	}

}//> end of class ~ SetX