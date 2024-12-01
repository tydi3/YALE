<?php //*** WireX ~ abstract » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Wire;

use Yale\Anci\EnvX;
use Yale\Anci\DebugX;
use Livewire\Component;
use Yale\Xeno\File\FileX;
use Yale\Xeno\Data\StringX;

abstract class WireX extends Component
{
	// ◈ property
	protected $recordX = [];



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

			$blade .= $o;
			return strtolower($blade);
		}
		return null;
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
	protected function getRecordX()
	{
		if (!empty($this->recordX)) {
			return $this->recordX;
		}
		return [];
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