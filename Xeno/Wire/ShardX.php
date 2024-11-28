<?php //*** ShardX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\Wire;

use Yale\Anci\EnvX;
use Yale\Xeno\Http\RouteX;
use Yale\Xeno\Data\StringX;

abstract class ShardX extends ComponentX
{
	// ◈ property
	protected $viewX;



	// ◈ === setViewX »
	protected function setViewX($view, $theme = true)
	{
		if (empty($view)) {
			// TODO: implement using module as name
		}

		$view = 'shard.' . $view;
		$this->viewX = $this->asBladeX($view, $theme);
	}



	// ◈ === getViewX »
	protected function getViewX()
	{
		if (!empty($this->viewX)) {
			return $this->viewX;
		}
		// TODO: flag error when view is empty
	}



	// ◈ === iShardX »
	protected function iShardX(?string $view = null, array|object|null $record = null, $theme = true)
	{
		if (!empty($view)) {
			$this->setViewX($view, $theme);
		}

		return $this->doRenderX(view: $this->getViewX(), record: $record);
	}

}//> end of class ~ ShardXs