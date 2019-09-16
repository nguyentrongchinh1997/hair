<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Service\admin\RateService;

class RateController extends Controller
{
	protected $rateService;

	public function __construct(RateService $rateService)
	{
		$this->rateService = $rateService;
	}
    public function getRateList()
    {
        return view('admin.pages.rate.list', $this->rateService->getRateList());
    }

    public function postRate(Request $request, $rateId)
    {
        $this->rateService->postRate($request, $rateId);

        return back()->with('thongbao', 'Sửa phần trăm thành công');
    }
}
