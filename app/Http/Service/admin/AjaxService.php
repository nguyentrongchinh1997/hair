<?php

namespace App\Http\Service\admin;

use App\Model\Order;
use App\Model\Customer;
use App\Model\Bill;

class AjaxService
{
    protected $orderModel, $customerModel, $billModel;

    public function __construct(Order $order, Customer $customer, Bill $bill)
    {
        $this->orderModel = $order;
        $this->customerModel = $customer;
        $this->billModel = $bill;
    }

    public function resultList($key)
    {
        $orderList = $this->customerModel->where('phone', 'like', $key . '%')->with('order')->get();

        return $orderList;
    }

    public function billList($keySearch)
    {
        $customer = $this->customerModel->where('phone', 'like', $keySearch . '%')->with('bill')->get();
        $data = [
            'customer' => $customer,
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

    public function checkIn($orderId)
    {
        $order = $this->orderModel->findOrFail($orderId);
        $bill = $this->billModel;

        $bill->customer_id = $order->customer_id;
        $bill->order_id = $orderId;
        $bill->price = $order->service->price;
        $bill->status = config('config.order.status.check-in');
        $bill->save();
        $bill_id = $bill->id;

        return $this->orderModel->updateOrCreate(
            ['id' => $orderId],
            [
                'status' => config('config.order.status.check-in'),
                'bill_id' => $bill_id,
            ]
        );
    }
}
