<?php //*** Auth ~ class » Yale™ Library - Yet Another Laravel Elevator © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//

namespace Yale\Vine\Organizr;

use Yale\Anci\EnvX;
use Yale\Anci\DebugX;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;

class Auth
{
	// ◈ property
	private $init = false;
	private $path;



	// ◈ === passwordChange »
	public function passwordChange(Request $request)
	{
		return view($this->setViewAs('password'), $this->setData());
	}



	// ◈ === profileUpdate »
	public function profileUpdate(Request $request)
	{
		return view($this->setViewAs('profile'), $this->setData());
	}



	// ◈ === signatureUpdate »
	public function signatureUpdate(Request $request)
	{
		return view($this->setViewAs('signature'), $this->setData());
	}



	// ◈ === signout »
	public function signout(Request $request)
	{
		return view($this->setViewAs('signout'), $this->setData());
	}



	// ◈ === resetForm »
	public function resetForm()
	{
		$this->resetErrorBag();
		// $this->reset(['field']);
		// $this->reset();
	}



	// ◈ === viewAs »
	private function setViewAs($view)
	{
		$this->init();
		$view = $this->path . $view;
		if (View::exists($view)) {
			return $view;
		}
		return DebugX::blade404($view);
	}



	// ◈ === setData »
	private function setData(array $data = null, Request $request = null): array
	{
		$data = $data ?? [];
		$request = $request ?? request();
		return array_merge($data, [
			'request' => $request,
			'user' => $request->user(),
		]);
	}



	// ◈ === init »
	private function init()
	{
		if (!$this->init) {
			$this->path = EnvX::project('theme') . '.page.auth.';
			$this->init = true;
		}
	}

}//> end of class ~ Auth