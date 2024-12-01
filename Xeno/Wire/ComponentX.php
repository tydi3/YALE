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
	protected $idX;
	public $wireX;



	// ◈ === callMethodX »
	protected function callMethodX($method, ...$arguments)
	{
		if (method_exists($this, $method)) {
			return $this->$method(...$arguments);
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



	// ◈ === notifyX »
	protected function notifyX($key, $value, $persist = false)
	{
		if ($persist) {
			Session::put($key, $value);
		} else {
			Session::flash($key, $value);
		}
	}



	// ◈ === redirectX → ... »
	protected function redirectX($url = null)
	{
		// if (is_null($url)) {
		// 	route($this->component);
		// }
		return $this->redirect($url, navigate: true);
	}



	// ◈ === gotoX »
	protected function gotoX($destination, array $param = null)
	{
		if ($destination === 'refresh') {
			return $this->refreshX();
		} elseif ($destination === 'reload') {
			return $this->reloadX();
		} elseif (!empty($destination)) {
			if (!empty($param)) {
				// TODO  improve code
				return $this->redirect(RouteX:: as($destination, $param), navigate: true);
			}
			return $this->redirect(RouteX:: as($destination), navigate: true);
		}
	}



	// ◈ === resolveX »
	protected function resolveX($action, $result = null, $next = null)
	{
		if ($action === 'update') {
			// ~ success
			if ($result) {
				$this->doSuccessX();
				if ($next) {
					// return $this->gotoX($next);
					return $this->redirectX($next);
				}
			}
		}
	}



	// ◈ === asClassX »
	public function asClassX()
	{
		return basename(get_class($this));
	}



	// ◈ === asBladeX »
	// protected function asBladeX(string $blade, bool $theme = true)
	// {
	// 	if (!empty($blade)) {
	// 		if ($theme) {
	// 			$blade = EnvX::project('theme') . '.' . $blade;
	// 		}
	// 		return strtolower($blade);
	// 	}
	// }



	// ◈ === asComponentX »
	protected function asComponentX(?string $component = null)
	{
		if (empty($component)) {
			$component = $this->asClassX();
		}
		return strtolower($component);
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



	// ◈ === checkBladeX »
	// protected function checkBladeX($blade)
	// {
	// 	if (!empty($blade)) {
	// 		if (!FileX::is()->blade($blade)) {
	// 			return DebugX::blade404($blade);
	// 		}
	// 	}
	// }



	// // ◈ === checkViewX »
	// protected function checkViewX()
	// {
	// 	if (!empty($this->viewX)) {
	// 		return self::checkBladeX($this->viewX);
	// 	}
	// }



	// // ◈ === checkLayoutX »
	// protected function checkLayoutX()
	// {
	// 	if (!empty($this->layoutX)) {
	// 		return self::checkBladeX($this->layoutX);
	// 	}
	// }



	// ◈ === grabIdX »
	protected function grabIdX($id = null)
	{
		if (!empty($id) && empty($this->idX)) {
			self::setIdX($id);
		}

		if (!empty($this->idX)) {
			return $this->idX;
		}

		// TODO: build an error handler for when $id is expected or record is not found
		DebugX::oversight($this->moduleX, 'id parameter not found');
	}



	// ◈ === setIdX »
	protected function setIdX($id = null)
	{
		if (!empty($id)) {
			$this->idX = $id;
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
		if (is_array($record)) {
			$record = ArrayX::toObject($record);
		}
		$this->recordX = $record;
	}



	// ◈ === setPropertyX »
	protected function setPropertyX(array $property = [])
	{
		if (!empty($property)) {
			foreach ($property as $key => $value) {
				$this->{$key} = $value;
			}
		}
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
		if (empty($slogan) && !empty($this->moduleX) && !empty($this->actionX) && $this->actionX !== 'initial') {
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
	protected function setActionCountX($action, $number = 1, $increment = true)
	{
		if ($increment === true) {
			return $this->actionCountX($action, 'increment', $number);
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
		$params = ['route', 'component', 'module', 'action', 'title', 'slogan', 'permission', 'id'];
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
	protected function setWireRouteX($route, $persist = true, $component = true)
	{
		$routeIs = $route;
		if ($component === true) {
			$routeIs = $this->componentX;
			if ($route !== 'initial') {
				$routeIs .= '.' . $route;
			}
		}

		// ~ requests available until session is cleared or data overwritten
		if ($persist) {
			Session::put('wireRouteX', $routeIs);
		} else {
			// ~ next request only
			Session::flash('wireRouteX', $routeIs);
		}
	}



	// ◈ === doSuccessX »
	protected function doSuccessX($message = 'success', $persist = false)
	{
		if ($persist) {
			Session::put('successX', $message);
		} else {
			Session::flash('successX', $message);
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

}//> end of class ~ ComponentX