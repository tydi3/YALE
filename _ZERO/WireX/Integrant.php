<?php //*** Class::ComponentX ~ Livewire Component » Tydi™ Framework © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//
namespace App\Tydi\Wire;

use App\Tydi\Trait\Live as LiveTrait;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use App\Leoms\FrontendX;
use Livewire\Component;
use App\Spry\StringX;
use App\Spry\DebugX;

abstract class Integrant extends Component
{
	use LiveTrait;

	// • property
	protected $viewCountX = ['create' => 0, 'update' => 0, 'clone' => 0, 'delete' => 0, 'read' => 0, 'list' => 0];
	protected $validViews = ['index', 'landing', 'notify', 'form', 'listing', 'create', 'read', 'update', 'clone', 'delete'];
	public $pathX;
	public $viewX;
	public $titleX;
	public $taglineX;





	// • ==== abstract method → ... »
	abstract protected function initX();
	abstract protected function crudX();
	// abstract protected function paramX($action = null, $input = null, $id = null);
	// abstract protected function validateX($action = null);
	// abstract public function clear($action = null);
	// abstract public function mount(); // » when component is created
	// abstract public function boot();  // » at the beginning of every request
	abstract public function render();




	// • === doRecordX → prepare $record »
	protected function doRecordX($record = null)
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
		return $record;
	}





	// • === doErrorX → ... »
	protected function doErrorX($title, $message)
	{
		$error['title'] = $title;
		$error['message'] = $message;
		return $error;
	}





	// • === setWireRoute → set wire method as route name »
	protected function setWireRoute($wireRoute)
	{
		// Session::put('wireRoute', $wireRoute);
		Session::flash('wireRoute', $wireRoute);
	}





	// • === setViewX → ... »
	protected function setViewX($view)
	{
		$this->viewX = $view;
	}





	// • === setViewIfNot → ... »
	protected function setViewIfNot($view)
	{
		$setView = $this->isNotViewX($view);
		if ($setView) {
			$this->setViewX($view);
		}
	}





	// • === isBladeX → ... »
	protected function isBladeX($blade)
	{
		if (View::exists($blade)) {
			return true;
		}
		return false;
	}





	// • === isViewX → ... »
	protected function isViewX($view)
	{
		if (isset($this->viewX) && $this->viewX === $view) {
			return true;
		}
		return false;
	}





	// • === isNotViewX → ... »
	protected function isNotViewX($view = null)
	{
		if (is_null($view) || empty($view)) {
			if (!isset($this->viewX) || empty($this->viewX)) {
				return true;
			}
		} else {
			if (strtolower($view) !== strtolower($this->viewX)) {
				return true;
			}
		}
		return false;
	}





	// • === containerX → ... »
	protected function containerX($container, $form = true)
	{
		if (StringX::contain($container, '.') && StringX::after($container, '.')) {
			$container = StringX::before($container, '.') . '.container.' . StringX::after($container, '.');
		}

		if (!empty($this->viewX)) {
			if (in_array($this->viewX, $this->validViews)) {
				if ($form === true && $this->isViewX('create') || $this->isViewX('update')) {
					$container .= '.form';
				} else {
					$container .= '.' . $this->viewX;
				}
				return $container;
			}

			$container .= '.' . $this->viewX;
			return $container;
		}
		// TODO: improve error checking before returning
		return $container;
	}





	// • === layoutX → ... »
	protected function layoutX($layout)
	{
		if (StringX::contain($layout, '.') && StringX::after($layout, '.')) {
			$layout = StringX::before($layout, '.') . '.layout.' . StringX::after($layout, '.');
		}
		return $layout;
	}




	// • === bladeX → ... »
	protected function bladeX($container, $layout = null, $path = null, $record = null, $fallback = false, $e404 = true)
	{
		$this->makeBladeX($container, $layout, $path, $fallback);
		return $this->loadBladeX($container, $layout, $record, $e404);
	}






	// • === bladeXFallback → ... »
	protected function bladeXFallback($container, $layout = null, $path = null, $record = null, $e404 = true)
	{
		return $this->bladeX($container, $layout, $path, $record, true, $e404);
	}





	// • === makeBladeX → ... »
	protected function makeBladeX(&$container, &$layout, $path = null, $fallback = false)
	{
		if (!empty($path)) {
			$container = strtolower($path . '.' . $container);
			if (!empty($layout)) {
				$layout = strtolower($path . '.' . $layout);
			}
		}
		$container = $this->containerX($container);

		if (!$this->isBladeX($container)) {
			if ($fallback) {
				$parent = get_class($this);
				if (method_exists($parent, 'fallback')) {
					$container = $this->fallback($container);
				}
			}
		}

		if (!is_null($layout)) {
			$layout = $this->layoutX($layout);
		}
	}






	// • === loadBladeX → ... »
	protected function loadBladeX($container, $layout, $record, $e404 = true)
	{
		$record = $this->doRecordX($container);

		// » e404
		if ($e404) {
			$parent = get_class($this);
			if (method_exists($parent, 'component404')) {
				$this->component404($container, $layout);
			}
		}

		if (!is_null($layout)) {
			if (is_array($record)) {
				return view($container, $record)->layout($layout);
			}
			return view($container)->layout($layout);
		}

		if (is_array($record)) {
			return view($container, $record);
		}

		return view($container);
	}






	// • === clearX :: ... »
	protected function clearX(array $fields)
	{
		if ($this->isViewX('create')) {
			if ($this->viewCountX['create'] > 1) {
				$this->resetPropertyX($fields);
			}
		}
		$this->resetErrorBag();
	}





	// • === refreshX → ... »
	protected function refreshX()
	{
		return $this->dispatch('$refresh');
	}





	// • === reloadX → ... »
	protected function reloadX($method = null, ...$arguments)
	{
		if (!empty($method)) {
			$parent = get_class($this);
			if (method_exists($parent, $method)) {
				return $this->{$method}(...$arguments);
			}
		}
		return $this->redirect(route($this->component), navigate: true);
	}





	// • === gotoX → ... »
	protected function gotoX($name, array $param = null)
	{
		if ($name === 'refresh') {
			return $this->refreshX();
		} elseif ($name === 'reload') {
			return $this->reloadX();
		} elseif (!empty($name)) {
			if (!empty($param)) {
				return $this->redirect(route($name, $param), navigate: true);
			}
			return $this->redirect(route($name), navigate: true);
		}
	}





	// • === createX → ... »
	protected function createX($view = 'create')
	{
		$this->titleX = FrontendX::formatAsTitle($this->component);
		$this->taglineX = 'Create New ' . FrontendX::formatAsTitle($this->component);
		$this->viewCountX['create'] = ($this->viewCountX['create'] ?? 0) + 1;
		$this->setViewIfNot($view);
	}





	// • === listX :: ... »
	protected function listingX($view = 'listing', $record = null)
	{
		$this->titleX = FrontendX::formatAsTitle($this->component);
		$this->taglineX = 'List Of ' . FrontendX::formatAsTitle(Str::plural($this->component));
		$this->viewCountX['list'] = ($this->viewCountX['list'] ?? 0) + 1;
		$this->setViewIfNot($view);
		if (!empty($record)) {
			$this->setRecordX($record);
		}
	}





	// • === listAllX :: ... »
	protected function listAllX($view = 'listing')
	{
		$record = $this->modelX::all();
		$this->listingX($view, $record);
	}





	// • === readX → ... »
	protected function readX($view = 'read', $record = null)
	{
		$this->titleX = FrontendX::formatAsTitle($this->component);
		$this->taglineX = 'View ' . FrontendX::formatAsTitle($this->component) . ' Details';
		$this->viewCountX['read'] = ($this->viewCountX['read'] ?? 0) + 1;
		$this->setViewIfNot($view);
		if (!empty($record)) {
			$this->setRecordX($record);
		}
	}





	// • === updateX → ... »
	protected function updateX($view = 'update', $record = null)
	{
		$this->titleX = FrontendX::formatAsTitle($this->component);
		$this->taglineX = 'Modify ' . FrontendX::formatAsTitle($this->component);
		$this->viewCountX['update'] = ($this->viewCountX['update'] ?? 0) + 1;
		$this->setViewIfNot($view);
		if (!empty($record)) {
			$this->setRecordX($record);
		}
	}





	// • === deleteX → ... »
	protected function deleteX($view = 'delete', $record = null)
	{
		$this->titleX = FrontendX::formatAsTitle($this->component);
		$this->taglineX = 'Delete ' . FrontendX::formatAsTitle($this->component);
		$this->viewCountX['delete'] = ($this->viewCountX['delete'] ?? 0) + 1;
		$this->setViewIfNot($view);
		if (!empty($record)) {
			$this->setRecordX($record);
		}
	}
}//> end of Class::ComponentX
