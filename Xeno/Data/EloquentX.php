<?php //*** EloquentX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\Data;

use Yale\Orig\Is;
use Yale\Anci\DebugX;
use Yale\Xeno\Data\ArrayX;

class EloquentX
{
	// ◈ property
	private static $model;
	protected static $result;



	// ◈ === init »
	public static function init($model)
	{
		self::end();
		self::$model = self::model($model);
	}



	// ◈ === end »
	public static function end()
	{
		self::$result = null;
		self::$model = null;
	}



	// ◈ === all » get all records (columns & rows)
	public static function all($model = null)
	{
		$model = self::model($model);
		self::$result = $model::oAll();
		return self::$result;
	}



	// ◈ === record »
	public static function record($result = null)
	{
		return self::result('array', $result);
	}



	// ◈ === rows »
	public static function rows($result = null)
	{
		$record = self::record($result);
		if (is_array($record)) {
			if (!ArrayX::isMultiAndKeyNumeric($record)) {
				return [$record];
			}
		}
		// TODO: implement check if not array
		return $record;
	}



	// ◈ === row »
	public static function row($result = null)
	{
		$record = self::record($result);
		if (is_array($record)) {
			if (ArrayX::isMultiAndKeyNumeric($record)) {
				return ArrayX::firstValue($record);
			}
		}
		// TODO: implement check if not array
		return $record;
	}



	// ◈ === json »
	public static function json($result = null)
	{
		return self::result('json', $result);
	}



	// ◈ === result »
	protected static function result($return = null, $result = null)
	{
		if (!$result && self::$result) {
			$result = self::$result;
		}

		if ($return === 'array') {
			return $result->toArray();
		}

		if ($return === 'json') {
			return $result->toJson();
		}

		return $result;
	}



	// ◈ === model » use model
	private static function model($model = null)
	{
		if (!$model) {
			$model = self::$model;
		}

		if ($model === null) {
			$model = self::class;
		}

		if (!$model) {
			return self::oversight(message: 'model required', reason: 'argument "$model" not set');
		} elseif (!Is::model($model)) {
			return self::oversight(message: 'model invalid', reason: '$model is of type ' . gettype($model), param: $model);
		}

		return $model;
	}



	// ◈ === oversight » defined error response from class
	private static function oversight($message, $summary = null, $reason = null, $param = null)
	{
		$extra = [];
		if (isset($summary)) {
			$extra['summary'] = $summary;
		}
		if (isset($reason)) {
			$extra['reason'] = $reason;
		}
		if (isset($param)) {
			if (is_string($param)) {
				$extra['param'] = $param;
			} elseif (is_array($param)) {
				$extra = array_merge($extra, $param);
			}
		}

		return DebugX::oversight('EloquentX', $message, $extra);
	}

}//> end of class ~ EloquentX