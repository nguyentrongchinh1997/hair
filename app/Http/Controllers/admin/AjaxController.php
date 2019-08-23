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

    public function resultList($key)
    {
        $data = [
            'orderList' => $this->ajaxService->resultList($key),
        ];

        return view('admin.ajax.order_list', $data);
    }

    public function search($keySearch)
    {
        return view('admin.ajax.bill_list', $this->ajaxService->billList($keySearch));
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

/*check-in*/
    public function checkIn($idOrder)
    {
        $this->ajaxService->checkIn($idOrder);
    }
/*end*/
}
