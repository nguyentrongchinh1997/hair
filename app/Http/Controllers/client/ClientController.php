<?php

namespace App\Http\Controllers\client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Service\client\HomeService;
use App\Model\Bill;
use App\Model\BillDetail;
use App\Model\Rate;

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

    public function rate(Request $request)
    {
        $rate = $this->homeService->getRate();
        $check = $this->homeService->checkRateStatus();

        if ($check > 0) {
            if ($request->get('step') != '') {
                $step = $request->get('step');
                if ($step == 2) {
                    return view('client.pages.rate.step2', $rate);
                } else if ($step == 3) {
                    return view('client.pages.rate.step3', ['bill' => $rate['bill']]);
                } else if ($step == 1) {
                    return view('client.pages.rate.step1', $this->homeService->billAccept());
                }
            }
            return view('client.pages.rate.rate', ['bill' => $rate['bill']]);
        } else {
            return view('client.pages.rate.rate', ['bill' => $rate['bill']]);
        }

    }

    public function billAccept()
    {
        return view('client.pages.rate.step1', $this->homeService->billAccept()); // bước 1
    }

    public function input()
    {
        $bill = $this->homeService->getInput();

        if (isset($bill)) {
            echo "<input type='hidden' value='$bill->id'>";
        } else {
            echo "<input type='hidden' value=''>";
        }
    }

    public function rateContent($billId)
    {
        $this->homeService->rateContent($billId);
    }

    public function load()
    {
        $this->homeService->load();

        return view('client.pages.rate.step2', $this->homeService->load());
    }

    public function updateRate($rate, $billId)
    {
        $this->homeService->updateRate($rate, $billId);
    }

    public function updateComment($comment, $billId)
    {
        $this->homeService->updateComment($comment, $billId);
    }
}
