<?php //*** ActionX ~ trait » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Wire\Segment;

use Yale\Xeno\Data\StringX;

trait ActionX
{
	// ◈ property
	protected $actionX;
	protected $actionCountX;



	// ◈ === igniteX »
	protected function igniteX()
	{
		$actions = ['initial', 'listing', 'detail', 'create', 'update', 'clone'];
		if (!empty($this->actionX) && in_array($this->actionX, $actions)) {
			$action = $this->actionX;
			$this->{$action}();
		}
	}



	// ◈ === actionCountX »
	protected function actionCountX($action, $do = 'return', $number = 1)
	{
		$this->actionCountX[$action] = $this->actionCountX[$action] ?? 0;
		if ($do === 'increment') {
			$this->actionCountX[$action] += $number;
		} elseif ($do === 'decrement') {
			$this->actionCountX[$action] += $number;
		} elseif ($do === 'calibrate') {
			$this->actionCountX[$action] = $number;
		} elseif ($do === 'return') {
			return $this->actionCountX[$action];
		}
	}



	// ◈ === getActionX »
	protected function getActionX()
	{
		if (!empty($this->actionX)) {
			return $this->actionX;
		}
		return null;
	}



	// ◈ === setActionX »
	protected function setActionX(?string $action = null)
	{
		if (empty($action)) {
			if (!empty($this->routeX) && strtolower($this->routeX) !== 'livewire.update') {
				if (($this->routeX !== $this->componentX)) {
					$action = StringX::after($this->routeX, $this->componentX . '.');
				} else {
					$action = 'initial';
				}
			}
		}
		if (!empty($action)) {
			$this->actionX = strtolower($action);
		}
	}



	// ◈ === setActionCountX »
	protected function setActionCountX($action, $number = 1, bool|null $increment = true)
	{
		if ($increment === true) {
			return $this->actionCountX($action, 'increment', $number);
		} elseif ($increment === false) {
			return $this->actionCountX($action, 'decrement', $number);
		} elseif (is_null($increment)) {
			return $this->actionCountX($action, 'calibrate', $number);
		}
	}



	// ◈ === spotActionX » detect action from http
	protected function spotActionX()
	{
		$action = null;
		if (!empty($this->routeX)) {
			if (strtolower($this->routeX) !== 'livewire.update') {
				if (StringX::contain($this->routeX, '.')) {
					if (($this->routeX !== $this->componentX)) {
						$action = StringX::after($this->routeX, $this->componentX . '.');
					} else {
						$action = StringX::after($this->routeX, '.');
					}
				} else {
					$action = 'initial';
				}
			}
		}

		if (!empty($action)) {
			$action = strtolower($action);
		}

		return $action;
	}



	// ◈ === doActionX »
	protected function doActionX($action, $record = [])
	{
		$this->setIfNotX('action', $action);
		$this->setActionCountX($action);
		if ($action !== 'create') {
			$this->setRecordX($record);
		}
		$this->callMethodX('organizeX', $action);
		if (isset($this->pageX) && $this->pageX === true) {
			$this->setWireRouteX($action);
			if (!empty($this->moduleX)) {
				$this->setTitleX($this->moduleX);
				if ($action === 'initial') {
					$this->setSloganX('manage ' . $this->moduleX);
				} elseif ($action === 'listing') {
					$this->setSloganX('list of ' . StringX::plural($this->moduleX));
				} elseif ($action === 'detail') {
					$this->setSloganX($this->moduleX . ' information');
				} elseif ($action === 'update') {
					$this->setSloganX('update ' . $this->moduleX);
				} elseif ($action === 'clone') {
					$this->setSloganX('clone ' . $this->moduleX);
				} elseif ($action === 'create') {
					$this->setSloganX('create ' . $this->moduleX);
				}
			}
		}
	}



	// ◈ === initialX »
	protected function initialX($record = [], $action = 'initial')
	{
		$this->doActionX($action, $record);
	}



	// ◈ === listingX »
	protected function listingX($record = [], $action = 'listing')
	{
		$this->doActionX($action, $record);
	}



	// ◈ === detailX »
	protected function detailX($record = [], $action = 'detail')
	{
		$this->doActionX($action, $record);
	}



	// ◈ === createX »
	protected function createX($action = 'create')
	{
		$this->doActionX($action, $record);
	}



	// ◈ === updateX »
	protected function updateX($record = [], $action = 'update')
	{
		$this->doActionX($action, $record);
	}



	// ◈ === cloneX »
	protected function cloneX($action = 'clone')
	{
		$this->doActionX($action, $record);
	}



	// ◈ === deleteX »


}//> end of trait ~ ActionX