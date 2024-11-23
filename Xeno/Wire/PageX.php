<?php //*** PageX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\Wire;

abstract class PageX extends ComponentX
{
	// ◈ property
	protected $viewX;
	protected $layoutX;



	// ◈ === setViewX »
	protected function setViewX($view, $theme = true)
	{
		if (!empty($view)) {
			$view = 'page.' . $view;
			$this->viewX = $this->iBladeX($view, $theme);
		}
	}



	// ◈ === setLayoutX »
	protected function setLayoutX($layout = 'page', $theme = true)
	{
		if (!empty($layout)) {
			$layout = 'layout.' . $layout;
			$this->layoutX = $this->iBladeX($layout, $theme);
		}
	}

}//> end of class ~ PageX