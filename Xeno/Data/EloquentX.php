<?php //*** EloquentX ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Xeno\Data;

use InvalidArgumentException;
use Illuminate\Database\Eloquent\Model;

class EloquentX
{
	// ◈ property
	private static $model = false;



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



	// ◈ === everything »
	public static function everything($model = null)
	{
		$model = self::model($model);
		return $model::all();
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

		if (!class_exists($model) || !is_subclass_of($model, Model::class)) {
			throw new InvalidArgumentException("Invalid model class: $model");
		}

		return $model;
	}

}//> end of class ~ EloquentX