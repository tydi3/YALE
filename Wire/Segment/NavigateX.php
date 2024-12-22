<?php //*** NavigateX ~ trait » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Wire\Segment;

use Yale\Xeno\Http\RouteX;

trait NavigateX
{
	// ◈ === redirectX »
	protected function redirectX($link, $wire = true)
	{
		if ($wire === true) {
			return $this->redirect($link, navigate: true);
		}
		return $this->redirect($link);
	}



	// ◈ === refreshX »
	protected function refreshX()
	{
		return $this->refresh();
	}



	// ◈ === reloadX »
	protected function reloadX()
	{
		$component = $this->getClassX(true);
		if ($component) {
			return $this->redirect($component::class);
		}
	}



	// ◈ === gotoX
	public function gotoX($route = null, $param = [], $absolute = false, $wire = true)
	{
		// 	$this->redirectRoute($route, $param);
		return $this->redirectX(RouteX::format($route, $param, $absolute), $wire);
	}

}//> end of trait ~ NavigateX