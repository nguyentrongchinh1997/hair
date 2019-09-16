<?php

namespace App\Http\Service\admin;

use App\Model\Employee;
use App\Model\Service;
use App\Model\Order;
use App\Model\Bill;
use App\Model\Customer;
use App\Model\BillDetail;
use App\Model\Rate;
use App\Model\Time;
use App\Model\OrderDetail;
use Carbon\Carbon;
use App\Model\Card;
use App\Model\CardDetail;

class AdminService
{
    protected $employeeModel, $serviceModel, $orderModel, $billModel, $customerModel, $billDetailModel, $rateModel, $timeModel, $orderDetailModel, $cardModel, $cardDetailModel;

    public function __construct(Employee $employee, Service $service, Order $order, Bill $bill, Customer $customer, BillDetail $billDetail, Rate $rate, Time $time, OrderDetail $orderDetail, Card $card, CardDetail $cardDetail)
    {
        $this->employeeModel = $employee;
        $this->serviceModel = $service;
        $this->orderModel = $order;
        $this->billModel = $bill;
        $this->customerModel = $customer;
        $this->billDetailModel = $billDetail;
        $this->rateModel = $rate;
        $this->timeModel = $time;
        $this->orderDetailModel = $orderDetail;
        $this->cardModel = $card;
        $this->cardDetailModel = $cardDetail;
    }

    public function pay($billId, $servicePrice)
    {
        $bill = $this->billModel->findOrFail($billId);
        $customer = $this->customerModel->findOrFail($bill->customer_id);
        $total = $servicePrice - $bill->sale;
        $balance = $customer->balance - $total;
        $billDetail = $this->billDetailModel->where('bill_id', $billId)->get();

        
        if ($balance < 0 ) {
            $balanceUpdate = 0;
        } elseif ($balance > 0 && $balance >= $total) {
            $balanceUpdate = $balance - $total;
        } elseif ($balance > 0 && $balance <= $total) {
            $balanceUpdate = 0;
        }
        
        $employee = $this->billDetailModel->where('bill_id', $billId)->distinct()->get(['employee_id', 'bill_id']);
        foreach ($employee as $employee) {
            $employeeList = $this->billDetailModel->where('bill_id', $billId)->where('employee_id', $employee->employee_id)->get();
            foreach ($employeeList as $e) {
                if ($e->service_id != '') {
                    $balance = $this->employeeModel->findOrFail($e->employee_id);
                    $percentService = $e->service->percent; // chiết khấu % dịch vụ
                    $percentEmployee = $e->employee->percent; // chiết khấu % nhân viên
                    if ($bill->rate->type == 1) {
                        $percentTotal = $percentService + $percentEmployee + $employee->bill->rate->percent; // tổng phần trăm 
                    } else {
                        $percentTotal = $percentService + $percentEmployee - $employee->bill->rate->percent; // tổng phần trăm 
                    }
                    $priceTotal = $e->service->price * $percentTotal/100; // tổng tiền nhân viên nhận được mỗi dịch vụ
                    $balance->balance = $priceTotal + $balance->balance;
                    $balance->save();
                } else {
                    $balance = $this->employeeModel->findOrFail($e->employee_id);
                    $percentService = $e->other_service_percent; // chiết khấu % dịch vụ
                    $percentEmployee = $e->employee->percent; // chiết khấu % nhân viên
                    if ($bill->rate->type == 1) {
                        $percentTotal = $percentService + $percentEmployee + $employee->bill->rate->percent; // tổng phần trăm 
                    } else {
                        $percentTotal = $percentService + $percentEmployee - $employee->bill->rate->percent; // tổng phần trăm 
                    }
                    $priceTotal = $e->money * $percentTotal/100; // tổng tiền nhân viên nhận được mỗi dịch vụ
                    $balance->balance = $priceTotal + $balance->balance;
                    $balance->save();
                }

            }
        }

        $this->billModel->updateOrCreate(
            ['id' => $billId],
            [
                'status' => 2,
                'total' => $total,
            ]
        );

        $this->orderModel->updateOrCreate(
            ['id' => $bill->order_id],
            [
                'status' => 2,
            ]
        );
        $this->customerModel->updateOrCreate(
            ['id' => $bill->customer_id],
            ['balance' => $balanceUpdate]
        );

        return $this->billModel->where('id', '>', 0)->update(['rate_status' => 0]);
    }
    public function getRate($billId)
    {
        return $this->billModel->findOrFail($billId);
    }

    public function getComment($billId)
    {
        return $this->billModel->findOrFail($billId);
    }

    public function bill($billId)
    {
        return $this->billModel->findOrFail($billId);
    }

    public function priceTotal($billId)
    {
        $sum = $this->billDetailModel->where('bill_id', $billId)->sum('money');
        $bill = $this->billModel->findOrFail($billId);
        $customer = $this->customerModel->findOrFail($bill->customer_id);
        $balance = $customer->balance;
        $total = $sum - $bill->sale; // số tiền phải trả
        if ($balance >= $total) {
            $payPrice = $customer->balance - $total;
        } elseif ($balance > 0 && $balance < $total) {
            $payPrice = $total - $balance;
        } else {
            $payPrice = $total;
        }

        // return number_format($payPrice) . ' Đ';
        return $payPrice;
    }
}
