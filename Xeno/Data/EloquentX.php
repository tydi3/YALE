<?php //*** EloquentX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\Data;

use Yale\Orig\Is;
use Yale\Anci\DebugX;

class EloquentX
{
	// ◈ property
	private static $model = false;
	protected static $result;



	// ◈ === init »
	public static function init($model)
	{
		self::$model = self::model($model);
	}



	// ◈ === end »
	public static function end()
	{
		self::$model = false;
	}



	// ◈ === all »
	public static function all($model = null, $as = null)
	{
		$instance = self::model($model);
		$result = $instance::all();
		return self::result($result, $as);
	}



	// ◈ === result »
	protected static function result($result, $returnAs = null)
	{
		if ($returnAs === 'rows') {
			return $result->toArray();
		}

		if ($returnAs === 'json') {
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