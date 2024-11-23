<?php //*** ComponentX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\Wire;

use Yale\Anci\EnvX;
use Livewire\Component;
use Yale\Xeno\Data\StringX;

abstract class ComponentX extends Component
{
	// ◈ property
	protected $componentX;
	protected $actionX;
	protected $recordX = [];
	protected $titleX;
	protected $sloganX;
	public $wireX;



	// ◈ === iClassX »
	public function iClassX()
	{
		return basename(get_class($this));
	}



	// ◈ === iBladeX »
	protected function iBladeX(string $blade, bool $theme = true)
	{
		if (!empty($blade)) {
			if ($theme) {
				$blade = EnvX::project('theme') . '.' . $blade;
			}
			return strtolower($blade);
		}
	}



	// ◈ === iRenderX »
	protected function iRenderX(string $view, ?string $layout = null, array|object|null $record = null)
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



	// ◈ === iComponentX »
	protected function iComponentX(?string $component = null)
	{
		if (empty($component)) {
			$component = $this->iClassX();
			// $component = StringX::beforeAs($this->routeX, '-');
		}
		return strtolower($component);
	}



	// ◈ === iActionX »
	protected function iActionX(?string $action = null)
	{
		if (empty($action)) {
			if (!empty($this->routeX) && !empty($this->componentX)) {
				if (($this->routeX !== $this->componentX)) {
					$action = StringX::after($this->routeX, $this->componentX . '.');
				}
			}
		}

		if (empty($action)) {
			$action = 'index';
		}

		return strtolower($action);
	}



	// ◈ === setComponentX »
	protected function setComponentX(?string $component = null)
	{
		$this->componentX = $this->iComponentX($component);
	}



	// ◈ === setActionX »
	protected function setActionX(?string $action = null)
	{
		$this->actionX = $this->iActionX($action);
	}



	// ◈ === setRecordX »
	protected function setRecordX(array|object|null $record = null)
	{
		if (!empty($record)) {
			$record = [];
		}
		$this->recordX = $record;
	}



	// ◈ === setTitleX »
	protected function setTitleX(?string $title = null)
	{
		// TODO: change from component to module as componet may be more that a single word & module would have to be define from a setModuleX()
		if (empty($title) && !empty($this->componentX)) {
			$title = $this->componentX;
		}
		$this->titleX = $title;
	}



	// ◈ === setSloganX »
	protected function setSloganX(?string $slogan = null)
	{
		// TODO: change from component to module as componet may be more that a single word & module would have to be define from a setModuleX()
		if (empty($slogan) && !empty($this->componentX) && !empty($this->actionX) && $this->actionX !== 'index') {
			$slogan = $this->actionX . ' ' . $this->componentX;
			if ($this->actionX === 'detail') {
				$slogan = 'review ' . $this->componentX . ' details';
			} elseif ($this->actionX === 'listing') {
				$slogan = 'list of ' . StringX::plural($this->componentX);
			}
		}

		$this->sloganX = $slogan;
	}



	// ◈ === setWireX »
	protected function setWireX()
	{
		if (!isset($this->wireX)) {
			$this->wireX = new \stdClass();
		}
		$params = ['route', 'component', 'action', 'title', 'slogan'];
		foreach ($params as $param) {
			$property = $param . 'X';
			if (!empty($this->$property)) {
				$this->wireX->$param = $this->$property;
			} elseif (in_array($param, ['title', 'slogan'])) {
				$method = 'set' . ucfirst($property);
				if (method_exists($this, $method)) {
					$this->$method();
					$this->wireX->$param = $this->$property;
				} else {
					$this->wireX->$param = '';
				}
			} else {
				$this->wireX->$param = '';
			}
		}
	}



}//> end of class ~ ComponentX