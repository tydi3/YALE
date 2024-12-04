<?php //*** ManageX ~ trait » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Wire\Render;

trait ManageX
{
	// ◈ === iSetViewX »
	protected function iSetViewX($view = 'manage')
	{
		if ($this->componentX !== 'dashboard') {
			$this->setViewX($view);
		} else {
			$this->setViewX('dashboard');
		}
	}

}//> end of trait ~ ManageX