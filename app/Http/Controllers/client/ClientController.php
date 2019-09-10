<?php

namespace App\Http\Controllers\client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Service\client\ClientService;
use App\Model\Bill;
use App\Model\BillDetail;
use App\Model\Rate;

class ClientController extends Controller
{
	protected $clientService;

	public function __construct(ClientService $clientService)
	{
		$this->clientService = $clientService;
	}

    public function homeView()
    {
    	return view('client.pages.home', $this->clientService->timeList());
    }

    public function postPhone(Request $request)
    {
        $this->clientService->postPhone($request);

        return redirect()->route('order.view');
    }

    public function order(Request $request)
    {
    	$this->clientService->order($request);

    	return redirect()->route('client.home')->with('thongbao', 'Đặt lịch thành công');
    }

    public function rate(Request $request)
    {
        $rate = $this->clientService->getRate();
        $check = $this->clientService->checkRateStatus();

        if ($check > 0) {
            if ($request->get('step') != '') {
                $step = $request->get('step');
                if ($step == 2) {
                    return view('client.pages.rate.step2', $rate);
                } else if ($step == 3) {
                    return view('client.pages.rate.step3', ['bill' => $rate['bill']]);
                } else if ($step == 1) {
                    return view('client.pages.rate.step1', $this->clientService->billAccept());
                }
            }
            // return view('client.pages.rate.rate', ['bill' => $rate['bill']]);
        } else {
            return redirect('rate');
            // return view('client.pages.rate.rate', ['bill' => $rate['bill']]);
        }

    }

    public function rateView()
    {
        $rate = $this->clientService->getRate();
        return view('client.pages.rate.rate', ['bill' => $rate['bill']]);
    }

    public function billAccept()
    {
        return view('client.pages.rate.step1', $this->clientService->billAccept()); // bước 1
    }

    public function input()
    {
        $bill = $this->clientService->getInput();

        if (isset($bill)) {
            echo "<input type='hidden' id='bill-id' class='bill-id' value='$bill->id'>";
        } else {
            echo "<input type='hidden' id='bill-id' class='bill-id' value=''>";
        }
    }

    public function rateContent($billId)
    {
        $this->clientService->rateContent($billId);
    }

    public function load()
    {
        $this->clientService->load();

        return view('client.pages.rate.step2', $this->clientService->load());
    }

    public function updateRate($rate, $billId)
    {
        $this->clientService->updateRate($rate, $billId);
    }

    public function orderView()
    {
        return view('client.pages.order.book', $this->clientService->timeList());
    }

    public function book(Request $request)
    {
        $this->clientService->book($request);

        return back();
    }
}
