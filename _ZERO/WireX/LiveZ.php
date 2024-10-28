<?php //*** Trait::WireX ~ Livewire Component » Tydi™ Framework © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//
namespace App\Tydi\Trait;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\HtmlString;
// use Illuminate\Support\Str;
use App\Spry\CollectionX;
use App\Spry\HandlerX;
use App\Tydi\Spry\StringX;
use App\Spry\InputX;
use App\Tydi\Spry\ArrayX;
use App\Spry\HtmlX;

trait Live
{
	// • property
	protected $validStatus = ['success', 'error', 'warning', 'notice', 'info'];
	protected $component;
	protected $modelX;
	public $routeX;
	public $moduleX;
	public $crudX;
	public $errorX;
	public $actionX;
	public $recordX;
	public $statusX;

	public $id;
	public $puid;
	public $author;
	public $status;

	public $oRow;
	public $oRows;
	public $oChildRows;
	public $oRowsCount;
	public $oChildRowsCount;



	// • === fireX → ... »
	protected function fireX()
	{
		$this->routeX = Route::currentRouteName();
		$this->moduleX = StringX::beforeAs($this->routeX, '-');
	}





	// • ==== isX → ... »
	protected function isX($component = null)
	{
		$component = is_null($component) && !empty($this->moduleX) ? $this->moduleX : $component;
		$this->component = !empty($component) ? $component : $this->component;
	}





	// • === htmlX → ... »
	protected function htmlX($str)
	{
		$html = HtmlX::nl2brp($str);
		return new HtmlString($html);
	}





	// • === routerX → ... »
	protected function routerX($route = null, $auto = false)
	{
		if (is_null($route)) {
			$route = $this->routeX ?? 'landing';
		}
		$this->setRouteViewX($route, $auto);
	}





	// • === routerXAuto → ... »
	protected function routerXAuto($route = null)
	{
		return $this->routerX($route, true);
	}





	// • === grabID → ... »
	protected function grabID($id = null)
	{
		if (!empty($this->id)) {
			return $this->id;
		} elseif (!empty($id)) {
			return $id;
		}
		return false;
	}





	// • === hasPuid → ... »
	protected function hasPuid()
	{
		if (!empty($this->puid)) {
			return $this->puid;
		}
		return false;
	}





	// • === hasRows → ... »
	protected function hasRows()
	{
		if (isset($this->oRows) && CollectionX::is($this->oRows)) {
			return ($this->oRows->isEmpty() === false);
		}
		return false;
	}





	// • === hasRow → ... »
	protected function hasRow()
	{
		if (isset($this->oRow) && CollectionX::is($this->oRow)) {
			return ($this->oRow->isEmpty() === false);
		}
		return false;
	}







	// • === setRouteViewX → ... »
	protected function setRouteViewX($route, $auto = false)
	{
		$component = $this->component;
		$method = StringX::afterFirstAs($this->routeX, '-');
		$view = $route;
		if ($auto === true) {
			if ($method !== $component) {
				// Todo:: improve code to handle multiple hyphens and camelCase methods
				$view = $method;
			}
		}
		$view = $view ?? 'landing';
		if ($this->isNotViewX($view)) {
			if ($view === 'landing') {
				if (method_exists($this, 'landing')) {
					return $this->landing();
				} elseif (method_exists($this, 'index')) {
					return $this->index();
				}
			} else {
				if (method_exists($this, $view)) {
					return $this->{$view}();
				} else {
					return $this->setViewX($view);
				}
			}
		}
	}





	// • === setRecordX → ... »
	protected function setRecordX($record = null)
	{
		$this->recordX = self::doRecordX($record);
	}





	// • === setErrorX → ... »
	protected function setErrorX($error, $label = 'errorX')
	{
		if (is_array($error)) {
			$error = json_encode($error);
		}
		$this->addError($label, $error);
	}





	// • === setCrudX → ... »
	protected function setCrudX($actions = null)
	{
		if (is_null($actions)) {
			$actions = [];
		}
		if (is_string($actions)) {
			if (StringX::contain($actions, ',')) {
				$actions = StringX::toArray($actions, ',');
			} else {
				$actions = StringX::toArray($actions, 'SPACE');
			}
		}
		$this->crudX = $actions;
	}





	// • === setActionX → ... »
	protected function setActionX($action)
	{
		$this->actionX = $action;
	}





	// • === setStatusX → ... »
	protected function setStatusX($status)
	{
		$this->statusX = $status;
	}





	// • === setPropertyX → ... »
	protected function setPropertyX($attribute)
	{
		if (is_array($attribute) || is_object($attribute)) {
			foreach ($attribute as $property => $value) {
				if (property_exists($this, $property)) {
					$this->$property = $value;
				}
			}
		}
	}





	// • === clearPropertyX → ... »
	protected function clearPropertyX($property, $default = false)
	{
		$merge = [];
		if ($default === true) {
			$merge = ['id', 'guid', 'puid', 'suid', 'tuid', 'status'];
		}
		if (is_array($property)) {
			$property = array_merge($merge, $property);
			foreach ($property as $key) {
				if (property_exists($this, $key)) {
					$this->$key = '';
				}
			}
		} else {
			if (property_exists($this, $property)) {
				$this->$property = '';
			}
		}
	}





	// • === resetPropertyX → ... »
	protected function resetPropertyX($property)
	{
		if (is_string($property)) {
			if (isset($this->$property)) {
				$this->reset([$property]);
			}
		} elseif (is_array($property)) {
			foreach ($property as $key => $value) {
				if (!isset($this->$key)) {
					unset($property[$key]);
				}
			}
			$this->reset($property);
		}
	}





	// • === paramPropertyX → ... »
	protected function paramPropertyX(&$input, $key, $field = null)
	{
		$input[$key] = !empty($input[$key]) ? $input[$key] : (!empty($field) ? $field : (!empty($this->{$key}) ? $this->{$key} : ''));
	}





	// • === oChildRowAdd :: ... »
	protected function oChildRowAdd($row = [], $property = 'oChildRows', $refresh = 'refresh')
	{
		if (!is_array($this->{$property})) {
			$this->{$property} = [];
		}
		$this->{$property} = ArrayX::addValue($this->{$property}, $row);
		if (!empty($refresh)) {
			$this->gotoX($refresh);
		}
	}





	// • === oChildRowRemove :: ... »
	protected function oChildRowRemove($key = 'last', $property = 'oChildRows', $refresh = 'refresh')
	{
		if (is_array($this->{$property})) {
			if ($key === 'first') {
				$key = ArrayX::firstKey($this->{$property});
			} elseif ($key === 'last' || empty($key)) {
				$key = ArrayX::lastKey($this->{$property});
			}

			$this->{$property} = ArrayX::stripKey($this->{$property}, $key);
		}
		if (!empty($refresh)) {
			$this->gotoX($refresh);
		}
	}





	// • === oChildRowFirstKey :: ... »
	protected function oChildRowFirstKey($property = 'oChildRows')
	{
		if (!empty($this->{$property}) && is_array($this->{$property})) {
			return ArrayX::firstKey($this->{$property});
		}
	}





	// • === oChildRowLastKey :: ... »
	protected function oChildRowLastKey($property = 'oChildRows')
	{
		if (!empty($this->{$property}) && is_array($this->{$property})) {
			return ArrayX::lastKey($this->{$property});
		}
	}





	// • === oChildRowsCount :: ... »
	protected function oChildRowsCount($property = 'oChildRows')
	{
		if (!empty($this->{$property}) && is_array($this->{$property})) {
			$count = count($this->{$property});
		}
		return $count ?? 0;
	}





	// • === oRowsCount → ... »
	protected function oRowsCount($property = 'oRows')
	{
		if (!empty($this->{$property}) && is_array($this->{$property})) {
			$count = count($this->{$property});
		}
		return $count ?? 0;
	}





	// • === onSave → ... »
	protected function oSave($id, $label, &$action, &$response)
	{

		// + creating
		if (empty($id)) {
			$action = 'creating';
		}

		// + updating
		elseif (!empty($id)) {
			$action = 'updating';
		}

		Session::flash('actionX', $action);


		// @ validate, grab params & save
		$input = $this->validateX($action);
		$param = $this->paramX($action, $input, $id);

		if ($param) {
			list($response, $success, $error) = [null, null, null];
			$this->onSaveX($param, $label, $action, $response, $error, $success);
		}


		// → error
		if (!is_null($response) && HandlerX::hasDuplicate($response)) {
			$error = HandlerX::getErrorSummary($response);
			return $this->setErrorX($error);
		}
	}





	// • === oRead → ... »
	protected function oRead($id, $view = 'read')
	{
		$id = $this->grabID($id);
		$filter = $this->filterAsBindID($id);
		$record = $this->modelX::oFindX($filter);
		if (!$record) {
			// TODO:  improve and use this error
			$this->setErrorX('errorX', $this->doErrorX('No Record', 'Sorry, no record found'));
			$this->setViewX('notify');
		} else {
			$row = $record->getAttributes();
			$this->setPropertyX($row);
		}
		$this->readX($view, $record);
	}





	// • === oUpdate → ... »
	protected function oUpdate($id, $view = 'update')
	{
		$filter = $this->filterAsBindID($id);
		$record = $this->modelX::oFindX($filter);
		if (!$record) {
			$this->setErrorX('errorX', $this->doErrorX('No Record', 'Sorry, no record found'));
			$this->setViewX('notify');
		} else {
			$row = $record->getAttributes();
			$this->setPropertyX($row);
		}
		$this->updateX($view, $record);
	}





	// • === oDelete → ... »
	protected function oDelete($id, $label, &$action = 'deleting', &$response = null, &$error = null, &$success = null)
	{
		Session::flash('actionX', $action);
		$this->onDeleteX($id, $response, $success, $label, $error);
	}





	// • === onSaveX → ... »
	protected function onSaveX(&$param, $label, &$action = null, &$response = null, &$error = null, &$success = null)
	{
		$message = '';
		$response = $this->modelX::oSaveX($param);
		if (!empty($label)) {
			if (!empty($param[$label])) {
				$message = '<b>' . Str($param[$label])->words(3) . '</b>';
			} else {
				$message = ucfirst($label);
			}
		}
		$action ?? 'saving';
		$this->oResponseX($response, $message, $action);
	}





	// • === onDeleteX → ... »
	protected function onDeleteX($filter, &$response, &$success, $label = null, &$error = null)
	{
		$filter = $this->filterAsBindID($filter);
		$record = $this->modelX::oFindX($filter, $label);
		if ($record) {
			if ($record instanceof $this->modelX) {
				if (!is_null($label) && isset($record->$label)) {
					$label = $record->$label;
				}
			} else {
				$label = $record;
			}
			$label = '<b>' . $label . '</b>';
		}
		$response = $this->modelX::oDeleteX($filter);
		$this->oResponseX($response, $label, 'deleting');
	}





	// • === oResponseX → ... »
	protected function oResponseX($response, $message = '', $action)
	{
		//TODO: check for more types $response before setting flash
		if ($response === true) {

			switch ($action) {
				case 'creating':
					$message .= ' created';
					break;

				case 'updating':
					$message .= ' updated';
					break;

				case 'saving':
					$message .= ' saved';
					break;

				case 'deleting':
					$message .= ' deleted';
					break;

				default:
					break;
			}
			if (!empty($message)) {
				$message .= " successfully!";
			} else {
				$message = 'operation successful';
			}
			$this->formatMessage($message);
			$success = $this->htmlX($message);
			Session::flash('successX', $success);
		} else {
		}
	}





	// • === filterAsBindID → ... »
	private function filterAsBindID($bind)
	{
		$filter = [];
		if (!empty($bind)) {
			if (is_array($bind)) {
				return $bind;
			} elseif ($bind === 'wireX' && !empty($this->id)) {
				$filter['id'] = $this->id;
			} elseif (InputX::isPuid($bind)) {
				$filter = ['puid' => $bind];
			} elseif (InputX::isID($bind)) {
				$filter = ['id' => $bind];
			}
		}
		if (!empty($filter)) {
			return $filter;
		}
		return false;
	}





	// • === formatMessage → ... »
	private function formatMessage(&$message = null)
	{
		if (!is_null($message) && is_string($message)) {
			$message = trim($message);
			$message = ucfirst($message);
		}
		return $message;
	}
}//> end of Trait::WireX
