<?php

namespace App\Http\Service\admin;
use App\Model\Customer;
use App\Model\Order;
use App\Model\OrderDetail;
use App\Model\Bill;
use App\Model\BillDetail;

class CustomerService
{
	protected $orderModel, $billModel, $customerModel, $orderDetailModel, $billDetailModel;

    public function __construct(Order $order, Bill $bill, Customer $customer, OrderDetail $orderDetail, BillDetail $billDetail)
    {
        $this->orderModel = $order;
        $this->billModel = $bill;
        $this->customerModel = $customer;
        $this->orderDetailModel = $orderDetail;
        $this->billDetailModel = $billDetail;
    }

    public function customerListview()
    {
        $customerList = $this->customerModel->paginate(10);
        $data = [
            'customerList' => $customerList
        ];

        return $data;
    }

    public function postDeposit($request)
    {
        $customer = $this->customerModel
        				->findOrFail($request->customer_id);
        $money = $customer->balance + str_replace(',', '', $request->money);

        return $this->customerModel->updateOrCreate(
            ['id' => $request->customer_id],
            [
                'balance' => $money,
            ]
        );
    }

    public function viewDetailCustomer($customerId)
    {
        $customer = $this->customerModel->findOrFail($customerId);
        $customerHistory = $this->billModel
                                ->where('customer_id', $customerId)
                                ->where('status', config('config.order.status.check-out'))
                                ->with('billDetail')
                                ->get();
        $data = [
            'customer' => $customer,
            'customerHistory' => $customerHistory,
        ];

        return $data;
    }

    public function customerSerachResult($key)
    {
        $customerList = $this->customerModel
                            ->where('phone', 'like', $key . '%')
                            ->orWhere('full_name', 'like', '%' . $key . '%')
                            ->get();
        $data = [
            'customerList' => $customerList,
        ];

        return $data;
    }
}