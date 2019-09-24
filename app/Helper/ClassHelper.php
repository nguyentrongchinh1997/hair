<?php

namespace App\Helper;

use App\Model\Bill;
use App\Model\BillDetail;
use App\Model\OrderDetail;
use App\Model\Order;

class ClassHelper
{
    public static function customerName($billId)
    {       
        $employeeId = auth('employees')->user()->id;
        $customerName = Bill::where('id', $billId)
                            ->with(['billDetail' => function($query) use ($employeeId){
                                $query->where('employee_id', $employeeId)
                                    ->orWhere('assistant_id', $employeeId);
                            }])
                            ->first();
        return $customerName;
    }
/*Lấy những hóa đơn đã check-in (đang hoạt động)*/
    public static function getBillId()
    {
        $date = date('Y-m-d');
        $employeeId = auth('employees')->user()->id;
        $billIdList = BillDetail::where('created_at', 'like', '%' . $date . '%')
                    ->where(function($query) use ($employeeId) {
                        $query->where('employee_id', $employeeId)
                              ->orWhere('assistant_id', $employeeId);
                    })
                    ->get()
                    ->groupBy('bill_id');

        return $billIdList;
    }
/*end*/

    public static function checkBill($key)
    {
        $check = Bill::findOrFail($key);

        if ($check->status == config('config.order.status.check-in')) {
            return true;
        } else {
            return false;
        }
    }

    public static function check()
    {
        $dem = 0;
        $classHelper = new ClassHelper();

        if ($classHelper->getBillId()->count() == 0) {
            return $dem;
        } else {
            foreach ($classHelper->getBillId() as $key => $order) {
                if ($classHelper->customerName($key)->status == config('config.order.status.check-in')) {
                        $dem++;
                    }
                }

            return $dem;
        }
    }

    public static function customerNameOrder($billId)
    {       
        $employeeId = auth('employees')->user()->id;
        $customerName = Order::where('id', $billId)
                            ->with(['orderDetail' => function($query) use ($employeeId){
                                $query->where('employee_id', $employeeId)
                                    ->orWhere('assistant_id', $employeeId);
                            }])
                            ->first();
        return $customerName;
    }

/*Lấy những đơn chưa check-in(đợi)*/
    public static function getOrderId()
    {
        $date = date('Y-m-d');
        $employeeId = auth('employees')->user()->id;
        $billIdList = OrderDetail::where('created_at', 'like', $date . '%')
                    ->where(function($query) use ($employeeId){
                        $query->where('employee_id', $employeeId)
                              ->orWhere('assistant_id', $employeeId);
                    })
                    ->get()
                    ->groupBy('order_id');

        return $billIdList;
    }
/*end*/

    public static function checkOrder()
    {
        $dem = 0;
        $classHelper = new ClassHelper();

        if ($classHelper->getOrderId()->count() == 0) {
            return $dem;
        } else {
            foreach ($classHelper->getOrderId() as $key => $order) {
                if ($classHelper->customerNameOrder($key)->status == config('config.order.status.create')) {
                        $dem++;
                    }
                }

            return $dem;
        }
    }
}
