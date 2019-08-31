<?php

namespace App\Http\Service\client;

use App\Model\Time;
use App\Model\Customer;
use App\Model\Order;
use App\Model\Service;
use App\Model\Bill;
use App\Model\BillDetail;
use App\Model\Rate;

class HomeService
{
    protected $timeModel, $customerModel, $orderModel, $serviceModel, $billModel, $billDetailModel, $rateModel;

    public function __construct(Time $time, Customer $customer, Order $order, Service $service, Bill $bill, BillDetail $billDetail, Rate $rate)
    {
        $this->timeModel = $time;
        $this->customerModel = $customer;
        $this->orderModel = $order;
        $this->serviceModel = $service;
        $this->billModel = $bill;
        $this->billDetailModel = $billDetail;
        $this->rateModel = $rate;
    }

    public function timeList()
    {
        $timeList = $this->timeModel->all();
        $serviceList = $this->serviceModel->where('id', '<=', 2)->get();
        $data = [
            'time' => $timeList,
            'serviceList' => $serviceList,
        ];

        return $data;
    }

    public function order($request)
    {
        $customer = $this->customerModel->where('phone', $request->phone)->first();
        $service = $this->serviceModel->findOrFail($request->service);

        if (isset($customer)) {
            $date = date('Y-m-d');
            $check = $this->orderModel->where('date', $date)
                                        ->where('service_id', $request->service)
                                        ->where('customer_id', $customer->id)
                                        ->first();
            if (isset($check)) {
                /*update order*/
                    return $this->orderModel->updateOrCreate(
                        [
                            'customer_id' => $customer->id,
                            'date' => $date,
                        ],
                        [
                            'time_id' => $request->time,
                            'employee_id' => $request->employee,
                        ]
                    );
                /*end*/
            } else {
                /*insert vào bảng orders*/
                    return $this->orderModel->create([
                        'customer_id' => $customer->id,
                        'employee_id' => $request->employee,
                        'time_id' => $request->time,
                        'date' => date('Y-m-d'),
                        'service_id' => $request->service,
                    ]);
                /*end*/
            }
        } else {
            $this->customerModel->phone = $request->phone;
            $this->customerModel->save();
            
            return $this->orderModel->create([
                'customer_id' => $this->customerModel->id,
                'employee_id' => $request->employee,
                'time_id' => $request->time,
                'date' => date('Y-m-d'),
                'service_id' => $request->service,
            ]);
        }
    }

    public function updateRate($rate, $billId)
    {
        return $this->billModel->updateOrCreate(
            ['id' => $billId],
            [
                'rate_id' => $rate,
            ]
        );
    }

    public function updateComment($comment, $billId)
    {
        $bill = $this->billModel->findOrFail($billId);

        if ($bill->comment == '') {
            $commentUpdate = $comment;
        } else {
            $replace = str_replace($comment, '', $bill->comment);
            $commentUpdate = $replace . $comment;
        }
        
        return $this->billModel->updateOrCreate(
            ['id' => $billId],
            [
                'comment' => $commentUpdate,
            ]
        );
    }

    public function load()
    {
        $bill = $this->billModel->where('rate_status', 1)->first();
        $data = [
            'bill' => $bill,
        ];

        return $data;
    }

    public function rateContent($billId)
    {
        $bill = $this->billModel->findOrFail($billId);
        $bill->rate_status = 1;
        $bill->save();

        return $this->billModel->where('id', '<>', $billId)->update(['rate_status' => 0]);
    }

    public function billAccept()
    {
        $bill = $this->billModel->where('rate_status', 1)
                                ->with(['order' => function($query){
                                    $query->where('date', date('Y-m-d'));
                                }])
                                ->first();
        $billDetail = $this->billDetailModel->where('bill_id', $bill->id)->get();
        $sum = $this->billDetailModel->where('bill_id', $bill->id)->sum('money');
        $data = [
            'bill' => $bill,
            'billDetail' => $billDetail,
            'sum' => $sum - $bill->sale,
        ];

        return $data;
        
    }

    public function checkRateStatus()
    {
        $bill = $this->billModel->where('rate_status', 1)->get();

        return $bill->count();
    }

    public function getInput()
    {
        return $this->billModel->where('rate_status', 1)->first();
    }

    public function getRate()
    {
        $rateList = $this->rateModel->all();
        $bill = $this->billModel->where('rate_status', 1)->first();
        $data = [
            'bill' => $bill, 
            'rateList' => $rateList,
        ];

        return $data;
    }
}
