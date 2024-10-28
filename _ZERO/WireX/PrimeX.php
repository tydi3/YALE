<?php

namespace App\Leoms;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Zero\Spry\Crud\ActionX;
use App\Spry\RandomX;
use App\Spry\StringX;
use App\Spry\ArrayX;
use App\Spry\DebugX;
use App\Spry\DataX;


trait PrimeX
{
	// ◇ property
	private $onSaveLabel = 'title';
	private $crudExclude = [];
	private $crudInclude = [];
	public $guid;
	public $rowE404X;
	public $hasRows;





	// • === resolutionX :: ... »
	private function resolutionX($action, $result = null, $next = null)
	{
		// @ success
		if ($result) {
			$this->onActionX($action);
			if ($next) {
				return $this->reloadX($next);
			}
		}
	}






	// • === savingX :: ... »
	private function savingX($label = null, $next = 'listing')
	{
		$id = $this->grabID();
		$label = $label ?? (!empty($this->onSaveLabel) ? $this->onSaveLabel : 'title');
		list($result, $action) = [null, null];
		$this->oSave($id, $label, $action, $result);
		return $this->resolutionX($action, $result, $next);
	}





	// • === deletingX :: ... »
	private function deletingX($id, $label = null, $next = 'listing')
	{
		$id = $this->grabID($id);
		$label = $label ?? (!empty($this->onSaveLabel) ? $this->onSaveLabel : 'title');
		list($result, $action) = [null, 'deleting'];
		$this->oDelete($id, $label, $action, $result);
		return $this->resolutionX($action, $result, $next);
	}










	// ◇ === crudX :: ... »
	protected function crudX()
	{
		$action = ActionX::action(Auth::user()->type, $this->crudExclude, $this->crudInclude);
		$this->setCrudX($action);
	}





	// ◇ === initX :: ... »
	protected function initX()
	{
		$this->isX();
		$this->crudX();
	}




	// ◇ === organize :: ... »
	protected function organizeX($action = null)
	{
		if (method_exists($this, 'factorizeX')) {
			$this->factorizeX($action);
		}

		if (in_array($action, ['creating']) && empty($this->guid)) {
			$this->guid = RandomX::guid();
		}
	}





	// ◇ === validateX :: ... »
	protected function validateX($action = null)
	{
		if (method_exists($this, 'checkParamX')) {
			return $this->checkParamX($action);
		}

		$messages = ['guid.max' => 'Shorten to :max chars'];
		if ($action === 'creating' || $action === 'updating') {
			return $this->validate(['guid' => 'nullable|string|max:12'], $messages);
		}
	}





	// ◇ === paramX :: ... »
	protected function paramX($action, $param = null, $id = null)
	{
		if (method_exists($this, 'setParamX')) {
			$param = $this->setParamX($action, $param, $id);
		}

		if (method_exists($this, 'cleanParamX')) {
			$this->cleanParamX($param, $action);
		}

		return ArrayX::stripEmptyKey($param);
	}





	// ◇ === boot :: ... »
	public function boot()
	{
		if (method_exists($this, 'bootX')) {
			$this->bootX();
		}
		if (method_exists($this, 'modelX')) {
			$this->modelX();
		}
		$this->initX();
	}





	// ◇ === mount :: ... »
	public function mount()
	{
		$this->fireX();
		$this->initX();
		$this->routerXAuto('listing');
	}





	// ◇ === render :: ... »
	public function render()
	{
		$this->pathX['slab'] = "leoms.slab.{$this->component}.";
		return $this->bladeXFallback($this->component, 'main', 'leoms');
	}





	// ◇ === listing :: ... »
	public function listing()
	{
		if (method_exists($this, 'oRowsX')) {
			$this->oRowsX('listing');
		}
		$this->listingX();
		$this->setWireRoute($this->component . '-listing');
	}








	// ◇ === read :: ... »
	public function read($id = null)
	{
		$id = $this->grabID($id);
		if (method_exists($this, 'presetX')) {
			$this->presetX('read');
		}
		$this->organizeX('reading');
		$this->oRead($id);
		$this->setWireRoute($this->component . '-read');
	}





	// ◇ === update :: ... »
	public function update($id = null)
	{
		$id = $this->grabID($id);
		if (method_exists($this, 'presetX')) {
			$this->presetX('update');
		}
		$this->organizeX('updating');
		$this->oUpdate($id);
		$this->setWireRoute($this->component . '-update');
	}





	// ◇ === edit :: ... »
	public function edit($id = null)
	{
		$this->update($id);
	}





	// ◇ === delete :: ... »
	public function delete($id)
	{
		return $this->deletingX($id);
	}





	// ◇ === trash :: ... »
	public function trash($id)
	{
		return $this->delete($id);
	}





	// ◇ === toClone :: ... »
	// public function toClone($id)
	// {
	// 	$id = $this->grabID($id);
	// if (method_exists($this, 'presetX')) {
	// 	$this->presetX('clone');
	// }
	// 	$this->organize('cloning');
	// 	$this->oClone($id);
	// 	$this->setWireRoute($this->component . '-clone');
	// }





	// ◇ === save :: ... »
	public function save($action = null)
	{
		if (method_exists($this, 'saveX')) {
			return $this->saveX($action);
		}
		return $this->savingX();
	}





	// ◇ === download :: ... »
	public function download($id)
	{
		return redirect()->route($this->component . '-download', ['id' => $id]);
	}





	// ◇ === fallback :: ... »
	public function fallback($container = null)
	{
		if (!empty($container)) {
			if (StringX::endWithAny($container, ['listing', 'form', 'read'])) {
				$container = 'leoms.container.main';
			}
		}
		return $container;
	}



















	// ◇ === component404 :: ... »
	public function component404(&$container, $layout = null)
	{
		$append = '';
		if (!view::exists($container)) {
			$append .= 'container';
		}
		if (!empty($layout) && !view::exists($layout)) {
			if (!empty($append)) {
				$append .= ' & ';
			}
			$append .= 'layout';
		}

		if (!empty($append)) {
			$append = ' » ' . $append;
			$error = [
				'container' => $container,
				'layout' => $layout
			];

			if (!empty($error['container'])) {
				$path = 'leoms.container.' . $this->component . '.';
				$blade = StringX::cropBegin($container, $path);

				// TODO: improve this code block in FUTURE
				$this->rowE404X = array_merge(
					[
						'path' => $path,
						'blade' => $blade,
						'container' => $container,
						'layout' => $layout
					]
				);
			}

			$container = $path . 'e404';
		}
	}





	// ◇ === e404 :: ... »
	public function e404($container, $layout = null)
	{
		$append = '';
		if (!view::exists($container)) {
			$append .= 'container';
		}
		if (!empty($layout) && !view::exists($layout)) {
			if (!empty($append)) {
				$append .= ' & ';
			}
			$append .= 'layout';
		}

		if (!empty($append)) {
			$append = ' » ' . $append;
			$error = [
				'container' => $container,
				'layout' => $layout
			];

			return DebugX::oversight('BladeX', 'resource not found' . $append, $error);
		}
	}






	// ◇ === paramToCreate :: ... »
	protected function paramToCreate($param = null)
	{
		if (is_array($param) && !empty($param)) {
			if (ArrayX::isMulti($param) && ArrayX::isKeyNumeric($param)) {
				foreach ($param as $key => $row) {
					if (empty($row['oauthor'])) {
						$row['oauthor'] = Auth::user()->puid;
					}
					$param[$key] = DataX::create($row);
				}
			}

			if (!ArrayX::isMulti($param)) {
				if (empty($param['oauthor'])) {
					$param['oauthor'] = Auth::user()->puid;
				}
				$param = DataX::create($param);
			}
		}
		return $param;
	}


















	// • === oRowsCount → ... »
	private function oRowsCount($var = 'oRows', $isProperty = true)
	{
		if ($isProperty === true && !empty($this->{$var})) {
			$var = $this->{$var};
		}

		if (!empty($var) && is_array($var)) {
			// if(!empty($var) && is_countable($var)) {
			$count = count($var);
		}

		return $count ?? 0;
	}





	// • === oRowsAdd :: ... »
	protected function oRowsAdd($row = [], $var = 'oChildRows', $isProperty = true, $goto = 'refresh')
	{
		if ($isProperty === true) {
			if (!is_array($this->{$var})) {
				$this->{$var} = [];
			}
			if (!empty($row)) {
				$this->{$var} = ArrayX::addValue($this->{$var}, $row);
			}
		}

		if (!empty($goto)) {
			$this->gotoX($goto);
		}
	}





	// • === oRowRemove :: ... »
	protected function oRowRemove($key = 'last', $var = 'oChildRows', $isProperty = true, $goto = 'refresh')
	{
		if ($isProperty === true) {
			if (is_array($this->{$var})) {
				if ($key === 'first') {
					$key = ArrayX::firstKey($this->{$var});
				} elseif ($key === 'last' || empty($key)) {
					$key = ArrayX::lastKey($this->{$var});
				}
				$this->{$var} = ArrayX::stripKey($this->{$var}, $key);

				// + re-index rows if index is numeric (NOTE: Should be the case)
				if(ArrayX::isKeyNumeric($this->{$var})){
					$this->{$var} = array_values($this->{$var});
				}

			}
		}

		if (!empty($goto)) {
			$this->gotoX($goto);
		}
	}





	// • === oRowFirstKey :: ... »
	protected function oRowFirstKey($var = 'oChildRows', $isProperty = true)
	{
		if ($isProperty === true && !empty($this->{$var})) {
			$var = $this->{$var};
		}

		if (!empty($var) && is_array($var)) {
			return ArrayX::firstKey($var);
		}
	}





	// • === oRowLastKey :: ... »
	protected function oRowLastKey($var = 'oChildRows', $isProperty = true)
	{
		if ($isProperty === true && !empty($this->{$var})) {
			$var = $this->{$var};
		}

		if (!empty($var) && is_array($var)) {
			return ArrayX::lastKey($var);
		}
	}




















	// ◇ === onActionX :: ... »
	public function onActionX($action = null)
	{
		//TODO: make this a required abstract
		if ($action === 'creating') {
			$this->guid = null;
		}
	}


	// ◇ === clear :: ... »
	public function clear($action = null) {}
}
