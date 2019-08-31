<?php

namespace App\Http\Service\admin;

use App\Model\Employee;
use App\Model\Service;
use App\Model\Order;
use App\Model\Bill;
use App\Model\Customer;
use App\Model\BillDetail;
use App\Model\Rate;

class AdminService
{
    protected $employeeModel, $serviceModel, $orderModel, $billModel, $customerModel, $billDetailModel, $rateModel;

    public function __construct(Employee $employee, Service $service, Order $order, Bill $bill, Customer $customer, BillDetail $billDetail, Rate $rate)
    {
        $this->employeeModel = $employee;
        $this->serviceModel = $service;
        $this->orderModel = $order;
        $this->billModel = $bill;
        $this->customerModel = $customer;
        $this->billDetailModel = $billDetail;
        $this->rateModel = $rate;
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
            'percent' => $inputs['percent'],
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
        $orderList = $this->orderModel->where('status', config('config.order.status.create'))->where('date', date('Y-m-d'))->orderBy('created_at', 'desc')->get();
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
        $service->percent = $inputs['percent'];
        
        return $service->save();
    }

    public function checkIn($orderId, $request)
    {
        $order = $this->orderModel->findOrFail($orderId);
        $customer = $this->customerModel->findOrFail($order->customer_id);

        if ($customer->full_name == '' && $customer->birthday == '') {
            $this->customerModel->updateOrCreate(
                ['id' => $order->customer_id],
                [
                    'full_name' => $request->full_name,
                    'birthday' => $request->birthday,
                ]
            );
        }

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

    public function getRate($billId)
    {
        return $this->billModel->findOrFail($billId);
    }

    public function getComment($billId)
    {
        return $this->billModel->findOrFail($billId);
    }

    public function priceTotal($billId)
    {
        $sum = $this->billDetailModel->where('bill_id', $billId)->sum('money');
        $bill = $this->billModel->findOrFail($billId);
        $customer = $this->customerModel->findOrFail($bill->customer_id);
        $balance = $customer->balance;
        $total = $sum - $bill->sale; // số tiền phải trả
        if ($balance >= $total) {
            $payPrice = $customer->balance - $total;
        } elseif ($balance > 0 && $balance < $total) {
            $payPrice = $total - $balance;
        } else {
            $payPrice = $total;
        }

        return number_format($payPrice) . ' Đ';
    }

    public function getRateList()
    {
        $rateList = $this->rateModel->all();
        $data = [
            'rateList' => $rateList,
        ];

        return $data;
    }

    public function postRate($request, $rateId)
    {
        return $this->rateModel->updateOrCreate(
            ['id' => $rateId],
            [
                'percent' => $request->percent,
            ]
        );
    }

    public function pay($billId, $servicePrice)
    {
        $bill = $this->billModel->findOrFail($billId);
        $customer = $this->customerModel->findOrFail($bill->customer_id);
        $total = $servicePrice - $bill->sale;
        $balance = $customer->balance - $total;
        $billDetail = $this->billDetailModel->where('bill_id', $billId)->get();

        
        if ($balance < 0 ) {
            $balanceUpdate = 0;
        } elseif ($balance > 0 && $balance >= $total) {
            $balanceUpdate = $balance - $total;
        } elseif ($balance > 0 && $balance <= $total) {
            $balanceUpdate = 0;
        }
        
        $employee = $this->billDetailModel->where('bill_id', $billId)->distinct()->get(['employee_id', 'bill_id']);
        foreach ($employee as $employee) {
            $employeeList = $this->billDetailModel->where('bill_id', $billId)->where('employee_id', $employee->employee_id)->get();
            foreach ($employeeList as $e) {
                if ($e->service_id != '') {
                    $balance = $this->employeeModel->findOrFail($e->employee_id);
                    $percentService = $e->service->percent; // chiết khấu % dịch vụ
                    $percentEmployee = $e->employee->percent; // chiết khấu % nhân viên
                    if ($bill->rate->type == 1) {
                        $percentTotal = $percentService + $percentEmployee + $employee->bill->rate->percent; // tổng phần trăm 
                    } else {
                        $percentTotal = $percentService + $percentEmployee - $employee->bill->rate->percent; // tổng phần trăm 
                    }
                    $priceTotal = $e->service->price * $percentTotal/100; // tổng tiền nhân viên nhận được mỗi dịch vụ
                    $balance->balance = $priceTotal + $balance->balance;
                    $balance->save();
                } else {
                    $balance = $this->employeeModel->findOrFail($e->employee_id);
                    $percentService = $e->other_service_percent; // chiết khấu % dịch vụ
                    $percentEmployee = $e->employee->percent; // chiết khấu % nhân viên
                    if ($bill->rate->type == 1) {
                        $percentTotal = $percentService + $percentEmployee + $employee->bill->rate->percent; // tổng phần trăm 
                    } else {
                        $percentTotal = $percentService + $percentEmployee - $employee->bill->rate->percent; // tổng phần trăm 
                    }
                    $priceTotal = $e->money * $percentTotal/100; // tổng tiền nhân viên nhận được mỗi dịch vụ
                    $balance->balance = $priceTotal + $balance->balance;
                    $balance->save();
                }

            }
        }

        $this->billModel->updateOrCreate(
            ['id' => $billId],
            [
                'status' => 2,
                'total' => $total,
            ]
        );

        $this->orderModel->updateOrCreate(
            ['id' => $bill->order_id],
            [
                'status' => 2,
            ]
        );
        $this->customerModel->updateOrCreate(
            ['id' => $bill->customer_id],
            ['balance' => $balanceUpdate]
        );

        return $this->billModel->where('id', '>', 0)->update(['rate_status' => 0]);
    }
}
