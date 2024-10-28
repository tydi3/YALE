<?php //*** FormX ~ class » Yaic™ Library for Laravel © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace App\Yaic\Tydi\Form;

use App\Yaic\Tydi\Data\StringX;

class FormX
{
	// ◈ === id » format id
	public static function id($id)
	{
		return StringX::swap($id, '.', '_');
	}



	// ◈ === aria »
	public static function aria($aria)
	{
		return ucfirst($aria);
	}



	// ◈ === title »
	public static function title($title)
	{
		$title = StringX::cropEnd($title, '...');
		$title = StringX::space($title);
		if (StringX::countWord($title) == 2) {
			return ucwords($title);
		}
		return StringX::sentenceCase($title);
	}



	// ◈ === placeholder »
	public static function placeholder($id, $placeholder = null, $onFocusBlur = true)
	{
		if (!empty($placeholder) && !empty($id)) {
			$placeholder = StringX::space($placeholder);
			$placeholder = StringX::sentenceCase(trim($placeholder)) . '...';
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



	// ◈ === validateJS »
	public static function validateJS($id, $btnID = 'sendID', $validateJS)
	{
		if ($validateJS === true) {
			$attr = ' onchange="validateInputJS({';
			$attr .= "elemID: '" . $id . "', btnID: '" . $btnID . "'";
			$attr .= '})"';
			return $attr;
		}
		return '';
	}



	// ◈ === attribute »
	public static function attribute(array $attribute = [])
	{
		$var = '';
		if (!empty($attribute['title'])) {
			$var = ' title="' . self::title($attribute['title']) . '"';
		}
		if (!empty($attribute['id'])) {
			$var = ' id="' . self::id($attribute['id']) . '"';
		}
		if (!empty($attribute['name'])) {
			$var = ' name="' . self::id($attribute['name']) . '"';
		}
		if (!empty($attribute['textrows'])) {
			$var = ' rows="' . $attribute['textrows'] . '"';
		}
		if (!empty($attribute['aria_label'])) {
			$var = ' aria-label ="' . self::aria($attribute['aria_label']) . '"';
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
			self::id($id);
		}
		if (!empty($label)) {
			$label = self::label($label);
		}

		if (!empty($title)) {
			self::title($title);
		}

	}



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



	// ◈ === label » format label
	public static function label($label)
	{
		$label = StringX::contain($label, '.') ? StringX::afterLast($label, '.') : $label;
		$label = StringX::swapSpace($label, '_', true);
		$label = ucwords($label);
		return $label;
	}

}//> end of class ~ FormX