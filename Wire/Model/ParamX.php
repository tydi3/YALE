<?php //*** ParamX ~ trait » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Wire\Model;

use Yale\Xeno\Data\ArrayX;

trait ParamX
{
	// ◈ property
	protected $recordX;



	// ◈ === setRecordX »
	protected function setRecordX(array|object|null $record = [])
	{
		//TODO: check the effect (if it is wanted)
		if (is_array($record) && !empty($record)) {
			$record = ArrayX::toObject($record);
		}

		if (!empty($record)) {
			$this->recordX = $record;
		}
	}

}//> end of trait ~ ParamX