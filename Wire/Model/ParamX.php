<?php //*** ParamX ~ trait » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Wire\Model;

use Yale\Xeno\Data\ArrayX;

trait ParamX
{
	// ◈ property
	protected $idX;
	protected $recordX;



	// ◈ === grabIdX »
	protected function grabIdX($id = null)
	{
		if (!empty($id) && empty($this->idX)) {
			self::setIdX($id);
		}

		if (!empty($this->idX)) {
			return $this->idX;
		}

		// TODO: build an error handler for when $id is expected or record is not found
		DebugX::oversight($this->moduleX, 'id parameter not found');
	}



	// ◈ === setIdX »
	protected function setIdX(int|string $id = null)
	{
		if (!empty($id)) {
			$this->idX = $id;
		}
	}



	// ◈ === setRecordX »
	protected function setRecordX(array|object|null $record = [], $return = 'object')
	{
		if (is_array($record) && !empty($record) && $return === 'object') {
			$record = ArrayX::toObject($record);
		}

		if (!empty($record)) {
			$this->recordX = $record;
		}
	}

}//> end of trait ~ ParamX