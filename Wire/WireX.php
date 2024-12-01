<?php //*** WireX ~ abstract » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Wire;

use Livewire\Component;
use Yale\Anci\EnvX;
use Yale\Xeno\Data\StringX;

abstract class WireX extends Component
{
	// ◈ property
	private static $init = false;



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

}//> end of abstract ~ WireX