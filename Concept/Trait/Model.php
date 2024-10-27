<?php //*** Model ~ trait » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Concept\Trait;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Yale\Xeno\Data\DataX;

trait Model
{
	// ◈ === booted »
	protected static function booted()
	{
		// • creating :: runs before a record is created
		static::creating(function ($model) {
			$model->guid = !empty($model->guid) ? $model->guid : Str::random(12);
			$model->puid = !empty($model->puid) ? $model->puid : Str::random(20);
			$model->suid = !empty($model->suid) ? $model->suid : Str::random(40);
			$model->tuid = !empty($model->tuid) ? $model->tuid : Str::random(70);
			if (empty($model->oauthor) && Auth::check() && !empty(Auth::user()->tuid)) {
				$model->oauthor = Auth::user()->tuid;
			}
		});
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



	// ◈ === author »
	public function author()
	{
		if (get_called_class() !== 'App\Models\User') {
			return $this->belongsTo(\App\Models\User::class, 'oauthor', 'tuid');
		}
	}



	// ◈ === oAll »
	public static function oAll($sorting = 'desc')
	{
		if (!$sorting || $sorting === 'desc') {
			return self::orderByDesc('id')->get();
		}
		return self::orderBy('id')->get();
	}



	// ◈ === oFindBy »
	public static function oFindByFilter(array $filter, $retrieve = 'all', $select = null)
	{
		$query = static::query();
		foreach ($filter as $column => $value) {
			$query->where($column, $value);
		}

		if ($select || ($retrieve !== null && $retrieve !== 'all' && $retrieve != 1)) {
			$query->select($select ?? $retrieve);
		}

		if (!$retrieve || $retrieve === 'all') {
			return $query->get();
		}

		$record = $query->first();

		return $retrieve == 1 ? $record : ($record?->$retrieve ?? null);
	}



	// ◈ === oFindByColumn »
	public static function oFindByColumn($column, $value, $retrieve = 'all', $select = null)
	{
		$query = static::where($column, $value);

		if ($select || ($retrieve !== null && $retrieve !== 'all' && $retrieve != 1)) {
			$query->select($select ?? $retrieve);
		}

		if (!$retrieve || $retrieve === 'all') {
			return $query->get();
		}

		$record = $query->first();

		return $retrieve == 1 ? $record : ($record?->$retrieve ?? null);
	}



	// ◈ === oFindByID »
	public static function oFindByID($id, $column = 'id', $select = null)
	{
		if ($column === 'id') {
			if (!$select) {
				return self::find($id);
			}
			return self::find($id, $select);
		}
		return self::oFindByColumn($column, $id, 1, $select);
	}



	// ◈ === oFindByAuthor »
	public static function oFindByAuthor($authorID, $retrieve = 'all', $select = null)
	{
		return self::oFindByColumn('oauthor', $authorID, $retrieve, $select);
	}



	// ◈ === oFindAuthor » Gets the author's information from User Table
	public static function oFindAuthor($authorID, $select = null, $retrieve = 1)
	{
		// TODO: implement a reusable code
	}



	// ◈ === oDeleteByColumn »
	public static function oDeleteByColumn($value, $column)
	{
		return self::where($column, $value)->delete();
	}



	// ◈ === oHasColumn »
	public function hasColumn(string $column)
	{
		return Schema::hasColumn($this->getTable(), $column);
	}



	// ◈ === oHasValue »
	public function oHasValue(string $column, $value = null)
	{
		if (!isset($this->$column)) {
			return false;
		}
		return (is_null($value) || $this->$column == $value);
	}



	// ◈ === oLastColumn » Get value of a column from latest row →
	public function oLastColumn($column, $withTrashed = true)
	{
		$query = $withTrashed ? static::withTrashed() : static::query();
		return $query->latest()->value($column);
	}



	// ◈ === oLastRow » Get latest row →
	public function oLastRow($withTrashed = true)
	{
		$query = $withTrashed ? static::withTrashed() : static::query();
		return $query->latest()->first();
	}



	// ◈ === oLastID »
	public function oLastID($id = 'id', $withTrashed = true)
	{
		return $this->oLastColumn($id, $withTrashed);
	}



	// ◈ === oHasGuid »
	public static function oHasGuid($guid, $withTrashed = true)
	{
		$query = $withTrashed ? static::withTrashed() : static::query();
		return $query->where('guid', $guid)->exists();
	}



	// ◈ === oLastGuid »
	public static function oLastGuid($withTrashed = true)
	{
		$query = $withTrashed ? static::withTrashed() : static::query();
		return $query->latest()->value('guid');
	}



	// ◈ === oMaxGuid »
	public static function oMaxGuid($withTrashed = true)
	{
		$query = $withTrashed ? static::withTrashed() : static::query();
		return $query->max('guid');
	}



	// ◈ === oGuid » Generates a unique GUID → [numeric]
	public static function oGuid($withTrashed = true)
	{
		$lastGuid = self::oLastGuid($withTrashed);
		$newGuid = DataX::generateSN($lastGuid);
		if ($lastGuid && !self::hasGuid($newGuid)) {
			return $newGuid;
		}

		$maxGuid = self::maxSN($withTrashed);
		$newGuid = DataX::generateSN($maxGuid);
		if ($maxGuid && !self::hasGuid($newGuid)) {
			return $newGuid;
		}

		return DataX::generateSN();
	}



	// ◈ === oCreate »
	public static function oCreate($data)
	{
		return parent::create($data);
	}



	// ◈ === oDeleteByID »
	public static function oDeleteByID(int $id)
	{
		return self::where('id', $id)->delete();
	}



	// ◈ === oDeleteByGUID »
	public static function oDeleteByGUID(int $guid)
	{
		return self::where('guid', $guid)->delete();
	}



	// ◈ === oDeleteByPUID »
	public static function oDeleteByPUID(int $puid)
	{
		return self::where('puid', $puid)->delete();
	}



	// ◈ === oDeleteBySUID »
	public static function oDeleteBySUID(int $suid)
	{
		return self::where('suid', $suid)->delete();
	}



	// ◈ === oDeleteByTUID »
	public static function oDeleteByTUID(int $tuid)
	{
		return self::where('tuid', $tuid)->delete();
	}



	// ◈ === fillableColumns »
	private function fillableColumns()
	{
		return ['guid', 'puid', 'suid', 'tuid', 'oauthor', 'status', 'date'];
	}

}//> end of trait ~ Model