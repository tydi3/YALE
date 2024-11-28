<?php //*** Model ~ trait » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Concept\Trait;

use Illuminate\Support\Str;
use Yale\Xeno\Data\GenerateX;
use Yale\Concept\Trait\Model\Scope as ScopeX;
use Yale\Concept\Trait\Model\Record as RecordX;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

trait Model
{
	// ◈ traits
	use ScopeX;
	use RecordX;



	// ◈ === oauthor »
	public function author()
	{
		return $this->belongsTo(\App\Models\User::class, 'oauthor', 'tuid');
	}



	// ◈ === oCountByValue » using a column's value count record
	public static function oCountByValue($column, $value)
	{
		return self::query()->where($column, $value)->count();
	}



	// ◈ === oArray » sefely perform toArray()
	public static function oArray($result)
	{
		return $result ? $result->toArray() : [];
	}



	// ◈ === getFillable »
	public function getFillable()
	{
		if (method_exists($this, 'fillableColumns')) {
			$fillable = array_merge($this->fillableColumns(), $this->fillable);
		}
		$this->fillable = array_unique($fillable);
		return $this->fillable ?? parent::getFillable();
	}



	// ◈ === booted »
	protected static function booted()
	{
		// • creating :: runs before a record is created
		static::creating(function ($model) {
			$model->guid = !empty($model->guid) ? $model->guid : Str::random(12);
			$model->puid = !empty($model->puid) ? $model->puid : Str::random(20);
			$model->suid = !empty($model->suid) ? $model->suid : Str::random(40);
			$model->tuid = !empty($model->tuid) ? $model->tuid : Str::random(70);
			if (empty($model->oauthor) && (Auth::check() === true && !empty(Auth::user()->tuid))) {
				$model->oauthor = Auth::user()->tuid;
			}
		});
	}



	// ◈ === fillableColumns »
	private function fillableColumns()
	{
		return ['guid', 'puid', 'suid', 'tuid', 'oauthor', 'status', 'date'];
	}

}//> end of trait ~ Model