<?php

namespace App\Http\Service\admin;

use App\Model\Employee;
use App\Model\Service;
use App\Model\Order;
use App\Model\Bill;
use App\Model\Customer;
use App\Model\BillDetail;
use App\Model\Rate;
use App\Model\Time;
use App\Model\OrderDetail;
use Carbon\Carbon;

class AdminService
{
    protected $employeeModel, $serviceModel, $orderModel, $billModel, $customerModel, $billDetailModel, $rateModel, $timeModel, $orderDetailModel;

    public function __construct(Employee $employee, Service $service, Order $order, Bill $bill, Customer $customer, BillDetail $billDetail, Rate $rate, Time $time, OrderDetail $orderDetail)
    {
        $this->employeeModel = $employee;
        $this->serviceModel = $service;
        $this->orderModel = $order;
        $this->billModel = $bill;
        $this->customerModel = $customer;
        $this->billDetailModel = $billDetail;
        $this->rateModel = $rate;
        $this->timeModel = $time;
        $this->orderDetailModel = $orderDetail;
    }

    public function employeeAdd($request)
    {
        return $this->employeeModel->create([
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'service_id' => $request->type,
            'address' => $request->address,
            'percent' => $request->percent,
            'password' => bcrypt($request->password),
            'salary' => str_replace(',', '', $request->salary),
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
        $employeeList = $this->employeeModel->orderBy('created_at', 'desc')->paginate(10);
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

    public function billList()
    {
        $day = date('d');
        $month = date('m');
        $year = date('Y');
        $date = date('Y-m-d');
        $bill = $this->billModel
                    ->where('status', '>', config('config.order.status.create'))
                    ->orderBy('created_at', 'DESC')
                    ->with('billDetail')
                    ->with('order')
                    ->get();
        $serviceList = $this->serviceModel->all();
        $timeList = $this->timeModel->all();
        $employeeList = $this->employeeModel->all();
        $data = [
            'employeeList' => $employeeList,
            'timeList' => $timeList,
            'serviceList' => $serviceList,
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
                    ->get();
        $serviceList = $this->serviceModel->all();
        $timeList = $this->timeModel->all();
        $employeeList = $this->employeeModel->all();
        $data = [
            'employeeList' => $employeeList,
            'timeList' => $timeList,
            'serviceList' => $serviceList,
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
        $orderPhone = $this->employeeModel->findOrFail($id);
        $check = $this->employeeModel->where('phone', $request->phone)->count();

        if ($check == 0 || $orderPhone->phone == $request->phone) {
            $this->employeeModel->updateOrCreate(
                ['id' => $id],
                [
                    'full_name' => $request->full_name,
                    'phone' => $request->phone,
                    'service_id' => $request->service_id,
                    'address' => $request->address,
                    'percent' => $request->percent,
                    'salary' => str_replace(',', '', $request->salary),
                    'status' => $request->status,
                ]
            );
            return 1;
        } else {
            return 0;
        }

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
        $orderDetail = $this->orderDetailModel->where('order_id', $orderId)->get();
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

        // $this->orderModel->updateOrCreate(
        //     ['id' => $orderId],
        //     [
        //         'employee_id' => $request->employee_id,
        //         'service_id' => $request->service_id,
        //     ]
        // );

        $bill_id = $this->billModel->insertGetId([
            'customer_id' => $order->customer_id,
            'order_id' => $orderId,
            'created_at' => date('Y-m-d H:i:s'),
            'status' => config('config.order.status.check-in'),
        ]);
        foreach ($orderDetail as $service) {
            $this->billDetailModel->create([
                'bill_id' => $bill_id,
                'service_id' => $service->service_id,
                'employee_id' => $service->employee_id,
                'money' => $service->service->price,
                'date' => date('Y-m-d'),
            ]);
        }

        return $this->orderModel->updateOrCreate(
            ['id' => $orderId],
            [
                'status' => config('config.order.status.check-in'),
                'bill_id' => $bill_id,
            ]
        );
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
    public function getRate($billId)
    {
        return $this->billModel->findOrFail($billId);
    }

    public function getComment($billId)
    {
        return $this->billModel->findOrFail($billId);
    }

    public function bill($billId)
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

        // return number_format($payPrice) . ' Đ';
        return $payPrice;
    }

    public function payView($billId, $request) {
        $sale = $request->get('sale');
        if ($request->get('saleDetail') == '0') {
            $saleDetail = '';
        } else {
            $saleDetail = $request->get('saleDetail');
        }
        // $bill = $this->billModel->findOrFail($billId);;
        // $comment = $this->billModel->findOrFail($billId);
        $sum = $this->billDetailModel->where('bill_id', $billId)->sum('money');
        $bill = $this->billModel->findOrFail($billId);
        $customer = $this->customerModel->findOrFail($bill->customer_id);
        $serviceListUse = $this->billDetailModel->where('bill_id', $billId)->get();
            $balance = $customer->balance;
        $total = $sum - $bill->sale; // số tiền phải trả

        $bill->sale = str_replace(',', '', $sale);
        $bill->sale_detail = $saleDetail;
        $bill->save();

        if ($balance >= $total) {
            $payPrice = $customer->balance - $total;
        } elseif ($balance > 0 && $balance < $total) {
            $payPrice = $total - $balance;
        } else {
            $payPrice = $total;
        }
        $data = [
            'serviceListUse' => $serviceListUse,
            'rate' => $bill,
            'comment' => $bill,
            'payPrice' => $payPrice,
            'billId' => $billId,
            'bill' => $bill,
        ];

        return $data;
    }

    public function finish($billId)
    {
        $bill = $this->billModel->findOrFail($billId);
        $customer = $this->customerModel->findOrFail($bill->customer_id);
        $sumService = $this->billDetailModel->where('bill_id', $billId)->sum('money');
        $total = $sumService - $bill->sale;
        $balance = $customer->balance;

        if ($balance >= $total) {
            $balanceUpdate = $balance - $total;
        } else {
            $balanceUpdate = 0;
        }

        if ($bill->rate_id == '') {
            $rate_id = 5;
        } else {
            $rate_id = $bill->rate_id;
        }
        if ($bill->comment == '') {
            $comment = 'Tất cả đều tốt, không có góp ý gì;';
        } else {
            $comment = $bill->comment;
        }
        $this->billModel->updateOrCreate(
            ['id' => $billId],
            [
                'rate_id' => $rate_id,
                'comment' => $comment,
                'status' => 2,
                'total' => $sumService,
                'rate_status' => 0,
            ]
        );

        $this->orderModel->updateOrCreate(
            ['id' => $bill->order_id],
            [
                'status' => 2,
            ]
        );
        return $this->customerModel->updateOrCreate(
            ['id' => $bill->customer_id],
            ['balance' => $balanceUpdate]
        );
    }

    public function addBill($request)
    {
        $phone = $request->phone;
        $service_id = $request->service_id;
        $employee = $request->employee_id;
        $date = $request->date;
        $time = $request->time_id;
        $status = 1;

        $checkPhone = $this->customerModel->where('phone', $phone)->first();
        $service = $this->serviceModel->findOrFail($service_id);
        // if (isset($checkPhone)) {
        //     $this->customerModel->updateOrCreate(
        //         ['id' => $checkPhone->id],
        //         [
        //             'full_name' => $request->full_name,
        //         ]
        //     );
            

        // } else {
        //     $this->customerModel->create(
        //         [
        //             'full_name' => $request->full_name,
        //             'phone' => $phone,
        //         ]
        //     );
        // }

        if (!isset($checkPhone)) {
            $customer_id = $this->customerModel->insertGetId([
                'full_name' => $request->full_name,
                'phone' => $phone,
            ]);
        } else {
            $customer_id = $checkPhone->id;
        }

        $orderId = $this->orderModel->insertGetId([
            'customer_id' => $customer_id,
            'employee_id' => $employee,
            'date' => $date,
            'service_id' => $service_id,
            'time_id' => $time,
            'status' => $status,
        ]);

        $billId = $this->billModel->insertGetId([
            'customer_id' => $customer_id,
            'order_id' => $orderId,
            'price' => $service->price,
            'status' => $status,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $this->orderModel->updateOrCreate(
            ['id' => $orderId],
            [
                'bill_id' => $billId,
            ]
        );

        return $this->billDetailModel->create([
            'bill_id' => $billId,
            'service_id' => $service_id,
            'employee_id' => $employee,
            'money' => $service->price,
            'date' => $date,
        ]);
    }

    public function salary($employeeId)
    {
        $today = date('Y-m');
        $employee = $this->employeeModel->findOrFail($employeeId);
        $billDetail = $this->billDetailModel
                            ->where('date', 'like', $today . '%')
                            ->where('employee_id', $employeeId)->orderBy('date', 'DESC')
                            ->get();
        $month = date('m');
        $year =date('Y');
        $data = [
            'billDetail' => $billDetail,
            'month' => $month,
            'year' => $year,
            'employee' => $employee,
        ];

        return $data;
    }

    public function postSalary($employeeId, $request)
    {
        $today = $request->year . '-' . $request->month;
        $employee = $this->employeeModel->findOrFail($employeeId);
        $billDetail = $this->billDetailModel->where('date', 'like', $today . '%')->where('employee_id', $employeeId)->get();
        $month = $request->month;
        $year = $request->year;
        $data = [
            'billDetail' => $billDetail,
            'month' => $month,
            'year' => $year,
            'employee' => $employee,
        ];

        return $data;
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
        $customer = $this->customerModel->findOrFail($request->customer_id);
        $money = $customer->balance + str_replace(',', '', $request->money);

        return $this->customerModel->updateOrCreate(
            ['id' => $request->customer_id],
            [
                'balance' => $money,
            ]
        );
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
}
