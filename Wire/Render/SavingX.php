<?php //*** SavingX ~ trait » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Wire\Render;

trait SavingX
{
	// ◈ === abstract »
	abstract protected function initX();
	abstract protected function factorizeX(&$input, $action);
	abstract protected function restore($action, $id);



	// ◈ === iResolveX »
	protected function iResolveX($action, $response, null|string|array $success = null, ?string $next = null)
	{
		if ($response === true || (is_numeric($response) && $response >= 1)) {
			$this->successX($success);
			if (!empty($next)) {
				return $this->redirectX($next);
			}

			if (in_array($action, ['update'])) {
				return $this->{$action}($id);
			} elseif ($action === 'create') {
				return $this->create();
			}
		}
	}



	// ◈ === iSavingX »
	protected function iSavingX($action, $id = null, $input = [], null|string|array $success = null, ?string $next = null)
	{
		$this->initX();

		$fields = $input;
		if (empty($input)) {
			$fields = $this->modelX::getFields();
		}

		$response = false;

		if (in_array($action, ['create', 'update'])) {

			if (!empty($fields)) {
				$this->grabParamX($input, $fields);
				$this->cleanInputX($input);
				$this->factorizeX(input: $input, action: $action);
			}

			if (!empty($id)) {
				$response = $this->modelX::modify($id, $input);
			}

		}

		return $this->iResolveX($action, $response, $success, $next);
	}

}//> end of trait ~ SavingX