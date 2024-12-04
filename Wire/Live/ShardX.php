<?php //*** ShardX ~ abstract » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Wire\Live;

use Yale\Wire\WireX;

abstract class ShardX extends WireX
{
	// ◈ property
	protected $viewX;
	protected $shardX = true;



	// ◈ === setViewX » set view property with blade name
	protected function setViewX($view, $theme = true, $path = 'shard')
	{
		if (!empty($view)) {
			$this->viewX = $this->formatBladeX($view, $theme, $path);
		}
		// TODO: implement an error handler - [view not set]
	}



	// ◈ === cue404X » trigger a 404 error
	protected function cue404X()
	{
	}



	// ◈ === iShardX »
	protected function iShardX(?string $view = null, array|object|null $record = null, bool|string|null $theme = true)
	{
		if (!empty($view)) {
			$this->setViewX($view, $theme);
		}
		return $this->doRenderX(view: $this->getViewX(), record: $record);
	}

}//> end of abstract ~ ShardX