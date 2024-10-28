<?php //*** ModelX » Tydi™ Framework © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//
namespace App\Tydi\Trait;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Spry\HandlerX;
use App\Spry\ArrayX;
use App\Spry\DebugX;
use App\Spry\DataX;

trait Model
{
	// • === oCreateParentChildX → ... »
	public static function oCreateParentChildX($input, $childModel, $parentChildMethod)
	{
		$parentRow = $input['parent'];
		$childRow = $input['child'];
		DB::beginTransaction();
		try {
			$parent = parent::create($parentRow);
			if (ArrayX::isMultiAndKeyNumeric($childRow)) {
				foreach ($childRow as $row) {
					$child = new $childModel($row);
					$parent->{$parentChildMethod}()->save($child);
				}
			} else {
				$child = new $childModel($childRow);
				$parent->{$parentChildMethod}()->save($child);
			}
			DB::commit();
		} catch (\Exception $e) {
			DB::rollback();
			Log::error($e);
			dd($e);
			return false;
		}
		return true;
	}





	// • === oCreateX → ... » instance of model | id (primary key) | array(errors)
	public static function oCreateX(array $input, $returnID = false)
	{
		$input = DataX::create($input);
		$o = HandlerX::query(
			function () use ($input, $returnID) {
				$res = parent::create($input);
				if ($returnID === true && isset ($res->id)) {
					return $res->id;
				}
				return $res;
			}
		);
		return $o;
	}





	// • === oUpdateX → ... » success [true, numOfAffectedRows] | error [null, array, false]
	public static function oUpdateX(array $input, $bind)
	{
		$o = HandlerX::query(
			function () use ($input, $bind) {
				if (count($bind) === 1 && !empty ($bind['id'])) {
					$query = parent::find($bind['id']);
				} elseif (count($bind) === 1) {
					$column = array_key_first($bind);
					$value = $bind[$column];
					$query = parent::where($column, $value);
				} elseif (count($bind) > 1) {
					$query = parent::query();
					foreach ($bind as $column => $value) {
						$query->where($column, $value);
					}
				}
				if ($query) {
					return $query->update($input);
				}
				return $query;
			}
		);
		return $o;
	}





	// • ==== oSaveX → ... »
	public static function oSaveX(array $input, $id = null)
	{
		$o = HandlerX::query(
			function () use ($input, $id) {
				if (!is_null($id) && !empty ($id)) {
					$input['id'] = $id;
				}

				if (empty ($input['id'])) {
					$input = DataX::create($input);
					$record = new self();
				} else {
					$model = new self();
					$record = $model::find($input['id']);
					unset ($input['id']);
				}

				foreach ($input as $column => $value) {
					if ($value !== '') {
						$record->$column = $value;
					}
				}
				return $record->save();
			}
		);
		return $o;
	}





	// • === oDeleteX → ... » success [true, numOfAffectedRows] | error [zero, null, array, false]
	public static function oDeleteX(array $filter)
	{
		$o = HandlerX::query(
			function () use ($filter) {
				$query = null;
				if (count($filter) === 1) {
					if (!empty ($filter['id'])) {
						$query = parent::oFindIdX($filter['id']);
					} elseif (!empty ($filter['puid'])) {
						$query = self::oFindPuidX($filter['puid']);
					} else {
						$column = array_key_first($filter);
						$value = $filter[$column];
						$query = parent::where($column, $value);
					}
				} elseif (count($filter) > 1) {
					$query = parent::query();
					foreach ($filter as $column => $value) {
						$query->where($column, $value);
					}
				}
				if ($query instanceof EloquentBuilder || $query instanceof EloquentModel) {
					return $query->delete();
				}
				return $query;
			}
		);
		return $o;
	}





	// • === oDeleteIdX → ... »
	public static function oDeleteIdX($id)
	{
		return self::oDeleteX(['id' => $id]);
	}





	// • === oDeletePuidX → ... »
	public static function oDeletePuidX($puid)
	{
		return self::oDeleteX(['puid' => $puid]);
	}





	// • ==== oFindX → ... »
	public static function oFindX(array $filter, $field = null, $firstRow = false)
	{

		if (count($filter) === 1) {
			if (!empty($filter['id'])) {
				return self::oFindIdX($filter['id'], $field);
			}
			if (!empty($filter['puid'])) {
				return self::oFindPuidX($filter['puid'], $field);
			}
		}

		$o = HandlerX::query(
			function () use ($filter, $firstRow, $field) {
				$query = parent::query();
				foreach ($filter as $column => $value) {
					$query->where($column, $value);
				}
				if ($query) {
					if (!is_null($field) && !empty ($field)) {
						if (is_string($field)) {
							$field = [$field];
						}
						$query->select($field);
					}
					if ($firstRow) {
						return $query->first();
					}
					return $query->get();
				}
			}
		);
		return $o;
	}





	// • ==== oFindIdX → ... »
	public static function oFindIdX($id, $column = null)
	{
		$o = HandlerX::query(
			function () use ($id, $column) {
				if (!is_null($column) && !empty ($column)) {
					if (is_string($column)) {
						$res = parent::find($id);
						if ($res) {
							$res = isset ($res->$column) ? $res->$column : $res;
						}
						return $res;
					}
					if (is_array($column)) {
						return parent::select($column)->find($id);
					}
				}
				return parent::find($id);
			}
		);
		return $o;
	}





	// • ==== oFindPuidX → ... »
	public static function oFindPuidX($puid, $column = null)
	{
		$o = HandlerX::query(
			function () use ($puid, $column) {
				if (!is_null($column) && !empty ($column)) {
					if (is_string($column)) {
						$res = parent::where('puid', $puid)->first();
						if ($res) {
							$res = isset ($res->$column) ? $res->$column : $res;
						}
						return $res;
					}
					if (is_array($column)) {
						return parent::select($column)->where('puid', $puid)->first();
					}
				}
				return parent::where('puid', $puid)->first();
			}
		);
		return $o;
	}

} //> end of ModelX