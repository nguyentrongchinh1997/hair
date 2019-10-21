<?php

namespace App\Http\Service\admin;

use App\Model\Employee;
use App\Model\Order;
use App\Model\Bill;
use App\Model\Time;
use App\Model\Customer;
use App\Model\Service;
use App\Model\OrderDetail;
use App\Model\BillDetail;
use App\Model\EmployeeCommision;
use App\Model\Card;
use App\Model\CardDetail;
use App\Model\Membership;

class OrderService
{
	protected $employeeModel, $orderModel, $billModel, $customerModel, $timeModel, $serviceModel, $orderDetailModel, $billDetailModel, $employeeComissionModel, $cardModel, $cardDetailModel, $membershipModel;

    public function __construct(Employee $employee, Order $order, Bill $bill, Customer $customer, Time $time, Service $service, OrderDetail $orderDetail, BillDetail $billDetail, EmployeeCommision $employeeComission, Card $card, CardDetail $cardDetail, Membership $membership)
    {
        $this->employeeModel = $employee;
        $this->orderModel = $order;
        $this->billModel = $bill;
        $this->customerModel = $customer;
        $this->timeModel = $time;
        $this->serviceModel = $service;
        $this->orderDetailModel = $orderDetail;
        $this->billDetailModel = $billDetail;
        $this->employeeComissionModel = $employeeComission;
        $this->cardModel = $card;
        $this->cardDetailModel = $cardDetail;
        $this->membershipModel = $membership;
    }

	public function orderListView()
    {
        $day = date('d');
        $month = date('m');
        $year = date('Y');
        $date = date('d/m/Y');
        $orderList = $this->orderModel->where('date', date('Y-m-d'))
                                      ->where('status', '>=', config('config.order.status.create'))
                                      ->orderBy('id', 'desc')
                                      ->with('orderDetail')
                                      ->get();
        $bill = $this->billModel->where('status', config('config.order.status.check-in'))->paginate(20);
        $stylist = $this->employeeModel->where('service_id', config('config.service.cut'))->get();
        $skinner = $this->employeeModel->where('service_id', config('config.service.wash'))->get();
        $time = $this->timeModel->all();
        $data = [
            'orderList' => $orderList,
            'billList' => $bill,
            'day' => $day,
            'month' => $month,
            'year' => $year,
            'date' => $date,
            'stylist' => $stylist,
            'skinner' => $skinner,
            'time' => $time,
        ];

        return $data;
    }

    public function checkIn($orderId, $request)
    {   
        $order = $this->orderModel->findOrFail($orderId);
        $orderDetail = $this->orderDetailModel->where('order_id', $orderId)->get();
        $customer = $this->customerModel->findOrFail($order->customer_id);
    /*nếu không có tên + ngày sinh thì update*/
        if ($customer->full_name == '' && $customer->birthday == '') {
            $this->customerModel->updateOrCreate(
                ['id' => $order->customer_id],
                [
                    'full_name' => $request->full_name,
                    'birthday' => $request->birthday,
                    'request' => $request->require,
                ]
            );
        }
    /*end*/
        $order->request = $request->require;
        $order->save();
    /*tạo hóa đơn*/
        $bill_id = $this->billModel->insertGetId([
            'customer_id' => $order->customer_id,
            'order_id' => $orderId,
            'date' => $order->date,
            'created_at' => date('Y-m-d H:i:s'),
            'status' => config('config.order.status.check-in'),
        ]);
    /*end*/

        foreach ($orderDetail as $service) {
            // $saleMoney = $this->checkMembership($order->customer_id, $service->service_id, $service->service->price);
            $billDetailId = $this->billDetailModel->insertGetId([
                'bill_id' => $bill_id,
                'service_id' => $service->service_id,
                'employee_id' => $service->employee_id,
                'assistant_id' => $service->assistant_id,
                'money' => $service->service->price,
                'sale_money' => $service->service->price,
                'created_at' => date('Y-m-d H:i:s'),
                'date' => date('Y-m-d'),
            ]);

            /*Thêm vào bảng hoa hồng*/
                if ($request->require == 1) {
                    $percent = $service->service->main_request_percent;
                } else {
                    $percent = $service->service->percent;
                }
                $this->employeeComissionModel->create(
                    [
                        'employee_id' => $service->employee_id,
                        'bill_detail_id' => $billDetailId,
                        'percent' => $percent,
                        'date' => date('Y-m-d'),
                    ]
                );

                if ($service->assistant_id != '') {
                    $this->employeeComissionModel->create(
                        [
                            'employee_id' => $service->assistant_id,
                            'bill_detail_id' => $billDetailId,
                            'percent' => $service->service->assistant_percent,
                            'date' => date('Y-m-d'),
                        ]
                    );
                }
            /*end*/
        }

        return $this->orderModel->updateOrCreate(
            ['id' => $orderId],
            [
                'status' => config('config.order.status.check-in'),
                'bill_id' => $bill_id,
            ]
        );
    }

    public function checkMembership($customer_id, $service_id, $priceService)
    {
        $checkCard = $this->membershipModel->where('customer_id', $customer_id)->first();
        if (isset($checkCard)) {
            $cardDetail = $this->cardDetailModel->where('service_id', $service_id)
                                                ->where('card_id', $checkCard->card_id)
                                                ->first();
            if (isset($checkCard) && (strtotime(date('Y-m-d')) <= strtotime($checkCard->end_time)) && isset($cardDetail)) {
                $saleMoney = $priceService - ($priceService * $cardDetail->percent/100);
            } else {
                $saleMoney = $priceService;
            }
        } else {
            $saleMoney = $priceService;
        }
    
        return $saleMoney;
    }

    public function postOrderListView($request)
    {
        $day = $request->day;
        $month = $request->month;
        $year = $request->year;
        $stylist = $this->employeeModel->where('service_id', config('config.service.cut'))->get();
        $skinner = $this->employeeModel->where('service_id', config('config.service.wash'))->get();

        if ($month < 10) {
            $month = '0'.$month;
        }
        if ($day < 10) {
            $day = '0'.$day;
        }
        $date = $year . '-' . $month . '-' . $day;
        $orderList = $this->orderModel->where('date', $date)
                                      ->where('status', '>=', config('config.order.status.create'))
                                      ->orderBy('id', 'desc')
                                      ->get();
        $time = $this->timeModel->all();

        $data = [
            'orderList' => $orderList,
            'day' => $day,
            'month' => $month,
            'year' => $year,
            'date' => $day . '/' . $month . '/' . $year,
            'stylist' => $stylist,
            'skinner' => $skinner,
            'time' => $time,
        ];

        return $data;
    }

    public function addOrder($request)
    {
        $phone = $request->phone;
        $service = $request->service;
        $employee = $request->employee;
        $time_id = $request->time_id;
        $date = $request->date;
        $checkPhone = $this->customerModel->where('phone', $phone)->first();

        if (isset($checkPhone)) {
            $fullName = $checkPhone->full_name;
            $customerId = $checkPhone->id;
        } else {
            $fullName = $request->full_name;
            $customerId = $this->customerModel->insertGetId(
                [
                    'full_name' => $fullName,
                    'phone' => $phone,
                    'password' => bcrypt($phone),
                ]
            );
        }

        $orderId = $this->orderModel->insertGetId(
            [
                'customer_id' => $customerId,
                'date' => $date,
                'time_id' => $time_id,
                'status' => config('config.order.status.create'),
                'request' => $request->require,
                'created_at' => date('Y-m-d H:i:s'),
            ]
        );

        for ($i = 0; $i < count($service); $i++) {
            $this->orderDetailModel->create(
                [
                    'service_id' => $service[$i],
                    'employee_id' => $employee[$i],
                    'order_id' => $orderId,
                ]
            );
        }
    }

    public function orderDetail($orderId)
    {
        $employeeList = $this->employeeModel->where('status', config('config.employee.status.doing'))->get();
        $order = $this->orderModel->where('id', $orderId)->with('orderDetail')->first();
        $serviceList = $this->serviceModel->where('status', '>', 0)->get();
        $data = [
            'serviceList' => $serviceList,
            'orderDetail' => $order,
            'employeeList' => $employeeList,
        ];

        return $data;
    }

    public function resultList($key, $date1)
    {
        if ($key != '') {
            $orderList = $this->customerModel
                              ->where('phone', 'like', $key . '%')
                              ->orWhere('full_name', 'like', '%' . $key . '%')
                              ->with(['order' => function($q) use ($date1) {
                                    $q->where('orders.date', $date1)
                                      ->where('status', '>', config('config.order.status.cancel'))
                                      ->orderBy('id', 'desc');
                                    }
                                ])
                              ->has('order')
                              ->orderBy('id', 'desc')
                              ->get();
        } else {
            $orderList = $this->customerModel
                              ->with(['order' => function($q) use ($date1) {
                                    $q->where('orders.date', $date1)
                                      ->where('status', '>', config('config.order.status.cancel'))
                                      ->orderBy('id', 'desc');
                                    }
                                ])
                              ->has('order')
                              ->orderBy('id', 'desc')
                              ->get();
        }


        return $orderList;
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

    public function updateAssistant($assistantId, $id)
    {
        if ($assistantId == 0) {
            $assistantId = NULL;
        }
        return $this->orderDetailModel->updateOrCreate(
            ['id' => $id],
            [
                'assistant_id' => $assistantId,
            ]
        );
    }

    public function orderCancel($id)
    {
        return $this->orderModel->updateOrCreate(
            ['id' => $id],
            ['status' => config('config.order.status.cancel')]
        );
    }

    public function serviceAdd($request)
    {
        $orderId = $request->get('orderId');
        $serviceId = $request->get('serviceId');
        $employeeId = $request->get('employeeId');
        if ($request->get('assistantId') == 0) {
            $assistantId = NULL;
        } else {
            $assistantId = $request->get('assistantId');
        }
        $orderDetailId = $this->orderDetailModel->create(
            [
                'service_id' => $serviceId,
                'employee_id' => $employeeId,
                'assistant_id' => $assistantId,
                'order_id' => $orderId,
            ]
        );
        $orderDetail = $this->orderDetailModel->findOrFail($orderDetailId->id);
        $data = [
            'orderId' => $orderId,
            'serviceId' => $serviceId,
            'employeeId' => $employeeId,
            'assistantId' => $assistantId,
            'orderDetail' => $orderDetailId,
        ];



        return $data;
    }
}
