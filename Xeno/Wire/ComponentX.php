<?php //*** ComponentX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\Wire;

use Yale\Anci\EnvX;
use Yale\Anci\DebugX;
use Livewire\Component;
use Yale\Xeno\File\FileX;
use Yale\Xeno\Data\ArrayX;
use Yale\Xeno\Data\StringX;
use Illuminate\Support\Facades\Session;

abstract class ComponentX extends Component
{
	// ◈ property
	protected $componentX;
	protected $moduleX;
	protected $actionX;
	protected $titleX;
	protected $sloganX;
	protected $permissionX = [];
	protected $recordX = [];
	public $wireX;



	// ◈ === asClassX »
	public function asClassX()
	{
		return basename(get_class($this));
	}



	// ◈ === asBladeX »
	protected function asBladeX(string $blade, bool $theme = true)
	{
		if (!empty($blade)) {
			if ($theme) {
				$blade = EnvX::project('theme') . '.' . $blade;
			}
			return strtolower($blade);
		}
	}



	// ◈ === asComponentX »
	protected function asComponentX(?string $component = null)
	{
		if (empty($component)) {
			$component = $this->asClassX();
		}
		return strtolower($component);
	}



	// ◈ === checkBladeX »
	protected function checkBladeX($blade)
	{
		if (!empty($blade)) {
			if (!FileX::is()->blade($blade)) {
				return DebugX::blade404($blade);
			}
		}
	}



	// ◈ === checkViewX »
	protected function checkViewX()
	{
		if (!empty($this->viewX)) {
			return self::checkBladeX($this->viewX);
		}
	}



	// ◈ === checkLayoutX »
	protected function checkLayoutX()
	{
		if (!empty($this->layoutX)) {
			return self::checkBladeX($this->layoutX);
		}
	}



	// ◈ === setComponentX »
	protected function setComponentX(?string $component = null)
	{
		$this->componentX = $this->asComponentX($component);
	}



	// ◈ === setRecordX »
	protected function setRecordX(array|object|null $record = null)
	{
		if (empty($record)) {
			$record = [];
		}
		// if (is_array($record)) {$record = ArrayX::toObject($record);}
		$this->recordX = $record;
	}



	// ◈ === setTitleX »
	protected function setTitleX(?string $title = null)
	{
		if (empty($title) && !empty($this->moduleX)) {
			$title = $this->moduleX;
		}
		$this->titleX = $title;
	}



	// ◈ === setSloganX »
	protected function setSloganX(?string $slogan = null)
	{
		if (empty($slogan) && !empty($this->moduleX) && !empty($this->actionX) && $this->actionX !== 'index') {
			$slogan = $this->actionX . ' ' . $this->moduleX;
			if ($this->actionX === 'detail') {
				$slogan = 'review ' . $this->moduleX . ' details';
			} elseif ($this->actionX === 'listing') {
				$slogan = 'list of ' . StringX::plural($this->moduleX);
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



	// ◈ === setActionX »
	protected function setActionX(?string $action = null)
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
		$this->actionX = strtolower($action);
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



	// ◈ === setIfNotX »
	protected function setIfNotX($property, $value)
	{
		//~ $this->actionX
		if ($property === 'action') {
			if (empty($this->actionX) || $this->actionX !== $value) {
				$this->setActionX($value);
			}
		}
	}



	// ◈ === setWireRouteX → set wire method as route name »
	protected function setWireRouteX($route, $persist = true)
	{
		// ~ requests available until session is cleared or data overwritten
		if ($persist) {
			Session::put('wireRouteX', $route);
		} else {
			// ~ next request only
			Session::flash('wireRouteX', $route);
		}
	}



	// ◈ === doRenderX »
	protected function doRenderX(string $view, ?string $layout = null, array|object|null $record = null)
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

}//> end of class ~ ComponentX