<?php //*** PageX ~ abstract » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Wire\Live;

use Yale\Wire\WireX;

abstract class PageX extends WireX
{
	// ◈ property
	protected $viewX;



	// ◈ === setViewX » set view property with blade name
	protected function setViewX($view, $theme = true, $path = 'page')
	{
		if (!empty($view)) {
			$this->viewX = $this->formatBladeX($view, $theme, $path);
		}
		// TODO: implement an error handler - [view not set]
	}



	// ◈ === setLayoutX » set layout property with blade name
	protected function setLayoutX($layout = 'page', $theme = true, $path = 'layout')
	{
		if (!empty($layout)) {
			$this->layoutX = $this->formatBladeX($layout, $theme, $path);
		}
	}



	// ◈ === cue404X » trigger a 404 error
	protected function cue404X()
	{
	}



	// ◈ === iPageX »
	protected function iPageX(?string $view = null, array|object|null $record = null, bool|string|null $theme = true)
	{
		if (!empty($view)) {
			$this->setViewX($view, $theme);
		}
		$render = [
			'view' => $this->getViewX(),
			'layout' => $this->getLayoutX(),
			'record' => $record,
		];
		return $this->doRenderX($render);
	}

}//> end of abstract ~ PageX