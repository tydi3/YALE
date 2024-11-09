<?php //*** PageX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\Wire;

use Yale\Xeno\StringX;
use Yale\Xeno\Wire\ComponentX;

abstract class PageX extends ComponentX
{
	// ◈ === iPageX »
	protected function iPageX($view, $layout = null, $data = [])
	{
		$layout = $this->setLayoutX($layout, 'page');
		$view = $this->setViewX($view, 'page');
		return $this->iRenderX($view, $layout, $data);
	}

}//> end of class ~ PageX