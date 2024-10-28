<?php

namespace App\Leoms;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Spry\DataX;
use App\Spry\ArrayX;
use App\Spry\DebugX;
use App\Spry\StringX;

trait WireX
{
	// ◇ property
	public $guid;
	public $rowE404X;
	public $hasRows;





	// ◇ === edit :: ... »
	public function edit($id = null)
	{
		$this->update($id);
	}





	// ◇ === trash :: ... »
	public function trash($id)
	{
		return $this->delete($id);
	}




	// ◇ === toCreate :: ... »
	public function toCreate()
	{
		$this->organize('creating');
		$this->createX();
		$this->setWireRoute($this->component . '-create');
	}





	// ◇ === toRead :: ... »
	public function toRead($id)
	{
		$this->organize('read');
		$this->oRead($id);
		$this->setWireRoute($this->component . '-read');
	}





	// ◇ === toUpdate :: ... »
	public function toUpdate($id)
	{
		$id = $this->grabID($id);
		$this->organize('updating');
		$this->oUpdate($id);
		$this->setWireRoute($this->component . '-update');
	}





	// ◇ === toClone :: ... »
	public function toClone($id)
	{
		$id = $this->grabID($id);
		$this->organize('cloning');
		$this->oClone($id);
		$this->setWireRoute($this->component . '-clone');
	}





	// ◇ === toSave :: ... »
	public function toSave($label, $next = 'listing')
	{
		$id = $this->grabID();
		list($response, $action) = [null, null];
		$this->oSave($id, $label, $action, $response);

		// → success
		if ($response === true) {
			$this->clear($action);
			if ($next) {
				return $this->reloadX($next);
			}
		}
	}





	// ◇ === toDelete :: ... »
	public function toDelete($id, $label, $next = 'listing')
	{
		$id = $this->grabID($id);
		list($response, $action) = [null, 'deleting'];
		$this->oDelete($id, $label, $action, $response);

		// → success
		if ($response === true) {
			return $this->reloadX($next);
		}
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
} //> end of WireX