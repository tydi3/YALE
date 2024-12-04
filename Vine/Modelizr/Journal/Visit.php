<?php //*** Visit ~ modelizr » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Vine\Modelizr\Journal;

use Yale\Concept\Abstract\Model as AbstractModelX;

class Visit extends AbstractModelX
{
	// ◈ property
	protected $table = 'logvisit';
	protected $fillable = [
		'method',
		'route',
		'token',
		'osession',
		'os',
		'ip',
		'isp',
		'device'
	];

}//> end of modelizr ~ Visit