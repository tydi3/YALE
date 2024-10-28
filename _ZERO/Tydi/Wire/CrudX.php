<?php //*** CrudX ~ trait » Yaic™ Library for Laravel © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace App\Yaic\Tydi\Wire;

trait CrudX
{
	// ◈ === create »
	public function create()
	{
		$action = 'create';
		// $this->sparkX();
		$this->callMethodX('presetX', $action);
		$this->callMethodX('organizeX', $action);
		$this->callMethodX('createX', $action, );
		$this->setWireRouteX($action);
	}

}//> end of trait ~ CrudX