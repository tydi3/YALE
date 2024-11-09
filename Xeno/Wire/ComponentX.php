<?php //*** ComponentX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\Wire;

use Livewire\Component;
use Yale\Anci\EnvX;

abstract class ComponentX extends Component
{
	// ◈ === setLayoutX »
	protected function setLayoutX($layout = null, $kind = null)
	{
		if (!$layout) {
			$layout = EnvX::project('component') . '.layout';
			if ($kind === 'page') {
				$layout .= '.page';
			}
		}
		return $layout;
	}



	// ◈ === setViewX »
	protected function setViewX($view = null, $kind = null)
	{
		if($kind){
			$path = EnvX::project('component');
			if ($kind === 'page') {
				$view = $path.'.page.'.$view;
			}
		}
		return $view;
	}




	// ◈ === iRenderX »
	protected function iRenderX($view, $layout = null, $data = [])
	{
		if (!$layout) {
			$render = view($view, $data);
		} else {
			$render = view($view, $data)->layout($layout);
		}
		return $render;
	}

}//> end of class ~ ComponentX