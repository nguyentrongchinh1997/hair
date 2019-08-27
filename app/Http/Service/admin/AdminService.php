<?php

namespace App\Http\Service\admin;

use App\Model\Employee;
use App\Model\Service;
use App\Model\Order;
use App\Model\Bill;
use App\Model\Customer;
use App\Model\BillDetail;

class AdminService
{
    protected $employeeModel, $serviceModel, $orderModel, $billModel, $customerModel, $billDetailModel;

    public function __construct(Employee $employee, Service $service, Order $order, Bill $bill, Customer $customer, BillDetail $billDetail)
    {
        $this->employeeModel = $employee;
        $this->serviceModel = $service;
        $this->orderModel = $order;
        $this->billModel = $bill;
        $this->customerModel = $customer;
        $this->billDetailModel = $billDetail;
    }

    public function employeeAdd($request)
    {
        return $this->employeeModel->create([
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'type' => $request->type,
            'address' => $request->address,
            'percent' => $request->percent,
            'password' => bcrypt($request->password),
        ]);
    }

    public function serviceAdd($inputs)
    {
        return $this->serviceModel->create([
            'name' => $inputs['name'],
            'price' => str_replace(',', '', $inputs['price']),
        ]);
    }

    public function employeeListView()
    {
        $employeeList = $this->employeeModel->orderBy('created_at', 'desc')->paginate(20);
        $serviceList = $this->serviceModel->all();
        $data = [
            'employeeList' => $employeeList,
            'serviceList' => $serviceList,
        ];

        return $data;
    }

    public function serviceListView()
    {
        $serviceList = $this->serviceModel->orderBy('created_at', 'desc')->paginate(20);
        $data = [
            'serviceList' => $serviceList,
        ];

        return $data;
    }

    public function orderListView()
    {
        $day = date('d');
        $month = date('m');
        $year = date('Y');
        $orderList = $this->orderModel->where('status', config('config.order.status.create'))->where('date', date('Y-m-d'))->orderBy('created_at', 'desc')->paginate(20);
        $bill = $this->billModel->where('status', config('config.order.status.check-in'))->paginate(20);
        $data = [
            'orderList' => $orderList,
            'billList' => $bill,
            'day' => $day,
            'month' => $month,
            'year' => $year,
        ];

        return $data;
    }

    public function postOrderListView($request)
    {
        $day = $request->day;
        $month = $request->month;
        $year = $request->year;
        if ($month < 10) {
            $month = '0'.$month;
        }
        if ($day < 10) {
            $day = '0'.$day;
        }
        $date = $year . '-' . $month . '-' . $day;
        $orderList = $this->orderModel->where('status', config('config.order.status.create'))->where('date', $date)->orderBy('created_at', 'desc')->paginate(20);

        $data = [
            'orderList' => $orderList,
            'day' => $day,
            'month' => $month,
            'year' => $year,
        ];

        return $data;
    }

    public function billList()
    {
        $day = date('d');
        $month = date('m');
        $year = date('Y');
        $date = date('Y-m-d');
        $bill = $this->billModel
                    ->where('status', '>', config('config.order.status.create'))
                    ->with('order')
                    ->paginate(20);
        $data = [
            'billList' => $bill,
            'day' => $day,
            'month' => $month,
            'year' => $year,
            'date' => $date,
        ];

        return $data;
    }

    public function postBillList($request)
    {
        $day = $request->day;
        $month = $request->month;
        $year = $request->year;
        if ($month < 10) {
            $month = '0'.$month;
        }
        if ($day < 10) {
            $day = '0'.$day;
        }
        $date = $year . '-' . $month . '-' . $day;
        $bill = $this->billModel
                    ->where('status', '>', config('config.order.status.create'))
                    ->with('order')
                    ->paginate(20);

        $data = [
            'billList' => $bill,
            'day' => $day,
            'month' => $month,
            'year' => $year,
            'date' => $date,
        ];

        return $data;
    }

    public function oldDataEmployee($id)
    {
        $oldData = $this->employeeModel->findOrFail($id);
        $data = [
            'oldData' => $oldData,
        ];

        return $data;
    }

    public function oldDataService($id)
    {
        $oldData = $this->serviceModel->findOrFail($id);
        $data = [
            'oldData' => $oldData,
        ];

        return $data;
    }

    public function employeeEdit($request, $id)
    {
        $this->employeeModel->updateOrCreate(
            ['id' => $id],
            $request->all()
        );
    }

    public function serviceEdit($inputs, $id)
    {
        $service = $this->serviceModel->findOrFail($id);
        $service->name = $inputs['name'];
        $service->price = str_replace(',', '', $inputs['price']);
        
        return $service->save();
    }

    public function checkIn($orderId, $request)
    {
        $order = $this->orderModel->findOrFail($orderId);
        $this->customerModel->updateOrCreate(
            ['id' => $order->customer_id],
            [
                'full_name' => $request->full_name,
                'birthday' => $request->birthday,
            ]
        );
        $bill_id = $this->billModel->insertGetId([
            'customer_id' => $order->customer_id,
            'order_id' => $orderId,
            'price' => $order->service->price,
            'status' => config('config.order.status.check-in'),
        ]);

        $this->billDetailModel->create([
            'bill_id' => $bill_id,
            'service_id' => $order->service_id,
            'employee_id' => $order->employee_id,
            'money' => $order->service->price,
        ]);

        return $this->orderModel->updateOrCreate(
            ['id' => $orderId],
            [
                'status' => config('config.order.status.check-in'),
                'bill_id' => $bill_id,
            ]
        );
    }
}
