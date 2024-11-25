<?php //*** ComponentX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\Wire;

use Yale\Anci\EnvX;
use Yale\Anci\DebugX;
use Livewire\Component;
use Yale\Xeno\Data\ArrayX;
use Yale\Xeno\Data\StringX;

abstract class ComponentX extends Component
{
	// ◈ property
	protected $componentX;
	protected $moduleX;
	protected $actionX;
	protected $recordX = [];
	protected $titleX;
	protected $sloganX;
	protected $permissionX = [];
	public $wireX;



	// ◈ === iClassX »
	public function iClassX()
	{
		return basename(get_class($this));
	}



	// ◈ === iBladeX »
	protected function iBladeX(string $blade, bool $theme = true)
	{
		if (!empty($blade)) {
			if ($theme) {
				$blade = EnvX::project('theme') . '.' . $blade;
			}
			return strtolower($blade);
		}
	}



	// ◈ === iRenderX »
	protected function iRenderX(string $view, ?string $layout = null, array|object|null $record = null)
	{
		if (empty($record)) {
			$record = $this->recordX;
		}

		if (!empty($layout)) {
			$render = view($view, ['recordX' => $record])->layout($layout);
		} else {
			$render = view($view, ['recordX' => $record]);
		}
		return $render;
	}



	// ◈ === iComponentX »
	protected function iComponentX(?string $component = null)
	{
		if (empty($component)) {
			$component = $this->iClassX();
			// $component = StringX::beforeAs($this->routeX, '-');
		}
		return strtolower($component);
	}



	// ◈ === iActionX »
	protected function iActionX(?string $action = null)
	{
		if (empty($action)) {
			if (!empty($this->routeX) && !empty($this->componentX)) {
				if (($this->routeX !== $this->componentX)) {
					$action = StringX::after($this->routeX, $this->componentX . '.');
				}
			}
		}

		if (empty($action)) {
			$action = 'index';
		}

		return strtolower($action);
	}



	// ◈ === setComponentX »
	protected function setComponentX(?string $component = null)
	{
		$this->componentX = $this->iComponentX($component);
	}



	// ◈ === setActionX »
	protected function setActionX(?string $action = null)
	{
		$this->actionX = $this->iActionX($action);
	}



	// ◈ === setRecordX »
	protected function setRecordX(array|object|null $record = null)
	{
		if (empty($record)) {
			$record = [];
		}

		// if (is_array($record)) {
		// 	$record = ArrayX::toObject($record);
		// }

		$this->recordX = $record;
	}



	// ◈ === setTitleX »
	protected function setTitleX(?string $title = null)
	{
		// TODO: change from component to module as componet may be more that a single word & module would have to be define from a setModuleX()
		if (empty($title) && !empty($this->componentX)) {
			$title = $this->componentX;
		}
		$this->titleX = $title;
	}



	// ◈ === setSloganX »
	protected function setSloganX(?string $slogan = null)
	{
		// TODO: change from component to module as componet may be more that a single word & module would have to be define from a setModuleX()
		if (empty($slogan) && !empty($this->componentX) && !empty($this->actionX) && $this->actionX !== 'index') {
			$slogan = $this->actionX . ' ' . $this->componentX;
			if ($this->actionX === 'detail') {
				$slogan = 'review ' . $this->componentX . ' details';
			} elseif ($this->actionX === 'listing') {
				$slogan = 'list of ' . StringX::plural($this->componentX);
			}
		}

		$this->sloganX = $slogan;
	}



	// ◈ === setPermissionX »
	protected function setPermissionX(array $permission = [])
	{
		$this->permissionX = array_merge($this->permissionX, $permission);
	}


	// ◈ === setModuleX »
	protected function setModuleX($module = true)
	{
		if ($module === true) {
			if (!empty($this->componentX)) {
				$this->moduleX = StringX::firstWord($this->componentX);
			}
		} elseif (!empty($module)) {
			$this->moduleX = $module;
		}
	}



	// ◈ === setWireX »
	protected function setWireX()
	{
		// • new object
		if (!isset($this->wireX)) {
			$this->wireX = new \stdClass();
		}

		// • set parameters & values
		$wire = $this->wireX;
		$params = ['route', 'component', 'module', 'action', 'title', 'slogan', 'permission'];
		$properties = array_map(
			function ($param) {
				return $param . 'X';
			},
			$params
		);

		// • params
		foreach ($params as $key => $param) {
			$property = $properties[$key];
			if (!empty($this->$property)) {
				$wire->$param = $this->{$property};
			} elseif ($param === 'permission') {
				$wire->$param = [];
			} elseif (in_array($param, ['title', 'slogan'])) {
				$method = 'set' . ucfirst($property);
				if (method_exists($this, $method)) {
					$this->$method();
					$wire->$param = $this->{$property};
				} else {
					$wire->$param = '';
				}
			} else {
				$wire->$param = '';
			}
		}
		$this->wireX = $wire;
	}

}//> end of class ~ ComponentX