<?php

namespace App\Http\Controllers\client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Service\client\HomeService;

class ClientController extends Controller
{
	protected $homeService;

	public function __construct(HomeService $homeService)
	{
		$this->homeService = $homeService;
	}

    public function homeView()
    {
    	return view('client.pages.home', $this->homeService->timeList());
    }

    public function order(Request $request)
    {
    	$this->homeService->order($request);

    	return redirect()->route('client.home')->with('thongbao', 'Đặt lịch thành công');
    }
}
