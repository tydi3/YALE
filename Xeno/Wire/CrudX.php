<?php //*** CrudX ~ trait » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\Wire;

trait CrudX
{
	// ◈ === create »
	public function create()
	{
		$action = 'create';
		// $this->sparkX();
		$this->callMethodX('presetX', $action);
		$this->callMethodX('organizeX', $action);
		$this->callMethodX('createX', $action);
		$this->setWireRouteX($action);
	}

}//> end of trait ~ CrudX