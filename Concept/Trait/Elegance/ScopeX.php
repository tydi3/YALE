<?php //*** ScopeX ~ trait » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Concept\Trait\Elegance;

trait ScopeX
{
	// ◈ === scopeGuid »
	public function scopeGuid($query, $guid)
	{
		return $query->where('guid', $guid);
	}


	// ◈ === scopePuid »
	public function scopePuid($query, $puid)
	{
		return $query->where('puid', $puid);
	}



	// ◈ === scopeSuid »
	public function scopeSuid($query, $suid)
	{
		return $query->where('suid', $suid);
	}



	// ◈ === scopeTuid »
	public function scopeTuid($query, $tuid)
	{
		return $query->where('tuid', $tuid);
	}



	// ◈ === scopeAuthor »
	public function scopeAuthor($query, $author = null)
	{
		if (is_null($author)) {
			return $query->whereNull('author');
		}
		return $query->where('author', $author);
	}



	// ◈ === scopeStatus »
	public function scopeStatus($query, $status = null)
	{
		if (is_null($status)) {
			return $query->whereNull('status');
		}
		return $query->where('status', $status);
	}

}//> end of trait ~ ScopeX