<?php //*** PageX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\Wire;

use Yale\Anci\EnvX;
use Yale\Anci\DebugX;
use Yale\Xeno\Http\RouteX;
use Yale\Xeno\Data\StringX;

abstract class PageX extends ComponentX
{
	// ◈ property
	protected $routeX;
	protected $viewX;
	protected $layoutX;



	// ◈ === mount » [initial request]
	public function mount($id = null)
	{
		$action = $this->spotActionX('mount');
		if (!empty($action)) {
			$this->setActionX($action);
		} else {
			$this->setActionX();
		}
		$this->setIdX($id);
		$this->callMethodX('igniteX');
	}



	// ◈ === boot » [every request]
	public function boot()
	{
		$this->setRouteX();
		$this->setComponentX();
		$this->setModuleX();
		// $this->callMethodX('igniteX');
		// $this->setActionX();
	}



	// ◈ === setRouteX »
	protected function setRouteX(?string $route = null)
	{
		if (empty($route)) {
			$route = RouteX::current('name');
		}
		$this->routeX = $route;
	}



	// ◈ === setViewX »
	protected function setViewX($view, $theme = true)
	{
		if (empty($view)) {
			// TODO: implement using module as name
		}

		if (!empty($view)) {
			$view = 'page.' . $view;
			$this->viewX = $this->asBladeX($view, $theme);
			return true;
		}
	}



	// ◈ === setLayoutX »
	protected function setLayoutX($layout = 'page', $theme = true)
	{
		if (!empty($layout)) {
			$layout = 'layout.' . $layout;
			$this->layoutX = $this->asBladeX($layout, $theme);
		}
	}



	// ◈ === getViewX »
	protected function getViewX()
	{
		// if (empty($view)) {
		// 	if (empty($this->viewX)) {
		// 		if (!empty($this->moduleX)) {
		// 			$view = $this->moduleX;
		// 		} else {
		// 			$view = strtolower($this->asClassX());
		// 		}
		// 		$this->setViewX($view);
		// 	}
		// 	return $this->viewX;
		// }
		// return $view;

		if (!empty($this->viewX)) {
			return $this->viewX;
		}
		// TODO: flag error when view is empty
		DebugX::oversight('PageX', __FUNCTION__ . '() view is empty on $this->viewX');
	}



	// ◈ === getLayoutX »
	protected function getLayoutX(string|bool|null $layout = true)
	{
		if (empty($layout) || $layout === true) {
			if (empty($this->layoutX)) {
				$this->setLayoutX();
			}
			return $this->layoutX;
		} elseif ($layout === false) {
			return null;
		}
		return $layout;
	}



	// ◈ === iPageX »
	protected function iPageX(?string $view = null, array|object|null $record = null, string|bool|null $layout = true)
	{
		if (!empty($view)) {
			$this->setViewX($view, $theme);
		}
		return $this->doRenderX(view: $this->getViewX(), layout: $this->getLayoutX($layout), record: $record);
	}



	// ◈ === emitNavX »
	protected function emitNavX($title = null, $route = null, $param = [], $absolute = false)
	{
		if (!empty($title)) {
			if (StringX::wordCount($title) === 1 && (strtolower($title) === strtolower($this->titleX)) && !empty($this->actionX)) {
				if ($this->actionX === 'detail') {
					$title .= '';
				} else {
					$title = $actionX . ' ' . $titleX;
				}
				$title .= ' - ' . EnvX::project('name') . ' • ' . EnvX::firm('brand');
			}
			$this->dispatch('titleChanged', ucwords($title));
		}

		if (!empty($route)) {
			$link = RouteX:: as($route, $param, $absolute);
			$this->dispatch('urlChanged', $link);
		}
	}

}//> end of class ~ PageX