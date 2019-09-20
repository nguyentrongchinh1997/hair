<?php

namespace App\Http\Controllers\mobile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Service\mobile\ClientService;

class ClientController extends Controller
{
	protected $clientService;

	public function __construct(ClientService $client)
	{
		$this->clientService = $client;
	}
    public function viewHome()
    {
    	$phone = auth('customers')->user()->phone;
    	return view('client.mobile.pages.home', $this->clientService->viewHome($phone));
    }

    public function logout()
    {
    	auth('customers')->logout();

    	return redirect('mobile/login');
    }
}
