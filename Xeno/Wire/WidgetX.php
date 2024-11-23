<?php //*** WidgetX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\Wire;

abstract class WidgetX extends ComponentX
{
	// ◈ property
	protected $viewX;



	// ◈ === setViewX »
	protected function setViewX($view, $theme = true)
	{
		if (!empty($view)) {
			$view = 'widget.' . $view;
			$this->viewX = $this->iBladeX($view, $theme);
		}
	}

}//> end of class ~ WidgetX