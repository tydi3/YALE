<?php //*** PageX ~ abstract » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Wire\Live;

use Yale\Anci\EnvX;
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
	protected $pageX = true;



	// ◈ === mount » [initial request]
	public function mount($id = null)
	{
		// $action = $this->spotActionX('mount');
		// if (!empty($action)) {
		// 	$this->setActionX($action);
		// } else {
		// 	$this->setActionX();
		// }
		// $this->setIdX($id);
		// $this->callMethodX('igniteX');
	}



	// ◈ === boot » [every request]
	public function boot()
	{
		// $this->setRouteX();
		// $this->setComponentX();
		// $this->setModuleX();


		//	// $this->callMethodX('igniteX');
		//	// $this->setActionX();
	}



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



	// ◈ === setWireRouteX → set wire method as route name »
	protected function setWireRouteX(string $route, bool $persist = true, bool $component = true)
	{
		$routeIs = $route;
		if ($component === true) {
			$routeIs = $this->componentX;
			if ($route !== 'initial') {
				$routeIs .= '.' . $route;
			}
		}
		$this->flashX('wireRouteX', $routeIs, $persist);
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
			$link = RouteX::format($route, $param, $absolute);
			$this->dispatch('urlChanged', $link);
		}
	}



	// ◈ === render »
	public function render()
	{
		$this->callMethodX('iSetViewX');
		$this->setWireX();
		return $this->iPageX();
	}

}//> end of abstract ~ PageX