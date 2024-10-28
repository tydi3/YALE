<?php //*** PageX ~ abstract » Yaic™ Library for Laravel © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace App\Yaic\Tydi\Wire;

use App\Yaic\Tydi\DebugX;
use Livewire\Attributes\Title;
use App\Yaic\Tydi\Wire\ComponentX;

abstract class PageX extends ComponentX
{
	// ◈ property
	protected $defaultViewX;
	protected $defaultActionX;
	protected $viewsAllowedX = ['index', 'landing', 'notify', 'form', 'listing', 'create', 'read', 'update', 'clone', 'delete'];



	// ◈ === pageX »
	protected function pageX($blade = null, $layout = null, $theme = null, $record = null, $check404 = true)
	{
		return $this->viewX($blade, $layout, $theme, 'page', $record, true, $check404);
	}



	// ◈ === setRouteViewX »
	protected function setRouteViewX($route = null, $useAuto = false)
	{
		$route = !empty($route) ? $route :
			(!empty($this->routeX) ? $this->routeX :
				(!empty($this->componentX) ? $this->componentX : null));

		$action = !empty($this->actionX) ? $this->actionX :
			(!empty($this->defaultActionX) ? $this->defaultActionX :
				(!empty($this->defaultActionX) ? $this->defaultActionX : null));

		if ($useAuto === true && empty($action)) {
			if ($route === $this->componentX) {
				$action = 'index';
			}
		}

		if ($action && $this->isNotViewX($action)) {
			return $this->callActionX($action);
		}
	}



	// ◈ === callActionX »
	protected function callActionX($action)
	{
		if ($action === 'index') {
			if (method_exists($this, 'index')) {
				return $this->index();
			}
		} elseif ($action === 'landing') {
			if (method_exists($this, 'landing')) {
				return $this->landing();
			} elseif (method_exists($this, 'index')) {
				return $this->index();
			}
		} elseif (method_exists($this, $action)) {
			return $this->{$action}();
		}
		return $this->setViewX($action);
	}



	// ◈ === setViewsAllowedX »
	private function setViewsAllowedX(array $views = [])
	{
		$this->$viewsAllowedX = array_merge($this->$viewsAllowedX, $views);
	}

}//> end of abstract ~ PageX