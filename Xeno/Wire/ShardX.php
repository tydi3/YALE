<?php //*** ShardX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\Wire;

use Yale\Xeno\StringX;
use Yale\Xeno\Wire\ComponentX;

abstract class ShardX extends ComponentX
{
	// ◈ === iShardX »
	protected function iShardX($view, $data = [])
	{
		$this->setViewX($view, 'shard');
		$this->setLayoutX($layout, 'page');
		return $this->iRenderX($data);
	}

}//> end of class ~ ShardX