<?php //*** HandlerX » Tydi™ Framework © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//
namespace App\Spry;

use Illuminate\Database\QueryException;

class HandlerX
{


	// • ==== eloquent → ... » []
	public static function eloquent(callable $callback)
	{
		try {
			return $callback();
		} catch (QueryException $e) {
			if (($violation = self::isDuplicate($e)) !== false) {
				// return response()->json(['error' => 'Duplicate record found.'], 422);
			}
			throw $e;
		}
	}



	// • ==== isDuplicate → ... » []
	private static function isDuplicate(QueryException $e)
	{
		// if($e->getCode() === '23000' || $e->errorInfo[1] === 1062){
		if ($e->errorInfo[1] === 1062) {
			$message = $e->errorInfo[2];
			$matches = [];
			preg_match('/Duplicate entry \'(.+?)\' for key/', $message, $matches);
			if (isset($matches[1])) {
				$value = $matches[1];
				$column = StringX::after($message, 'key');
				$column = StringX::crop($column, "'");
				$column = StringX::cropEnd($column, '_unique');
				$column = StringX::after($column, '.');
				$column = StringX::afterAs($column, '_');
				$duplicate = [$column => $value];

				if (!empty($duplicate)) {
					$error = [
						'error' => true,
						'type' => 'duplicate',
						'data' => $duplicate,
						'summary' => 'Oops, duplicate ' . strtolower($column) . ' (' . strtolower(Str($value)->words(3)) . ')!',
						'message' => ucfirst($column) . 'exists',
						'log' => $message
					];
					return $error;
				}
			}

		}
		return false;
	}



	public static function query(callable $callback)
	{
		try {
			return $callback();
		} catch (QueryException $e) {

			// checking for duplicate entry
			if ($e->errorInfo[1] === 1062) {
				$message = $e->errorInfo[2];
				$matches = [];
				preg_match('/Duplicate entry \'(.+?)\' for key/', $message, $matches);
				if (isset($matches[1])) {
					$value = $matches[1];
					$column = StringX::after($message, 'key');
					$column = StringX::crop($column, "'");
					$column = StringX::cropEnd($column, '_unique');
					$column = StringX::after($column, '.');
					$column = StringX::afterAs($column, '_');
					$duplicate = [$column => $value];
				}

				if (!empty($duplicate)) {
					$error = [
						'error' => true,
						'type' => 'DUPLICATE',
						'data' => $duplicate,
						'summary' => 'Oops, duplicate '.strtolower($column) . ' (' . strtolower(Str($value)->words(3)) . ')!',
						'log' => $message
					];
					return $error;
				}
			}

			// TODO: Implementation to handle other types of QueryException error

			// dd($e->errorInfo[1]);

			throw $e;
		}
	}



	public static function hasError($response)
	{
		if (is_array($response) && isset($response['error']) && $response['error'] === true) {
			return true;
		}
		return false;
	}



	public static function hasErrorSummary($response)
	{
		if (self::hasError($response) && !empty($response['summary'])) {
			return true;
		}
		return false;
	}


	public static function getErrorSummary($response)
	{
		if (self::hasErrorSummary($response)) {
			return $response['summary'];
		}
		return false;
	}



	public static function hasDuplicate($error)
	{
		if (self::hasError($error) && !empty($error['type']) && strtoupper($error['type']) === 'DUPLICATE') {
			return true;
		}
		return false;
	}
}
