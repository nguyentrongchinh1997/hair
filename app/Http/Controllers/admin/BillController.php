<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Service\admin\BillService;

class BillController extends Controller
{
    protected $billService;

    public function __construct(BillService $billService)
    {
        $this->billService = $billService;
    }

    public function finish(Request $request, $billId)
    {
        $this->billService->finish($billId, $request);

        return back()->with('thongbao', 'Thanh toán thành công');
    }

    public function billList()
    {
        return view('admin.pages.bill.list', $this->billService->billList());
    }

    public function postBillList(Request $request)
    {
        return view('admin.pages.bill.list', $this->billService->postBillList($request));
    }

    public function search(Request $request)
    {
        $keySearch = $request->get('keySearch');
        $date = $request->get('date');
        return view('admin.ajax.bill_list', $this->billService->billSearchResult($keySearch, $date));
    }

    public function billDetail($billId)
    {
        return view('admin.pages.bill.detail', $this->billService->billDetail($billId));
    }

    public function serviceAdd(Request $request)
    {
        $billId = $request->billId;
        $serviceId = $request->serviceId;
        $employeeId = $request->employeeId;
        $assistantId = $request->assistantId;

        return view('admin.ajax.add_service', $this->billService->serviceAdd($billId, $serviceId, $employeeId, $assistantId));
    }

    public function serviceDelete($billDetailId)
    {
        echo $this->billService->serviceDelete($billDetailId);
    }

    public function serviceOtherAdd(Request $request)
    {
        $billId = $request->billId;
        $serviceName = $request->serviceName;
        $employeeId = $request->employeeId;
        $assistantId = $request->assistantId;
        $money = $request->money;
        // $percent = $request->percent;
        $percentEmployee = $request->percentEmployee;
        $percentAssistant =$request->percentAssistant;
        $data = $this->billService->serviceOtherAdd($billId, $serviceName, $employeeId, $assistantId, $money, $percentEmployee, $percentAssistant);
        
        return view('admin.ajax.add_service_other', ['data' => $data]);
    }

    public function updateCashier($billId)
    {
        $this->billService->updateCashier($billId);
    }

    public function addBill(Request $request)
    {
        $this->billService->addBill($request);

        return back();
    }

    public function rateUpdate($billId)
    {
        return view('admin.ajax.rate', $this->billService->rateUpdate($billId));
    }

    public function payView(Request $request, $billId)
    {
        return view('admin.pages.bill.bill', $this->billService->payView($billId, $request));
    }

    public function printBill($billId)
    {
        return view('admin.pages.bill.print', $this->billService->printBill($billId));
    }

    public function cardCheck($idBillDetail, $cardId)
    {
        echo $this->billService->cardCheck($idBillDetail, $cardId);
    }

    public function priceRestore($idBillDetail)
    {
        echo $this->billService->priceRestore($idBillDetail);
    }

    public function percentStylist(Request $request) {
        $money = str_replace(',', '', $request->get('money'));
        $price = str_replace(',', '', $request->get('price'));
        $percent = ($money/$price) * 100;
        echo number_format((float)$percent, 1);
    }

    public function percentSkinner(Request $request) {
        $money = str_replace(',', '', $request->get('money'));
        $price = str_replace(',', '', $request->get('price'));
        $percent = ($money/$price) * 100;
        echo number_format((float)$percent, 1);
    }

    public function addBillHand(Request $request)
    {
        $this->billService->addBillHand($request);

        return back()->with('thongbao', 'thêm hóa đơn thành công');
    }
}
