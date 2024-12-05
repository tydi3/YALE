<?php //*** ParamX ~ trait » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Wire\Model;

use Yale\Anci\DebugX;
use Yale\Xeno\Data\ArrayX;

trait ParamX
{
	// ◈ property
	protected $recordX;
	protected $id;



	// ◈ === grabIdX »
	protected function grabIdX($id = null)
	{
		if (!empty($id) && empty($this->id)) {
			self::setIdX($id);
		}

		if (!empty($this->id)) {
			return $this->id;
		}

		// TODO: build an error handler for when $id is expected or record is not found
		DebugX::oversight($this->moduleX, 'id parameter not found');
	}



	// ◈ === grabParamX » grab data from property or properties as parameters' input
	protected function grabParamX(&$input, string|array $param, $valueAs = null)
	{
		if (!is_array($param)) {

			$input[$param] =
				!empty($input[$param]) ? $input[$param] :
				(!empty($this->{$param}) ? $this->{$param} :
					($valueAs ?? ''));

		} elseif (ArrayX::isKeyNumeric($param)) {
			// NOTE: array's only defined values (e.g ['username', 'email']);
			foreach ($param as $field) {
				$this->grabParamX($input, $field);
			}
		} else {
			// NOTE: array's key-value pairs are defined (e.g ['username' => 'osawereao']);
			foreach ($param as $field => $value) {
				$this->grabParamX($input, $field, $value);
			}
		}
	}



	// ◈ === setIdX »
	protected function setIdX(int|string $id = null)
	{
		if (!empty($id)) {
			$this->id = $id;
		}
	}



	// ◈ === setParamX »
	protected function setParamX($attribute)
	{
		if (is_array($attribute) || is_object($attribute)) {
			foreach ($attribute as $property => $value) {
				if (property_exists($this, $property)) {
					$this->$property = $value;
				}
			}
		}
	}



	// ◈ === clearParam »
	protected function clearParamX($property, $clearIDs = false)
	{
		$merge = [];

		if ($clearIDs === true) {
			$merge = ['id', 'guid', 'puid', 'suid', 'tuid', 'status'];
		}

		if (is_array($property)) {
			$property = array_merge($merge, $property);
			foreach ($property as $key) {
				if (property_exists($this, $key)) {
					$this->$key = '';
				}
			}
		} else {
			if (property_exists($this, $property)) {
				$this->$property = '';
			}
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



	// ◈ === resetParam » grab data from properties as parameters' input
	// protected function resetParam(string|array $property)
	// {
	// 	// TODO: test to understand
	// 	if (is_string($property)) {
	// 		if (isset($this->$property)) {
	// 			$this->reset([$property]);
	// 		}
	// 	} elseif (is_array($property)) {
	// 		foreach ($property as $key => $value) {
	// 			if (!isset($this->$key)) {
	// 				unset($property[$key]);
	// 			}
	// 		}
	// 		$this->reset($property);
	// 	}
	// }

}//> end of trait ~ ParamX