<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; //Thư viện để đăng nhập

class LoginController extends Controller
{
    public function loginView()
    {
    	return view('admin.login');
    }

    public function login(Request $request)
    {
    	$username = $request->username;
    	$password = $request->password;


    	if (Auth::attempt(['email' => $username, 'password' => $password])) {
    		return redirect()->route('admin.home');
    	} else if (Auth::guard('employees')->attempt(['phone' => $username, 'password' => $password], true)){
    		return redirect()->route('admin.home');
    	} else {
    		dd(2);
    	}
    }

    public function logout()
    {
    	auth()->logout();
    	auth('employees')->logout();
    	return redirect()->route('login');
    }
}
