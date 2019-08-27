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

    public function total($price, $price2)
    {
        $total = number_format(str_replace(',', '', $price) + $price2);

        return view('admin.pages.bill.total', ['total' => $total]);
    }

    public function pay($billId, $employeeId, $price_total, $number)
    {
        $this->ajaxService->pay($billId, $employeeId, $price_total, $number);
        echo "<h3 style='color: #007bff'>Thành toán thành công</h3>";
    }
}