<?php //*** Class::ComponentX ~ Livewire Component » Tydi™ Framework © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//
namespace App\Spry\WireX;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use App\Leoms\FrontendX;
use Livewire\Component;
use App\Spry\StringX;
use App\Spry\DebugX;

abstract class ComponentX extends Component
{
	use LiveX;

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





	// • === redirectX → ... »
	protected function redirectX($url = null)
	{
		if (is_null($url)) {
			route($this->component);
		}
		return $this->redirect($url);
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





	// • === cloneX → ... »
	protected function cloneX($view = 'clone', $record = null)
	{
		$this->titleX = FrontendX::formatAsTitle($this->component);
		$this->taglineX = 'Clone as new ' . FrontendX::formatAsTitle($this->component);
		$this->viewCountX['clone'] = ($this->viewCountX['clone'] ?? 0) + 1;
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
