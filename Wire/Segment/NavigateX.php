<?php //*** NavigateX ~ trait » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Wire\Segment;

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
		$component = $this->getClassX();
		if ($component) {
			return $this->redirect($component::class);
		}
	}



	// ◈ === gotoX »
	protected function gotoX($route, $param = [])
	{
		$this->redirectRoute($route, $param);
	}

}//> end of trait ~ NavigateX