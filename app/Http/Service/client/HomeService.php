<?php

namespace App\Http\Service\client;

use App\Model\Time;
use App\Model\Customer;
use App\Model\Order;
use App\Model\Service;

class HomeService
{
    protected $timeModel, $customerModel, $orderModel, $serviceModel;

    public function __construct(Time $time, Customer $customer, Order $order, Service $service)
    {
        $this->timeModel = $time;
        $this->customerModel = $customer;
        $this->orderModel = $order;
        $this->serviceModel = $service;
    }

    public function timeList()
    {
        $timeList = $this->timeModel->all();
        $serviceList = $this->serviceModel->all();
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
                /*update số dư*/
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
                $balance = $customer->balance - $service->price;
                /*update số dư*/
                    $this->customerModel->updateOrCreate(
                        [
                            'phone' => $request->phone,
                        ],
                        [
                            'balance' => $balance,
                        ]
                    );
                /*end*/

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
}
