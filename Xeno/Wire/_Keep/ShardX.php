<?php //*** ShardX ~ abstract » Yaic™ Library for Laravel © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\Wire\_Keep;

use Yale\Xeno\Wire\ComponentX;

abstract class ShardX extends ComponentX
{
	// ◈ === shardX »
	protected function shardX($blade = null, $layout = null, $theme = null, $record = null, $check404 = true)
	{
		return $this->viewX($blade, $layout, $theme, 'shard', $record, true, $check404);
	}

}//> end of abstract ~ ShardX