<?php //*** SavingX ~ trait » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Wire\Render;

use Yale\Wire\Render\ResolveX;

trait SavingX
{
	// ◈ trait
	use ResolveX;



	// ◈ === abstract »
	abstract protected function initX();
	abstract protected function factorizeX(&$input, $action);
	abstract protected function restore($action, $id);



	// ◈ === iSavingX »
	protected function iSavingX($action, $id = null, $input = [], null|string|array $success = null, ?string $next = null)
	{
		$this->initX();

		$fields = $input;
		if (empty($input)) {
			$fields = $this->modelX::getFields();
		}

		$result = false;


		if (in_array($action, ['create', 'update', 'clone'])) {

			if (!empty($fields)) {
				$this->grabParamX($input, $fields);
				$this->cleanInputX($input);
				$this->factorizeX(input: $input, action: $action);
			}

			if ($action === 'create' || $action === 'clone') {
				$result = $this->modelX::oCreate($input);
			}

			if (!empty($id) && $action === 'update') {
				$result = $this->modelX::oUpdateByID($id, $input);
			}
		}

		return $this->iResolveX($action, $result, $id, $success, $next);
	}

}//> end of trait ~ SavingX