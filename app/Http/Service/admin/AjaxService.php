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
        $employeeList = $this->employeeModel->where('status', config('config.employee.status.doing'))->get();
        $order = $this->orderModel->where('id', $orderId)->with('orderDetail')->first();
        $serviceList = $this->serviceModel->all();
        $data = [
            'serviceList' => $serviceList,
            'orderDetail' => $order,
            'employeeList' => $employeeList,
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
        $rate = $this->billModel->findOrFail($billId);;
        $comment = $this->billModel->findOrFail($billId);
        $bill = $this->billModel->findOrFail($billId);
        $employeeList = $this->employeeModel->where('status', config('config.employee.status.doing'))->get();
        $serviceList = $this->serviceModel->where('id', '!=', $bill->order->service_id)->get();
        $moneyServiceTotal = $this->billDetailModel->where('bill_id', $billId)->sum('money');
        $serviceListUse = $this->billDetailModel->where('bill_id', $billId)->get();
        $customer = $this->customerModel->findOrFail($bill->customer_id);
        $balance = $customer->balance;
        $total = $moneyServiceTotal - $bill->sale; // số tiền phải trả
        if ($balance >= $total) {
            $payPrice = $customer->balance - $total;
        } elseif ($balance > 0 && $balance < $total) {
            $payPrice = $total - $balance;
        } else {
            $payPrice = $total;
        }
        $data = [
            'payPrice' => $payPrice,
            'rate' => $rate,
            'comment' => $comment,
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
        $bill = $this->billModel->findOrFail($billId);

        if ($bill->status != config('config.order.status.check-out')) {
            $id = $this->billDetailModel->insertGetId([
                'bill_id' => $billId,
                'service_id' => $serviceId,
                'employee_id' => $employeeId,
                'money' => $money,
                'date' => date('Y-m-d'),
            ]);

            return $id;
        } else {
            return '';
        }
    }

    public function serviceOtherAdd($billId, $serviceName, $employeeId, $money, $percent)
    {
        $bill = $this->billModel->findOrFail($billId);

        if ($bill->status != config('config.order.status.check-out')) {
            $convertMoney = str_replace(',', '', $money);
            $id = $this->billDetailModel->insertGetId([
                'bill_id' => $billId,
                'other_service' => $serviceName,
                'employee_id' => $employeeId,
                'money' => $convertMoney,
                'other_service_percent' => $percent,
                'date' => date('Y-m-d'),
            ]);

            return $id;
        } else {
            return '';
        }
    }

    public function serviceDelete($billDetailId)
    {
        $bill = $this->billDetailModel->findOrFail($billDetailId);

        if ($bill->bill->status != config('config.order.status.check-out')) {
            $billDetail = $this->billDetailModel->findOrFail($billDetailId);
            $price = $billDetail->money;
            $billDetail->delete();

            return $price;
        } else {
            return '';
        }

    }

    public function updateSale($request, $billId)
    {
        $bill = $this->billModel->findOrFail($billId);
        $sale = $request->get('sale');
        $saleDetail = $request->get('saleDetail');
        if ($bill->status != config('config.order.status.check-out')) {
            $this->billModel->updateOrCreate(
                ['id' => $billId],
                [
                    'sale' => str_replace(',', '', $sale),
                    'sale_detail' => $saleDetail,
                ]
            );
            return 1;
        } else {
            return '';
        }

    }

    public function updateCashier($billId)
    {
        if (auth()->check()) {
            $idUser = auth()->user()->id;
        } else if (auth('employees')->check()) {
            $idUser = auth('employees')->user()->id;
        }

        return $this->billModel->updateOrCreate(
            ['id' => $billId],
            [
                'cashier' => $idUser,
            ]
        );
    }

    public function rateUpdate($billId)
    {
        $bill = $this->billModel->findOrFail($billId);
        $data = [
            'bill' => $bill,
        ];

        return $data;
    }

    public function deleteOrder($orderDetailId, $orderId)
    {
        $orderCount = $this->orderDetailModel->where('order_id', $orderId)->count();

        if ($orderCount == 1) {
            $notification = 'Không được phép xóa';
            
            return 0; 
        } else {
            $this->orderDetailModel->where('id', $orderDetailId)->where('order_id', $orderId)->delete();

            return 1;
        }
    }

    public function editService($serviceId, $orderDetailId)
    {
        return $this->orderDetailModel->updateOrCreate(
            ['id' => $orderDetailId],
            [
                'service_id' => $serviceId
            ]
        );
    }

    public function editEmployee($employeeId, $orderDetailId)
    {
        return $this->orderDetailModel->updateOrCreate(
            ['id' => $orderDetailId],
            [
                'employee_id' => $employeeId
            ]
        );
    }
}
