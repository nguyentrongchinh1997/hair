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

class OrderService
{
	protected $employeeModel, $orderModel, $billModel, $customerModel, $timeModel, $serviceModel, $orderDetailModel, $billDetailModel, $employeeComissionModel, $cardModel, $cardDetailModel;

    public function __construct(Employee $employee, Order $order, Bill $bill, Customer $customer, Time $time, Service $service, OrderDetail $orderDetail, BillDetail $billDetail, EmployeeCommision $employeeComission, Card $card, CardDetail $cardDetail)
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
    }

	public function orderListView()
    {
        $day = date('d');
        $month = date('m');
        $year = date('Y');
        $date = date('d/m/Y');
        $orderList = $this->orderModel->where('date', date('Y-m-d'))->orderBy('created_at', 'desc')->with('orderDetail')->get();
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
                ]
            );
        }
    /*end*/

    /*tạo hóa đơn*/
        $bill_id = $this->billModel->insertGetId([
            'customer_id' => $order->customer_id,
            'order_id' => $orderId,
            'created_at' => date('Y-m-d H:i:s'),
            'status' => config('config.order.status.check-in'),
        ]);
    /*end*/

        foreach ($orderDetail as $service) {
        $checkCard = $this->cardDetailModel->where('service_id', $service->service_id)
                                            ->where('customer_id', $order->customer_id)
                                            ->first();

        if (isset($checkCard) && (strtotime(date('Y-m-d')) <= strtotime($checkCard->card->end_time))) {
            $sale_money = $service->service->price - ($service->service->price * $checkCard->percent/100);
        } else {
            $sale_money = $service->service->price;
        }
        /*thêm vào bảng chi tiết hóa đơn*/
            $billDetailId = $this->billDetailModel->insertGetId([
                'bill_id' => $bill_id,
                'service_id' => $service->service_id,
                'employee_id' => $service->employee_id,
                'assistant_id' => $service->assistant_id,
                'money' => $service->service->price,
                'sale_money' => $sale_money,
                'created_at' => date('Y-m-d H:i:s'),
                'date' => date('Y-m-d'),
            ]);
        /*end*/

        /*Thêm vào bảng hoa hồng*/
            if ($order->request == 1) {
                $percent = $service->service->main_request_percent;
            } else {
                $percent = $service->service->percent;
            }
            $this->employeeComissionModel->create(
                [
                    'employee_id' => $service->employee_id,
                    'bill_detail_id' => $billDetailId,
                    'percent' => $percent,
                ]
            );

            if ($service->assistant_id != '') {
                $this->employeeComissionModel->create(
                    [
                        'employee_id' => $service->assistant_id,
                        'bill_detail_id' => $billDetailId,
                        'percent' => $service->service->assistant_percent,
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
        $orderList = $this->orderModel->where('date', $date)->orderBy('created_at', 'desc')->paginate(20);
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
        $date = date('Y-m-d');
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
        $serviceList = $this->serviceModel->all();
        $data = [
            'serviceList' => $serviceList,
            'orderDetail' => $order,
            'employeeList' => $employeeList,
        ];

        return $data;
    }

    public function resultList($key, $date1)
    {
        $orderList = $this->customerModel
                            ->where('phone', 'like', $key . '%')
                            ->with(['order' => function($q) use ($date1)
                            {
                                $q->where('orders.date', $date1);
                                }
                            ])
                            ->get();

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
}
