<?php //*** PageX ~ abstract » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Wire\Live;

use Yale\Wire\WireX;
use Yale\Xeno\Http\RouteX;
use Yale\Xeno\Data\StringX;

abstract class PageX extends WireX
{
	// ◈ property
	protected $routeX;
	protected $viewX;
	protected $layoutX;
	protected $titleX;
	protected $sloganX;



	// ◈ === getTitleX »
	protected function getTitleX()
	{
		if (!empty($this->titleX)) {
			return $this->titleX;
		}
		return null;
	}



	// ◈ === getSloganX »
	protected function getSloganX()
	{
		if (!empty($this->sloganX)) {
			return $this->sloganX;
		}
		return null;
	}



	// ◈ === setRouteX »
	protected function setRouteX(?string $route = null)
	{
		if (empty($route)) {
			$route = RouteX::current('name');
		}
		$this->routeX = $route;
	}



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



	// ◈ === setTitleX »
	protected function setTitleX(?string $title = null)
	{
		if (empty($title) && !empty($this->moduleX)) {
			$title = $this->moduleX;
		}

		if (!empty($title)) {
			$this->titleX = $title;
		}
	}



	// ◈ === setSloganX »
	protected function setSloganX(?string $slogan = null)
	{
		if (empty($slogan) && !empty($this->moduleX) && !empty($this->actionX) && $this->actionX !== 'initial') {
			if (in_array($this->actionX, ['create', 'update', 'clone'])) {
				$slogan = $this->actionX . ' ' . $this->moduleX;
			} elseif ($this->actionX === 'listing') {
				$slogan = 'list of ' . StringX::plural($this->moduleX);
			} elseif ($this->actionX === 'detail') {
				$slogan = $this->moduleX . ' information';
			}
		}

		if (!empty($slogan)) {
			$this->sloganX = $slogan;
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