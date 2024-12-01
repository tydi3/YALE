<?php //*** WidgetX ~ abstract » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Wire\Live;

use Yale\Wire\WireX;

abstract class WidgetX extends WireX
{
	// ◈ property
	protected $viewX;



	// ◈ === setViewX » set view property with blade name
	protected function setViewX($view, $theme = true, $path = 'widget')
	{
		if (!empty($view)) {
			$this->viewX = $this->formatBladeX($view, $theme, $path);
		}
		// TODO: implement an error handler - [view not set]
	}


	// ◈ === cue404X » trigger a 404 error
	protected function cue404X()
	{
	}



	// ◈ === iWidgetX »
	protected function iWidgetX(?string $view = null, array|object|null $record = null, bool|string|null $theme = true)
	{
		if (!empty($view)) {
			$this->setViewX($view, $theme);
		}
		$render = [
			'view' => $this->getViewX(),
			'record' => $record,
		];
		return $this->doRenderX($render);
	}

}//> end of abstract ~ WidgetX