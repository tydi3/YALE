<?php //*** ResolveX ~ trait » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Wire\Render;

trait ResolveX
{
	// ◈ === iResolveX »
	protected function iResolveX($action, $result, $id = null, null|string|array $success = null, ?string $next = null)
	{
		// ~ for creating
		if ($action === 'create') {
			if ($result && isset($result->guid)) {
				$this->successX($success);
				if (!empty($next)) {
					return $this->redirectX($next);
				}
				return $this->create();
			}
		}

		if ($result === true || (is_numeric($result) && $result >= 1)) {
			$this->successX($success);
			if (!empty($next)) {
				return $this->redirectX($next);
			}

			if (in_array($action, ['update'])) {
				return $this->{$action}($id);
			} elseif ($action === 'create') {
				dd('Created!');
				// return $this->create();
			}
		}
	}

}//> end of trait ~ ResolveX
