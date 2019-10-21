<?php

namespace App\Http\Service\client;

use App\Model\Time;
use App\Model\Customer;
use App\Model\Order;
use App\Model\Service;
use App\Model\Bill;
use App\Model\BillDetail;
use App\Model\Rate;
use App\Model\Employee;
use App\Model\OrderDetail;
use App\Model\Card;
use Illuminate\Support\Facades\Auth; //Thư viện để đăng nhập
use App\Model\Membership;

class ClientService
{
    protected $timeModel, $customerModel, $orderModel, $serviceModel, $billModel, $billDetailModel, $rateModel, $employeeModel, $orderDetailModel, $cardModel, $membershipModel;

    public function __construct(Time $time, Customer $customer, Order $order, Service $service, Bill $bill, BillDetail $billDetail, Rate $rate, Employee $employee, OrderDetail $orderDetail, Card $card, Membership $member)
    {
        $this->timeModel = $time;
        $this->customerModel = $customer;
        $this->orderModel = $order;
        $this->serviceModel = $service;
        $this->billModel = $bill;
        $this->billDetailModel = $billDetail;
        $this->rateModel = $rate;
        $this->employeeModel = $employee;
        $this->orderDetailModel = $orderDetail;
        $this->cardModel = $card;
        $this->membershipModel = $member;
    }

    public function bookView($phone)
    {
        $timeList = $this->timeModel->all();
        $skinner = $this->employeeModel->where('service_id', config('config.employee.type.skinner'))->get();
        $stylist = $this->employeeModel->where('service_id', config('config.employee.type.stylist'))->get();
        $serviceList = $this->serviceModel->where('id', '<=', 2)->get();
        $hairCut = $this->serviceModel->findOrFail(config('config.service.cut'));
        $wash = $this->serviceModel->findOrFail(config('config.service.wash'));
        $employee = $this->employeeModel->where('service_id', config('config.employee.type.skinner'))->get();
        $history = $this->orderModel->where('customer_id', auth('customers')->user()->id)
                                    ->where('status', config('config.order.status.check-out'))
                                    ->orderBy('id', 'desc')
                                    ->get();
        $data = [
            'skinner' => $skinner,
            'stylist' => $stylist,
            'phone' => $phone,
            'hairCut' => $hairCut,
            'wash' => $wash,
            'employee' => $employee,
            'time' => $timeList,
            'serviceList' => $serviceList,
            'historyList' => $history,
        ];
        
        return $data;
    }

    public function postPhone($request)
    {
        $check = $this->customerModel->where('phone', $request->phone)->count();

        if ($check > 0) {
            Auth::guard('customers')->attempt(['phone' => $request->phone, 'password' => $request->phone]);
        } else {
            /*insert vào bảng khách hàng*/
                $user = $this->customerModel->create([
                    'phone' => $request->phone,
                    'password' => bcrypt($request->phone),
                ]);
                auth('customers')->login($user);
                
            /*end*/
        }
    }

    // public function orderView()
    // {
    //     $employee = $this->employeeModel->where('service_id', config('config.employee.type.skinner'))
    //                                     ->get();

    //     $data = [
    //         'employee' => $employee
    //     ];

    //     return $data;
    // }

    public function book($request)
    {
        $customerId = auth('customers')->user()->id;
        $checkBook = $this->orderModel->where('customer_id', auth('customers')->user()->id)
                                      ->where('date', date('Y-m-d'))
                                      ->where('status', config('config.order.status.create'))
                                      ->first();
        $phone = $request->phone;
        $service = $request->service;
        $stylist = $request->stylist; // nhân viên cắt
        $skinner = $request->skinner; // nhân viên gội
        $otherEmployee = $request->other;

        if ($stylist == NULL) {
            $requestInsert = config('config.request.no');
        } else {
            $requestInsert = config('config.request.yes');
        }

        if (isset($checkBook)) {
            $this->orderDetailModel->where('order_id', $checkBook->id)->delete();
            $checkBook->delete();
            $true = 1;
        } else {
            $true = 0;
        }

        $orderId = $this->orderModel->insertGetId([
            'customer_id' => $customerId,
            'time_id' => $request->time,
            'date' => date('Y-m-d'),
            'request' => $requestInsert,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        for ($i = 0; $i < count($service) ; $i++) {
            if ($service[$i] == config('config.employee.type.skinner')) {
                $employeeId = $skinner;
            } elseif ($service[$i] == config('config.employee.type.stylist')) {
                $employeeId = $stylist;
            } elseif ($service[$i] == 0) {
                $employeeId = $otherEmployee;
            }

            $this->orderDetailModel->create([
                'service_id' => $service[$i],
                'employee_id' => $employeeId,
                'order_id' => $orderId,
            ]);
        }

        return $true;
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
                                        ->where('status', '<', config('config.order.status.check-out'))
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
                                ->first();
        if (isset($bill)) {
            $billDetail = $this->billDetailModel->where('bill_id', $bill->id)->get();
            $sum = $this->billDetailModel->where('bill_id', $bill->id)->sum('sale_money');
            $data = [
                'bill' => $bill,
                'billDetail' => $billDetail,
                'sum' => $sum - $bill->sale,
            ];

            return $data;
        }
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

    public function homeView()
    {
        if (auth('customers')->check()) {
            $customerId = auth('customers')->user()->id;
            $card = $this->membershipModel->where('customer_id', $customerId)->where('status', 1)->get();

            if ($card->count() > 0) {
                $data = [
                    'card' => $card
                ];
                
                return $data;
            } else {
                $data = [
                    'card' => ''
                ];

                return $data;
            }
        }
    }

    public function finishRate($request)
    {
        $comment = $request->comment;
        $commentNumber = count($comment);
        $string = '';
        for ($i = 0; $i < $commentNumber; $i ++) {
            $string = $string . $comment[$i];
        }
        $this->billModel->updateOrCreate(
            ['rate_status' => 1],
            [
                'comment' => $string
            ]
        );

        return $this->billModel
                    ->where('rate_status', 1)
                    ->update(['rate_status' => 0]);
    }
}
