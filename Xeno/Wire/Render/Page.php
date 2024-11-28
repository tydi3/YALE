<?php //*** Page ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\Wire\Render;

use Yale\Xeno\Wire\PageX;
use Yale\Xeno\Wire\Trait\ManageX;

abstract class Page extends PageX
{
	// ◈ traits »
	use ManageX;



	// ◈ === bootX »
	protected function bootX()
	{
		$actions = ['listing'];
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
	}

}//> end of class ~ Page