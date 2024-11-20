<?php //*** ComponentX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\Wire;

use Yale\Anci\EnvX;
use Yale\Anci\DebugX;
use Livewire\Component;
use Yale\Xeno\File\FileX;

abstract class ComponentX extends Component
{
	// ◈ property
	protected $componentX;
	protected $layoutX;
	protected $viewX;



	// ◈ === setComponentX »
	protected function setComponentX($component)
	{
		if (!empty($component)) {
			$this->componentX = strtolower($component);
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
	protected function checkViewX($blade){
		$check = FileX::is()->blade($blade);
		dd($check);
	}





	// ◈ === iRenderX »
	protected function iRenderX($data = [])
	{
		if (empty($this->viewX)) {
			return DebugX::oversight('LivewireX', 'Undefined View');
		}

		$this->checkViewX($this->viewX);

		if (!empty($this->layoutX)) {
			// TODO: verify layout exists
			$render = view($this->viewX, $data)->layout($this->layoutX.'.ogo');
		} else {
			$render = view($this->viewX, $data);
		}

		return $render;
	}

}//> end of class ~ ComponentX