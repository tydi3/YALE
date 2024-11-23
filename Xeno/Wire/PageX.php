<?php //*** PageX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\Wire;

use Yale\Xeno\Http\RouteX;
use Illuminate\Support\Str;
use Yale\Xeno\Data\StringX;
use Yale\Xeno\Wire\ComponentX;

abstract class PageX extends ComponentX
{
	// ◈ property
	protected $routeX;
	protected $actionX;
	protected $titleX;
	protected $taglineX;



	// ◈ === setRouteX »
	protected function setRouteX($route = null)
	{
		if (!empty($route)) {
			$this->routeX = strtolower($route);
		} else {
			$this->routeX = RouteX::current('name');
		}
// dd($this->routeX);
		// • also set component and module
		$this->setComponentX();
		$this->setModuleX();
	}



	// ◈ === setActionX »
	protected function setActionX($action = null)
	{
		if (!empty($action)) {
			$this->actionX = strtolower($action);
		} elseif (!empty($this->routeX) && !empty($this->componentX) && ($this->routeX !== $this->componentX)) {
			$this->actionX = StringX::stripFirst($this->routeX, $this->componentX . '-');
		}
	}


	protected function setWireParamX()
	{
		$params = ['routeX', 'actionX', 'componentX', 'moduleX', 'titleX', 'taglineX'];
		$wireX = [];
		foreach ($params as $param) {
			if (!empty($this->$param)) {
				$wireX[$param] = $this->$param;
			} elseif ($param === 'titleX') {
				// TODO: move sections of this code into a setTitleX()
				if (!empty($this->moduleX)) {
					$this->titleX = $this->moduleX;
					$wireX[$param] = $this->titleX;
				}
			} elseif ($param === 'taglineX') {

				$this->taglineX = $this->actionX . ' ' . $this->moduleX;
				// TODO: move sections of this code into a setTitleX()
				if ($this->actionX === 'listing') {
					$this->taglineX = 'List of ' . ucwords(Str::plural($this->moduleX));
				}
				$wireX[$param] = $this->taglineX;
			}
			// TODO: implement for tagline based on action
		}
		return $this->setWireX($wireX);
	}



	// ◈ === iPageX »
	protected function iPageX($view, $layout = null, $data = [])
	{
		$this->setViewX($view, 'page');
		$this->setLayoutX($layout, 'page');
		return $this->iRenderX($data);
	}

}//> end of class ~ PageX