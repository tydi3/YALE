<?php //*** Helper ~ function » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

// ◈ === callObjectMethodX »
function callObjectMethodX($object, string $method, ...$arguments)
{
	if ($object !== null && method_exists($object, $method)) {
		return $object->$method(...$arguments);
	}
	return null;
}
