<?php

namespace App\Http\Controllers\mobile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Service\mobile\CustomerService;

class CustomerController extends Controller
{
	protected $customerService;

	public function __construct(CustomerService $client)
	{
		$this->customerService = $client;
	}
    public function viewHome()
    {
    	$phone = auth('customers')->user()->phone;
    	return view('client.mobile.customers.pages.home', $this->customerService->viewHome($phone));
    }

    public function logout()
    {
    	auth('customers')->logout();

    	return redirect()->route('mobile.login');
    }

    public function history()
    {
    	return view('client.mobile.customers.pages.history', $this->customerService->history());
    }

    public function card()
    {
    	return view('client.mobile.customers.pages.card', $this->customerService->card());
    }
}
