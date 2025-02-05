<?php //*** Model ~ trait » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Concept\Trait;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Yale\Xeno\Data\GenerateX;
use Yale\Concept\Trait\Elegance\AllX;
use Yale\Concept\Trait\Elegance\CountX;
use Yale\Concept\Trait\Elegance\CreateX;
use Yale\Concept\Trait\Elegance\FindX;
use Yale\Concept\Trait\Elegance\HasX;
use Yale\Concept\Trait\Elegance\ScopeX;
use Yale\Concept\Trait\Elegance\UpdateX;

trait Model
{
	// ◈ traits
	use AllX;
	use CountX;
	use CreateX;
	use FindX;
	use HasX;
	use ScopeX;
	use UpdateX;



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