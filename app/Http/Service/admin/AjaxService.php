<?php

namespace App\Http\Service\admin;

use App\Model\Order;
use App\Model\Customer;
use App\Model\Bill;
use App\Model\BillDetail;
use App\Model\Service;
use App\Model\Employee;

class AjaxService
{
    protected $orderModel, $customerModel, $billModel, $billDetailModel, $serviceModel, $employeeModel;

    public function __construct(Order $order, Customer $customer, Bill $bill, BillDetail $billDetail, Service $service, Employee $employee)
    {
        $this->orderModel = $order;
        $this->customerModel = $customer;
        $this->billModel = $bill;
        $this->billDetailModel = $billDetail;
        $this->serviceModel = $service;
        $this->employeeModel = $employee;
    }

    public function resultList($key, $date1)
    {
        $orderList = $this->customerModel
                            ->where('phone', 'like', $key . '%')
                            ->with(['order' => function($q) use ($date1){
                $q->where('orders.status', config('config.order.status.create'))->where('orders.date', $date1);
            }])->get();

        return $orderList;
    }

    public function billList($keySearch, $date)
    {
        $customer = $this->customerModel
                        ->where('phone', 'like', $keySearch . '%')
                        ->with('bill')
                        ->get();
        $data = [
            'customer' => $customer,
            'date' => $date,
        ];

        return $data;
    }

    public function orderDetail($orderId)
    {
        $order = $this->orderModel->findOrFail($orderId);
        $data = [
            'orderDetail' => $order,
        ];

        return $data;
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

    public function billDetail($billId)
    {
        $bill = $this->billModel->findOrFail($billId);
        $employeeList = $this->employeeModel->all();
        $serviceList = $this->serviceModel->where('id', '!=', $bill->order->service_id)->get();
        $moneyServiceTotal = $this->billDetailModel->where('bill_id', $billId)->sum('money');
        $serviceListUse = $this->billDetailModel->where('bill_id', $billId)->get();
        $data = [
            'employeeList' => $employeeList,
            'serviceList' => $serviceList,
            'bill' => $bill,
            'moneyServiceTotal' => $moneyServiceTotal,
            'serviceListUse' => $serviceListUse,
        ];

        return $data;
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

    public function serviceAdd($billId, $serviceId, $employeeId, $money)
    {
        $id = $this->billDetailModel->insertGetId([
            'bill_id' => $billId,
            'service_id' => $serviceId,
            'employee_id' => $employeeId,
            'money' => $money,
        ]);

        return $id;
    }

    public function serviceOtherAdd($billId, $serviceName, $employeeId, $money, $percent)
    {
        $convertMoney = str_replace(',', '', $money);
        $id = $this->billDetailModel->insertGetId([
            'bill_id' => $billId,
            'other_service' => $serviceName,
            'employee_id' => $employeeId,
            'money' => $convertMoney,
            'other_service_percent' => $percent,
        ]);

        return $id;
    }

    public function serviceDelete($billDetailId)
    {
        $billDetail = $this->billDetailModel->findOrFail($billDetailId);
        $price = $billDetail->money;
        $billDetail->delete();

        return $price;
    }

    public function updateSale($sale, $saleDetail, $billId)
    {
        return $this->billModel->updateOrCreate(
            ['id' => $billId],
            [
                'sale' => str_replace(',', '', $sale),
                'sale_detail' => $saleDetail,
            ]
        );
    }
}
