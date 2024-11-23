<?php //*** ComponentX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\Wire;

use Yale\Anci\EnvX;
use Livewire\Component;

abstract class ComponentX extends Component
{
	// ◈ property



	// ◈ === iBladeX »
	protected function iBladeX(string $blade, bool $theme = true)
	{
		if (!empty($blade)) {
			if ($theme) {
				$blade = EnvX::project('theme') . '.' . $blade;
			}
			return strtolower($blade);
		}
	}



	// ◈ === iRenderX »
	protected function iRenderX(string $view, ?string $layout = null, array $data = [])
	{
		if (!empty($layout)) {
			$render = view($view, $data)->layout($layout);
		} else {
			$render = view($view, $data);
		}
		return $render;
	}

}//> end of class ~ ComponentX