<?php //*** WireX ~ abstract » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Wire;

use Yale\Anci\EnvX;
use Yale\Anci\DebugX;
use Livewire\Component;
use Yale\Xeno\File\FileX;
use Yale\Xeno\Data\StringX;
use Illuminate\Support\Facades\Session;

abstract class WireX extends Component
{
	// ◈ property
	protected $componentX;
	protected $moduleX;
	protected $permissionX;
	public $wireX;



	// ◈ === callMethodX »
	protected function callMethodX($method, ...$arguments)
	{
		if (method_exists($this, $method)) {
			return $this->$method(...$arguments);
		}
	}



	// ◈ === flashX »
	protected function flashX($key, $message, $persist = false)
	{
		// ~ requests available until session is cleared or data overwritten
		if ($persist) {
			Session::put($key, $message);
		} else {
			// ~ next request only
			Session::flash($key, $message);
		}
	}



	// ◈ === successX »
	protected function successX($message = null, $title = 'successful', $persist = false)
	{
		if (empty($message)) {
			$message = 'action completed successfully.';
		}
		$this->flashX($message, $persist);
	}



	// ◈ === formatBladeX »
	protected function formatBladeX(string $blade, bool|string $theme = true, ?string $path = null)
	{
		if (!empty($blade)) {
			$o = '';

			// ~ theme
			if ($theme === true) {
				$o .= EnvX::project('theme') . '.';
			} else {
				$o .= $theme;
				if (StringX::notEndWith($theme, '.')) {
					$o .= '.';
				}
			}

			// ~ path
			if (!empty($path)) {
				$o .= $path;
				if (StringX::notEndWith($path, '.')) {
					$o .= '.';
				}
			}
			$blade = $o . $blade;
			return strtolower($blade);
		}
		return null;
	}



	// ◈ === getClassX »
	protected function getClassX()
	{
		return basename(get_class($this));
	}



	// ◈ === getViewX »
	protected function getViewX()
	{
		if (!empty($this->viewX)) {
			return $this->viewX;
		}
		return null;
	}



	// ◈ === getLayoutX »
	protected function getLayoutX()
	{
		if (!empty($this->layoutX)) {
			return $this->layoutX;
		}
		return null;
	}



	// ◈ === getRecordX »
	protected function getRecordX($return = 'object')
	{
		if (!empty($this->recordX)) {
			return $this->recordX;
		}

		if ($return === 'object') {
			return new \stdClass();
		}
		return [];
	}



	// ◈ === getComponentX »
	protected function getComponentX()
	{
		if (!empty($this->componentX)) {
			return $this->componentX;
		}
		return null;
	}



	// ◈ === getModuleX »
	protected function getModuleX()
	{
		if (!empty($this->moduleX)) {
			return $this->moduleX;
		}
		return null;
	}



	// ◈ === getPropertyX »
	protected function getPropertyX($property)
	{
		if (!empty($property) && isset($this->{$property})) {
			return $this->{$property};
		}
		return null;
	}



	// ◈ === setComponentX »
	protected function setComponentX(?string $component = null)
	{
		if (empty($component)) {
			$component = $this->getClassX();
		}

		if (!empty($component)) {
			$this->componentX = strtolower($component);
		}
	}



	// ◈ === setModuleX »
	protected function setModuleX(bool|string $module = true)
	{
		if ($module === true) {
			if (!empty($this->componentX)) {
				$module = StringX::firstWord($this->componentX);
			}
		}

		if (!empty($module)) {
			$this->moduleX = $module;
		}
	}



	// ◈ === setPermissionX »
	protected function setPermissionX(array $permission = [])
	{
		if (!$this->permissionX) {
			$this->permissionX = [];
		}
		if (!empty($permission)) {
			$this->permissionX = array_merge($this->permissionX, $permission);
		}
	}



	// ◈ === setPropertyX »
	protected function setPropertyX(array $property = [])
	{
		if (!empty($property) && is_array($property)) {
			foreach ($property as $key => $value) {
				$this->{$key} = $value;
			}
		}
	}



	// ◈ === setWireX »
	protected function setWireX()
	{
		// ~ new object
		if (!isset($this->wireX)) {
			$this->wireX = new \stdClass();
		}

		$wire = $this->wireX;
		$params = ['route', 'component', 'module', 'action', 'title', 'slogan', 'permission', 'id'];
		$properties = array_map(
			function ($param) {
				return $param . 'X';
			},
			$params
		);

		foreach ($params as $key => $param) {
			$property = $properties[$key];
			if (!empty($this->$property)) {
				$wire->{$param} = $this->{$property};
			} else {
				if($param === 'permission'){
				$wire->$param = [];
				} else {
					$wire->$param = '';
				}
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
				$this->callMethodX('setActionX', $value);
			}
		}
	}



	// ◈ === isBladeX »
	protected function isBladeX(?string $blade)
	{
		if (!empty($blade) && (FileX::is()->blade($blade))) {
			return true;
		}
		return false;
	}



	// ◈ === isViewX » check if view or view set is valid blade
	protected function isViewX(?string $view = '')
	{
		if (!$view || empty($view)) {
			$view = $this->getViewX();
		}
		return $this->isBladeX($view);
	}



	// ◈ === isLayoutX » check if layout or layout set is valid blade
	protected function isLayoutX(?string $layout = '')
	{
		if (!$layout || empty($layout)) {
			$layout = $this->getLayoutX();
		}
		return $this->isBladeX($layout);
	}



	// ◈ === inPermissionX »
	protected function inPermissionX($permission)
	{
		if (!empty($permission) && !empty($this->permissionX)) {
			return in_array($permission, $this->permissionX);
		}
		return false;
	}



	// ◈ === checkBladeX »
	protected function checkBladeX(?string $blade, $label = 'bladeX')
	{
		if (!$this->isBladeX($blade)) {
			return DebugX::blade404($blade, $label);
		}
	}



	// ◈ === checkViewX »
	protected function checkViewX(?string $view = null, $label = 'viewX')
	{
		if (empty($view)) {
			$view = $this->getViewX();
		}
		return self::checkBladeX($view, $label);
	}



	// ◈ === checkLayoutX »
	protected function checkLayoutX(?string $layout = null, $label = 'layoutX')
	{
		if (empty($layout)) {
			$layout = $this->getLayoutX();
		}
		return self::checkBladeX($layout, $label);
	}



	// ◈ === doRenderX »
	protected function doRenderX(string $view, ?string $layout = null, array|object|null $record = null)
	{
		if (empty($record)) {
			$record = $this->getRecordX();
		}

		if (!empty($layout)) {
			$render = view($view, ['recordX' => $record])->layout($layout);
		} else {
			$render = view($view, ['recordX' => $record]);
		}
		return $render;
	}

}//> end of abstract ~ WireX