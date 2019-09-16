<?php

namespace App\Http\Service\admin;

use App\Model\Order;
use App\Model\Customer;
use App\Model\Bill;
use App\Model\BillDetail;
use App\Model\Service;
use App\Model\Employee;
use App\Model\OrderDetail;

class AjaxService
{
    protected $orderModel, $customerModel, $billModel, $billDetailModel, $serviceModel, $employeeModel, $orderDetailModel;

    public function __construct(Order $order, Customer $customer, Bill $bill, BillDetail $billDetail, Service $service, Employee $employee, OrderDetail $orderDetail)
    {
        $this->orderModel = $order;
        $this->customerModel = $customer;
        $this->billModel = $bill;
        $this->billDetailModel = $billDetail;
        $this->serviceModel = $service;
        $this->employeeModel = $employee;
        $this->orderDetailModel = $orderDetail;
    }

    public function updateCustomer($idCustomer, $nameCustomer, $birthday)
    {
        $customerInfo = $this->customerModel->findOrFail($idCustomer);

        return $this->customerModel->updateOrCreate(
            ['id' => $idCustomer],
            [
                'full_name' => $nameCustomer,
                'birthday' => $birthday,
            ]
        );
    }

    public function pay($billId, $employeeId, $price_total, $number)
    {
        if ($number == 0) {
            $this->orderModel->updateOrCreate(
                ['bill_id' => $billId],
                ['status' => config('config.order.status.check-out')]
            );
            return $this->billModel->updateOrCreate(
                ['id' => $billId],
                [
                    'total' => $price_total,
                    'status' => config('config.order.status.check-out'),
                ]
            );
        } else {
            $total = str_replace(',', '', $number) + $price_total;
            $this->billDetailModel->create([
                'bill_id' => $billId,
                'employee_id' => $employeeId,
                'money' => str_replace(',', '', $number),
            ]);
            $this->orderModel->updateOrCreate(
                ['bill_id' => $billId],
                ['status' => config('config.order.status.check-out')]
            );
            return $this->billModel->updateOrCreate(
                ['id' => $billId],
                [
                    'total' => $total,
                    'status' => config('config.order.status.check-out'),
                ]
            );
        }
    }
}
