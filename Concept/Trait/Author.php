<?php //*** Author ~ trait » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Concept\Trait;

use App\Models\User;

trait Author
{
	// ◈ === author »
	public function author()
	{
		return $this->belongsTo(User::class, 'oauthor', 'tuid');
	}

}//> end of trait ~ Author