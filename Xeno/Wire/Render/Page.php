<?php //*** Page ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\Wire\Render;

use Yale\Anci\DebugX;
use Yale\Xeno\Wire\PageX;
use Yale\Xeno\Wire\Trait\ManageX;
use Yale\Xeno\Wire\Trait\ParamX;

abstract class Page extends PageX
{
	// ◈ traits »
	use ManageX;
	use ParamX;



	// ◈ === igniteX »
	protected function igniteX()
	{
		$actions = ['initial', 'listing', 'create', 'update'];
		if (!empty($this->actionX) && in_array($this->actionX, $actions)) {
			$action = $this->actionX;
			$this->{$action}();
		}
	}



	// ◈ === render »
	public function render()
	{
		$this->setViewAsX();
		$this->setWireX();
		return $this->iPageX();
		// $this->debug();
	}









	protected function debug()
	{
		$param = [
			'property' => [
				'route' => $this->routeX,
				'component' => $this->componentX,
				'module' => $this->moduleX,
				'action' => $this->actionX,
				'id' => $this->idX,
				'view' => $this->viewX,
				'logs' => $this->actionCountX,
				'record' => $this->recordX,
				// 'model' => $this->modelX,
			],
			'wire' => $this->wireX,
		];
		if (isset($this->modelX)) {
			$param['property']['model'] = $this->modelX;
		}
		return DebugX::exit($param);
	}

}//> end of class ~ Page