<?php //*** ParamX ~ trait » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\Wire\Trait;

use Yale\Xeno\Data\ArrayX;

trait ParamX
{
	// ◈ === grabParam » grab data from property or properties as parameters' input
	protected function grabParam(&$input, string|array $param, $valueAs = null)
	{
		if (!is_array($param)) {

			$input[$param] =
			!empty($input[$param]) ? $input[$param] :
			(!empty($this->{$param}) ? $this->{$param} :
			($valueAs ?? ''));

		} elseif (ArrayX::isKeyNumeric($param)) {
			// NOTE: array's only defined values (e.g ['username', 'email']);
			foreach ($param as $field) {
				$this->grabParam($input, $field);
			}
		} else {
			// NOTE: array's key-value pairs are defined (e.g ['username' => 'osawereao']);
			foreach ($param as $field => $value) {
				$this->grabParam($input, $field, $value);
			}
		}
	}



	// ◈ === setParam »
	protected function setParam($attribute)
	{
		if (is_array($attribute) || is_object($attribute)) {
			foreach ($attribute as $property => $value) {
				if (property_exists($this, $property)) {
					$this->$property = $value;
				}
			}
		}
	}



	// ◈ === clearParm »
	protected function clearParam($property, $clearIDs = false)
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