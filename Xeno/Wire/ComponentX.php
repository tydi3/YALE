<?php //*** ComponentX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\Wire;

use Yale\Anci\EnvX;
use Yale\Anci\DebugX;
use Livewire\Component;
use Yale\Xeno\File\FileX;
use Yale\Xeno\Data\StringX;

abstract class ComponentX extends Component
{
	// ◈ property
	protected $permissionX = [];
	protected $componentX;
	protected $layoutX;
	protected $viewX;
	public $wireX;
	public $recordX;



	// ◈ === setPermissionX »
	protected function setPermissionX(array $permission = [])
	{
		$this->permissionX = $permission;
		$this->setWireX(['permissionX' => $this->permissionX]);
	}



	// ◈ === setWireX »
	protected function setWireX(array $param = [])
	{
		if (!isset($this->wireX)) {
			$this->wireX = new \stdClass();
		}

		if (!empty($param)) {
			foreach ($param as $key => $value) {
				$this->wireX->$key = $value;
			}
		}
	}



	// ◈ === setRecordX »
	protected function setRecordX($record = null)
	{
		if (!empty($record)) {
			$this->recordX = $record;
		} else {
			$this->recordX = [];
		}
	}




	// ◈ === setComponentX »
	protected function setComponentX($component = null)
	{
		if (!empty($component)) {
			$this->componentX = strtolower($component);
		} else {
			$this->componentX = StringX::beforeAs($this->routeX, '-');
		}
	}



	// ◈ === setModuleX »
	protected function setModuleX($module = null)
	{
		if (!empty($module)) {
			$this->moduleX = strtolower($module);
		} elseif (!empty($this->componentX)) {
			$this->moduleX = $this->componentX;
		}
	}



	// ◈ === setLayoutX »
	protected function setLayoutX($layout = null, $kind = null)
	{
		if (!$layout) {
			$layout = EnvX::project('theme') . '.layout';
			if ($kind === 'page') {
				$layout .= '.page';
			}
		}
		if (!empty($layout)) {
			$this->layoutX = strtolower($layout);
		}
	}



	// ◈ === setViewX »
	protected function setViewX($view, $kind = null)
	{
		if ($kind) {
			$path = EnvX::project('theme');
			if ($kind === 'page') {
				$view = $path . '.page.' . $view;
			}
			if ($kind === 'shard') {
				$view = $path . '.shard.' . $view;
			}
		}

		if (!empty($view)) {
			$this->viewX = strtolower($view);
		}
	}



	// ◈ === checkViewX »
	protected function checkViewX()
	{
		if (!empty($this->viewX)) {
			if (!FileX::is()->blade($this->viewX)) {
				return DebugX::blade404($this->viewX);
			}
		}
	}



	// ◈ === checkLayoutX »
	protected function checkLayoutX()
	{
		if (!empty($this->layoutX)) {
			if (!FileX::is()->blade($this->layoutX)) {
				return DebugX::blade404($this->layoutX);
			}
		}
	}





	// ◈ === iRenderX »
	protected function iRenderX($data = [])
	{
		if (empty($this->viewX)) {
			return DebugX::oversight('LivewireX', 'Undefined View');
		}

		$this->checkViewX();
		if (!empty($this->layoutX)) {
			$this->checkLayoutX();
			$render = view($this->viewX, $data)->layout($this->layoutX);
		} else {
			$render = view($this->viewX, $data);
		}

		return $render;
	}

}//> end of class ~ ComponentX