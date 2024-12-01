<?php //*** ActionX ~ trait » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Wire\Segment;

trait ActionX
{
	// ◈ property
	protected $actionX;
	protected $actionCountX;



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
	protected function spotActionX($caller = null)
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

}//> end of trait ~ ActionX