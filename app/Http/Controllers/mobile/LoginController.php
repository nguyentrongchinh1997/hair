<?php

namespace App\Http\Controllers\mobile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Service\mobile\loginService;

class LoginController extends Controller
{
	protected $loginService;

	public function __construct(LoginService $login)
	{
		$this->loginService = $login;
	}

    public function loginView()
    {
    	return view('client.mobile.pages.login');
    }

    public function postLogin(Request $request) {
    	$this->loginService->postLogin($request);

    	return redirect('mobile/home');
    }
}
