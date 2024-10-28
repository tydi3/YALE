<?php //*** WireX ~ trait » Yaic™ Library for Laravel © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace App\Yaic\Tydi\Wire;

use App\Yaic\Tydi\Data\FormatX;
use App\Yaic\Tydi\Data\StringX;
use Illuminate\Support\Str;

trait WireX
{
	// ◈ property
	protected $viewCountX;



	// ◈ === createX »
	protected function createX($component = null, $view = 'create')
	{
		$this->titleX = FormatX::title($component);
		$this->taglineX = 'Create new ' . FormatX::title($component);
		$this->viewCountX['create'] = ($this->viewCountX['create'] ?? 0) + 1;
		$this->setViewIfNotX($view);
		$this->setWireRouteX($view, $component);
	}



	// ◈ === listingX »
	protected function listingX($record = null, $component = null, $view = 'listing')
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

}//> end of trait ~ WireX