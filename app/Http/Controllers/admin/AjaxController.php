<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Service\admin\AjaxService;

class AjaxController extends Controller
{
    protected $ajaxService;

    public function __construct(AjaxService $ajax)
    {
        $this->ajaxService = $ajax;
    }

    public function resultList($key, $date)
    {
        $data = [
            'orderList' => $this->ajaxService->resultList($key, $date),
        ];

        return view('admin.ajax.order_list', $data);
    }

    public function search($keySearch, $date)
    {
        return view('admin.ajax.bill_list', $this->ajaxService->billList($keySearch, $date));
    }

    public function orderDetail($orderId)
    {
        return view('admin.pages.order.detail',$this->ajaxService->orderDetail($orderId));
    }

    public function updateCustomer($idCustomer, $nameCustomer, $birthday)
    {
        $date = date_format(date_create($birthday), 'd/m/Y');
        $this->ajaxService->updateCustomer($idCustomer, $nameCustomer, $birthday);

        echo "
            <td>Tên khách hàng</td>
            <td>:</td>
            <td>
                $nameCustomer
            </td>
            <td>
                <span style='font-weight: bold;'>Ngày sinh</span>: $date</td>";
    }

    public function billDetail($billId)
    {
        return view('admin.pages.bill.detail', $this->ajaxService->billDetail($billId));
    }

    public function pay($billId, $employeeId, $price_total, $number)
    {
        $this->ajaxService->pay($billId, $employeeId, $price_total, $number);
        echo "<h3 style='color: #007bff'>Thành toán thành công</h3>";
    }

    public function serviceAdd($billId, $serviceId, $employeeId, $money)
    {
        echo $this->ajaxService->serviceAdd($billId, $serviceId, $employeeId, $money);
    }

    public function serviceDelete($billDetailId)
    {
        echo $this->ajaxService->serviceDelete($billDetailId);
    }

    public function serviceOtherAdd($billId, $serviceId, $employeeId, $money, $percent)
    {
        echo $this->ajaxService->serviceOtherAdd($billId, $serviceId, $employeeId, $money, $percent);
    }

    public function updateSale(Request $request, $billId)
    {
        echo $this->ajaxService->updateSale($request, $billId);
    }

    public function updateCashier($billId)
    {
        $this->ajaxService->updateCashier($billId);
    }

    public function rateUpdate($billId)
    {
        return view('admin.ajax.rate', $this->ajaxService->rateUpdate($billId));
    }

    public function deleteOrder($orderDetailId, $orderId)
    {
        $notification = $this->ajaxService->deleteOrder($orderDetailId, $orderId);

        echo $notification;
    }

    public function editService($serviceId, $orderDetailId)
    {
        $this->ajaxService->editService($serviceId, $orderDetailId);
    }

    public function editEmployee($employeeId, $orderDetailId)
    {
        $this->ajaxService->editEmployee($employeeId, $orderDetailId);
    }
}
