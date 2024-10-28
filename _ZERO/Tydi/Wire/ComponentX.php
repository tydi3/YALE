<?php //*** ComponentX ~ abstract » Yaic™ Library for Laravel © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace App\Yaic\Tydi\Wire;

use Livewire\Component;
use App\Yaic\Anci\EnvX;
use App\Yaic\Anci\DebugX;
use App\Yaic\Tydi\Data\StringX;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

abstract class ComponentX extends Component
{
	// ◈ property
	public $titleX;
	public $taglineX;



	// • Record Data
	public $puid;


	public $dataX; // array of public properties
	public $e404X;
	public $viewX;
	public $recordX;
	protected $pathX;
	protected $modelX;
	protected $routeX;
	public $actionX;
	protected $statusX;
	//['success', 'error', 'warning', 'notice', 'info']
	public $moduleX;
	protected $componentX;
	protected $onSaveLabelX;



	// ◈ === abstract »
	abstract protected function initX();
	// abstract public function render();
	// abstract public function crudX();
	// abstract public function boot();
	// abstract public function mount();
	// abstract public function clear($action = null);
	// abstract protected function validateX($action = null);
	// abstract protected function paramX($action = null, $input = null, $id = null);



	// ◈ === mount » once per lifecycle
	public function mount()
	{
		$methods = ['igniteX', 'initX', 'defaultViewX', 'viewAutoX'];
		foreach ($methods as $method) {
			if (method_exists($this, $method)) {
				$this->$method();
			}
		}
	}



	// ◈ === boot » once per request
	public function boot()
	{
		$methods = ['bootX', 'modelX', 'initX'];
		foreach ($methods as $method) {
			if (method_exists($this, $method)) {
				$this->$method();
			}
		}
	}



	// ◈ === render »
	public function render()
	{
		$this->setPathX();
		$parent = new (get_class($this));
		if (method_exists($parent::class, 'pageX')) {
			return $this->pageX();
		}
	}



	// ◈ === historyX :: ... »
	public function historyX()
	{
		// NOTE: Non-tested code
		return redirect()->back();
	}



	// ◈ === viewX »
	protected function viewX($blade = null, $layout = null, $theme = null, $directory = null, $record = null, $fallback = false, $check404 = true)
	{
		// NOTE: [PREMISE] → $this->setPathX() has been called
		$theme = $theme ?: (!empty($this->pathX['theme']) ? $this->pathX['theme'] : $theme);
		$layout = $layout ?: (!empty($this->pathX['layout']) ? $this->pathX['layout'] : $layout);
		$blade = $blade ?: (!empty($this->componentX) ? $this->componentX : 'http.501');
		$this->toViewX($blade, $layout, $theme, $directory);
		return $this->loadViewX($blade, $layout, $record, $fallback, $check404);
	}



	// ◈ === htmlX :: ... »
	public function htmlX($content)
	{
		// $content = HtmlX::nl2pbr($content);
		// return new HtmlString($content);
	}



	// ◈ === sparkX » performs all ignition requirement where applicable
	protected function sparkX()
	// NOTE: method is useful and effective when method is called directly from route
	{
		if (empty($this->routeX)) {
			$this->setRouteX();
		}

		if (empty($this->moduleX) || empty($this->actionX)) {
			$this->setModuleActionX();
		}

		if (empty($this->componentX)) {
			$this->setComponentX();
		}
	}



	// ◈ === callMethodX »
	protected function callMethodX($method, ...$params)
	{
		if (method_exists($this, $method)) {
			call_user_func_array([$this, $method], $params);
		}
	}



	// ◈ === setRecordX »
	protected function setRecordX($record = null)
	{
		$this->recordX = $record;
	}



	// ◈ === setStatusX »
	protected function setStatusX($status)
	{
		$this->statusX = $status;
	}



	// ◈ === setActionX »
	protected function setActionX($action)
	{
		$this->actionX = $action;
	}



	// ◈ === isBladeX »
	protected function isBladeX($file): bool
	{
		return View::exists($file);
	}



	// ◈ === isViewX » is $this->view set and/or is value equal to $view
	protected function isViewX($view = null): bool
	{
		if (empty($view)) {
			return !empty($this->viewX);
		} elseif (isset($this->viewX)) {
			return (strtolower($this->viewX) === strtolower($view));
		}
		return false;
	}



	// ◈ === isViewX »
	protected function isNotViewX($action = null)
	{
		if (empty($action)) {
			return empty($this->viewX);
		} else {
			if (isset($this->viewX)) {
				return (strtolower($this->viewX) !== strtolower($action));
			}
			return true;
		}
		return false;
	}



	// ◈ === isAnyViewX »
	protected function isAnyViewX(array $views = [])
	{
		if (!empty($views)) {
			foreach ($views as $view) {
				if ($this->isViewX($view)) {
					return true;
				}
			}
		}
		return false;
	}



	// ◈ === makeErrorX »
	protected function makeErrorX($error, $label = 'errorX')
	{
		if (is_array($error)) {
			$error = json_encode($error);
		}
		$this->addError($label, $error);
	}



	// ◈ === fallbackOnX »
	protected function fallbackOnX($blade = null, $fallbackOn = null)
	{
		if (!empty($blade)) {
			$fallbackOn = $fallbackOn ?? (!empty($this->viewsAllowedX) ? $this->viewsAllowedX : $fallbackOn);
			if (!empty($fallbackOn) && StringX::endWithAny($blade, $fallbackOn)) {
				if (is_subclass_of(static::class, PageX::class)) {
					$path = '.page';
				} elseif (is_subclass_of(static::class, ShardX::class)) {
					$path = '.shard';
				} elseif (is_subclass_of(static::class, WidgetX::class)) {
					$path = '.widget';
				}
				$blade = $this->pathX['theme'] . $path . '.fallback';
			}
		}
		return $blade;
	}



	// ◈ === check404X »
	private function check404X($blade, $layout = null)
	{
		$error = false;
		$component = '';
		if (is_subclass_of(static::class, PageX::class)) {
			$component = 'page';
		} elseif (is_subclass_of(static::class, ShardX::class)) {
			$component = 'shard';
		} elseif (is_subclass_of(static::class, WidgetX::class)) {
			$component = 'widget';
		}
		$report['component'] = $component;

		// @ layout - 404
		if (!empty($layout) && !$this->isBladeX($layout)) {
			$report['layout'] = $layout;
		}

		// @ component - 404
		if (!empty($blade) && !$this->isBladeX($blade)) {
			$report['blade'] = $blade;
		}

		if (!empty($report['layout'])) {
			return DebugX::blade404($layout, 'Layout');
		}

		if (!empty($report['blade'])) {
			$error = true;
			$view = StringX::swapFirst($blade, '.' . $component . '.', '.');
			if (!empty($this->pathX['theme'])) {
				$view = StringX::swapFirst($view, $this->pathX['theme'] . '.');
			}
			$report['view'] = $view;
			$this->e404X = $report;

			$file = $blade . '.404';
			if ($this->isBladeX($file)) {
				return $file;
			}

			if (!empty($component)) {
				$file = $this->pathX['theme'] . '.' . $component . '.http.404';
				if ($this->isBladeX($file)) {
					return $file;
				}
			}

			$file = StringX::swapLast($blade, '.' . $view, '.404');
			if ($this->isBladeX($file)) {
				return $file;
			}
		}

		return $blade;
	}



	// ◈ === setRouteX »
	protected function setRouteX($route = null)
	{
		if (empty($route)) {
			$this->routeX = Route::currentRouteName();
		} else {
			$this->routeX = $route;
		}
	}



	// ◈ === setComponentX »
	protected function setComponentX($component = null)
	{
		$this->componentX = !empty($component) ? $component : (!empty($this->moduleX) ? $this->moduleX : $this->componentX);
	}



	protected function setModuleActionX($module = null, $action = null)
	{
		if (!empty($module)) {
			$this->moduleX = $module;
		} elseif (!empty($this->routeX)) {
			// NOTE: PREMISE ($this->routeX is set)
			$route = $this->routeX;

			if (StringX::in($route, '-')) {
				$this->moduleX = StringX::before($route, '-');
				if (empty($action)) {
					$action = StringX::afterLast($route, '-');
				}
			} elseif (StringX::in($route, '_')) {
				$this->moduleX = StringX::before($route, '_');
				if (empty($action)) {
					$action = StringX::afterLast($route, '_');
				}
			} elseif (StringX::in($route, '.')) {
				$this->moduleX = StringX::before($route, '.');
				if (empty($action)) {
					$action = StringX::afterLast($route, '.');
				}
			} else {
				$this->moduleX = $this->routeX;
			}
		}

		if (!empty($action)) {
			$this->actionX = $action;
		}
	}



	// ◈ === setPathX »
	protected function setPathX(array $paths = [])
	{
		foreach ($paths as $path => $value) {
			$method = 'set' . ucfirst($path) . 'PathX';
			if (method_exists($this, $method)) {
				$this->{$method}($value);
			}
		}

		if (empty($this->pathX['theme'])) {
			$this->setThemePathX();
		}
		if (empty($this->pathX['layout'])) {
			$this->setLayoutPathX();
		}
		if (empty($this->pathX['slab'])) {
			$this->setSlabPathX();
		}
	}



	// ◈ === setViewX »
	protected function setViewX($view)
	{
		$this->viewX = $view;
	}



	// ◈ === setViewIfNotX »
	protected function setViewIfNotX($view)
	{
		if ($this->isNotViewX($view)) {
			$this->setViewX($view);
		}
	}



	// ◈ === asWireRoute » set wire method as route name
	protected function setWireRouteX($action = null, $component = null)
	{
		if (empty($component)) {
			$component = $component ?? (!empty($this->componentX) ? $this->componentX : null);
		}
		$wireRoute = '';
		if (!empty($component)) {
			$wireRoute .= $component;
		}
		if (!empty($action)) {
			if (!empty($wireRoute)) {
				$wireRoute .= '-';
			}
			$wireRoute .= $action;
		}

		// ~Session::put('wireRoute', $wireRoute);
		Session::flash('wireRoute', $wireRoute);
	}



	// ◈ === setThemePathX »
	private function setThemePathX($theme = null)
	{
		$envTheme = EnvX::project('theme');
		$formattedTheme = !empty($envTheme) ? strtolower($envTheme) : '';
		$this->pathX['theme'] = !empty($theme) ? $theme : ($this->pathX['theme'] ?? $formattedTheme);
	}



	// ◈ === setLayoutPathX »
	private function setLayoutPathX($layout = null)
	{
		$envLayout = EnvX::project('layout');
		$formattedLayout = !empty($envLayout) ? strtolower($envLayout) : '';
		$this->pathX['layout'] = !empty($layout) ? $layout : ($this->pathX['layout'] ?? $formattedLayout);

		// NOTE: further cleanup on [PREMISE] theme has been set (we set layout to main if name is same as theme)
		if (empty($layout) && !empty($this->pathX['theme']) && (strtolower($this->pathX['theme']) === strtolower($this->pathX['layout']))) {
			$this->pathX['layout'] = 'main';
		}
	}



	// ◈ === setSlabPathX »
	private function setSlabPathX($slab = null)
	{
		$oSlab = !empty($this->pathX['theme']) ? $this->pathX['theme'] . '.slab' : 'slab';
		$this->pathX['slab'] = !empty($slab) ? $slab : ($this->pathX['slab'] ?? $oSlab);
	}



	// ◈ === setPropertyX »
	private function setPropertyX($attributes)
	{
		if (is_array($attributes)) {
			foreach ($attributes as $property => $value) {
				if (property_exists($this, $property)) {
					$this->$property = $value;
				}
			}
		}
	}



	// ◈ === setObjectAsProperty »
	private function setObjectAsProperty($object, $properties, $defined = false)
	{
		foreach ($properties as $property) {
			if (isset($object->$property)) {
				if ($defined && property_exists($this, $property)) {
					$this->$property = $object->$property;
				} else {
					$this->$property = $object->$property;
				}
			}
		}
	}



	// ◈ === igniteX »
	protected function igniteX()
	{
		$this->setRouteX();
		$this->setModuleActionX();
	}



	// ◈ === toRecordX » prepare $record
	private function toRecordX(&$record = null): array|null
	{
		if (!empty($record)) {
			if (!is_array($record) && !is_object($record)) {
				$record = ['record' => $record];
			}
			// elseif(is_array($record)){
			// 	$object = new \stdClass();
			// 	foreach ($record as $key => $value) {
			// 		$object->$key = $value;
			// 	}
			// 	$record = $object;
			// }
			// TODO: Implement improvement as we are checking for string, and assuming at this point we have an array
		}

		$record = $record ?? [];
		return $record;
	}



	// ◈ === toErrorX » prepare error as array
	private function toErrorX($title = 'Error', $message = 'An error occurred'): array
	{
		return ['title' => $title, 'message' => $message];
	}



	// ◈ === toLayoutX » prepare $layout
	private function toLayoutX(&$layout): string
	{
		if (StringX::surround($layout, '.')) {
			$layout = StringX::swapFirst($layout, '.', '.layout.');
		}
		return $layout;
	}



	// ◈ === toBladeX » prepare blade
	private function toBladeX($blade, $directory = null, $checkForm = true)
	{

		$hasDirectory = StringX::afterFirst($blade, '.');
		if (!empty($hasDirectory)) {
			$path = StringX::beforeAs($blade, '.');
			if (!empty($directory)) {
				$path .= '.' . $directory;
			}
			$path .= '.' . $hasDirectory;
			$blade = $path;
		} else {
			// TODO: test & implement code
		}
		if (!empty($this->viewX)) {
			if (in_array($this->viewX, $this->viewsAllowedX)) {
				if ($checkForm === true && ($this->isAnyViewX(['create', 'update', 'clone']))) {
					$blade .= '.form';
					// } elseif ($this->isViewX('notify')) {
					// 	$blade .= '.notify';
					// } elseif ($this->isViewX('error')) {
					// 	$blade .= '.error';
					// } elseif ($this->isViewX('read')) {
					// 	$blade .= '.read';
					// } elseif ($this->isViewX('letter')) {
					// 	$blade .= '.letter';
				} else {
					$blade .= '.' . $this->viewX;
				}
				return $blade;
			}

			$blade .= '.' . $this->viewX;
			return $blade;
		}
		// TODO: improve error checking before returning
		return $blade;
	}



	// ◈ === toViewX » prepare view for rendering
	private function toViewX(&$blade, &$layout, $theme = null, $directory = null)
	{
		if (!empty($theme)) {
			$blade = strtolower($theme . '.' . $blade);
			if (!empty($layout)) {
				$layout = strtolower($theme . '.' . $layout);
			}
		}
		$blade = $this->toBladeX($blade, $directory);
		if (!is_null($layout)) {
			$layout = $this->toLayoutX($layout);
		}
	}



	// ◈ === loadViewX »
	private function loadViewX($blade, $layout, $record, $fallback = false, $check404 = true)
	{
		$this->toRecordX($record);
		if ($fallback) {
			if (!$this->isBladeX($blade)) {
				$parent = new (get_class($this));
				if (method_exists($parent::class, 'fallbackBladeX')) {
					$blade = $this->fallbackBladeX($blade);
				}
			}
		}

		if ($check404) {
			$parent = new (get_class($this));
			if (method_exists($parent, 'check404X')) {
				$blade = $this->check404X($blade, $layout);
			}
		}

		if (!$this->isBladeX($blade)) {
			return DebugX::blade404($blade);
		}

		if (!is_null($layout)) {
			return view($blade, $record)->layout($layout);
		}

		return view($blade, $record);
	}


}//> end of abstract ~ ComponentX