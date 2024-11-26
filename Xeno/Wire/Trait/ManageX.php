<?php //*** ManageX ~ trait » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\Wire\Trait;

trait ManageX
{
	// ◈ property
	protected $actionCountX;


	// ◈ === listingX »
	protected function listingX($record = [], $action = 'listing')
	{
		$this->setIfNotX('action', $action);

	}





















	// ◈ === updateX »
	protected function updateX($action = 'update')
	{
		$this->setActionX($action);

	}




	// ◈ === createX »
	protected function createX($component = null, $view = 'create')
	{
		$this->titleX = FormatX::title($component);
		$this->taglineX = 'Create new ' . FormatX::title($component);
		$this->viewCountX['create'] = ($this->viewCountX['create'] ?? 0) + 1;
		$this->setViewIfNotX($view);
		$this->setWireRouteX($view, $component);
	}



	protected function listingXz($record = null, $component = null, $view = 'listing')
	{
		$this->titleX = FormatX::title($component);
		$this->taglineX = 'List of ' . FormatX::title(Str::plural($component));
		$this->viewCountX['list'] = ($this->viewCountX['list'] ?? 0) + 1;
		if (!empty($record)) {
			$this->setRecordX($record);
		}
		$this->setViewIfNotX($view);
		$this->setWireRouteX($view, $component);
	}

}//> end of trait ~ ManageX