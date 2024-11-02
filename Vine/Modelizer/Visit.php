<?php //*** Visit ~ modelizer » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Vine\Modelizer;

use Yale\Concept\Abstract\Model as ModelAbstractX;

class Visit extends ModelAbstractX
{
	// ◈ property
	protected $table = 'visit';
	protected $fillable = [
		'method',
		'route',
		'token',
		'osession',
		'os',
		'ip',
		'isp',
		'device',
	];

}//> end of modelizer ~ Visit