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
    	return view('client.mobile.customers.pages.login');
    }

    public function postLogin(Request $request) {
    	$this->loginService->postLogin($request);

    	return redirect()->route('mobile.home');
    }

    public function loginEmployeeView()
    {
        return view('client.mobile.employees.pages.login');
    }

    public function postLoginEmployee(Request $request)
    {
        $login = $this->loginService->postLoginEmployee($request);

        if ($login == true) {
            return redirect()->route('mobile.employee.home');
        } else {
            return back();
        }
    }
}
