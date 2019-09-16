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
use App\Model\EmployeeCommision;
use App\Model\Card;
use App\Model\CardDetail;
use App\Model\OrderDetail;


class BillService
{
	protected $employeeModel, $serviceModel, $orderModel, $billModel, $customerModel, $billDetailModel, $rateModel, $timeModel, $employeeCommisionModel, $cardModel, $cardDetailModel, $orderDetailModel;

    public function __construct(Employee $employee, Service $service, Order $order, Bill $bill, Customer $customer, BillDetail $billDetail, Rate $rate, Time $time, EmployeeCommision $commision, Card $card, CardDetail $cardDetail, OrderDetail $orderDetail)
    {
        $this->employeeModel = $employee;
        $this->serviceModel = $service;
        $this->orderModel = $order;
        $this->billModel = $bill;
        $this->customerModel = $customer;
        $this->billDetailModel = $billDetail;
        $this->rateModel = $rate;
        $this->timeModel = $time;
        $this->employeeCommisionModel = $commision;
        $this->cardModel = $card;
        $this->cardDetailModel = $cardDetail;
        $this->orderDetailModel = $orderDetail;
    }

	public function finish($billId)
    {
        $bill = $this->billModel->findOrFail($billId);
        $customer = $this->customerModel->findOrFail($bill->customer_id);
        $sumService = $this->billDetailModel->where('bill_id', $billId)->sum('sale_money');
        $total = $sumService - $bill->sale;
        $balance = $customer->balance;

        if ($balance >= $total) {
            $balanceUpdate = $balance - $total;
        } else {
            $balanceUpdate = 0;
        }

        if ($bill->rate_id == '') {
            $rate_id = config('config.rate.star.rate3');
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

    public function billSearchResult($keySearch, $date)
    {
        $customer = $this->customerModel
                        ->where('phone', 'like', $keySearch . '%')
                        ->with('bill')
                        ->get();
        $data = [
            'customer' => $customer,
            'date' => $date,
        ];

        return $data;
    }

    public function billDetail($billId)
    {
        $rate = $this->billModel->findOrFail($billId);;
        $comment = $this->billModel->findOrFail($billId);
        $bill = $this->billModel->findOrFail($billId);
        $employeeList = $this->employeeModel->where('status', config('config.employee.status.doing'))->get();
        $serviceList = $this->serviceModel->where('id', '!=', $bill->order->service_id)->get();
        $moneyServiceTotal = $this->billDetailModel->where('bill_id', $billId)->sum('money');
        $serviceListUse = $this->billDetailModel->where('bill_id', $billId)->get();
        $customer = $this->customerModel->findOrFail($bill->customer_id);
        $card = $this->cardModel->where('customer_id', $bill->customer_id)
                                ->where('end_time', '>=', date('Y-m-d'))
                                ->first();

        if (isset($card)) {
            $cardName = $card->card_name;
        } else {
            $cardName = '';
        }
        $balance = $customer->balance;
        $total = $moneyServiceTotal - $bill->sale; // số tiền phải trả
        if ($balance >= $total) {
            $payPrice = $customer->balance - $total;
        } elseif ($balance > 0 && $balance < $total) {
            $payPrice = $total - $balance;
        } else {
            $payPrice = $total;
        }
        $data = [
            'cardName' => $cardName,
            'payPrice' => $payPrice,
            'rate' => $rate,
            'comment' => $comment,
            'employeeList' => $employeeList,
            'serviceList' => $serviceList,
            'bill' => $bill,
            'moneyServiceTotal' => $moneyServiceTotal,
            'serviceListUse' => $serviceListUse,
        ];

        return $data;
    }

    public function serviceAdd($billId, $serviceId, $employeeId, $assistantId)
    {
        $date = date('Y-m-d');
        $bill = $this->billModel->findOrFail($billId);
        $service = $this->serviceModel->findOrFail($serviceId);
        $card = $this->cardModel->where('customer_id', $bill->order->customer_id)->first();
        $detailCard = $this->cardDetailModel->where('service_id', $serviceId)
                                                ->where('customer_id', $bill->order->customer_id)
                                                ->first();
        if (isset($card) && (strtotime($date) <= strtotime($card->end_time)) && isset($detailCard)) {
            $cardName = $card->card_name;
            $saleMoney = $service->price - ($service->price * $detailCard->percent/100);
        } else {
            $saleMoney = $service->price;
            $cardName = '';
        }

        if ($assistantId == 0) {
            $assistantId = NULL;
        }

        if ($bill->order->request == config('config.request.yes')) {
            $percent = $service->main_request_percent;
        } else {
            $percent = $service->percent;
        }

        if ($bill->status != config('config.order.status.check-out')) {
            $id = $this->billDetailModel->insertGetId([
                'bill_id' => $billId,
                'service_id' => $serviceId,
                'employee_id' => $employeeId,
                'assistant_id' => $assistantId,
                'money' => $service->price,
                'sale_money' => $saleMoney,
                'date' => date('Y-m-d'),
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            $this->employeeCommisionModel->create(
                [
                    'employee_id' => $employeeId,
                    'bill_detail_id' => $id,
                    'percent' => $percent,
                ]
            );
            if ($assistantId != 0) {
                $this->employeeCommisionModel->create(
                    [
                        'employee_id' => $assistantId,
                        'bill_detail_id' => $id,
                        'percent' => $service->assistant_percent,
                    ]
                );
            }
            $billDetail = $this->billDetailModel->findOrFail($id);
            $data = [
                'billDetail' => $billDetail,
                'cardName' => $cardName,
            ];

            return $data;
        } else {
            return '';
        }
    }

    public function serviceDelete($billDetailId)
    {
        $bill = $this->billDetailModel->findOrFail($billDetailId);

        if ($bill->bill->status != config('config.order.status.check-out')) {
            $this->employeeCommisionModel->where('bill_detail_id', $billDetailId)->delete();
            $billDetail = $this->billDetailModel->findOrFail($billDetailId);
            $price = $billDetail->money;
            $billDetail->delete();

            return $price;
        } else {
            return '';
        }

    }

    public function serviceOtherAdd($billId, $serviceName, $employeeId, $assistantId, $money, $percent, $percentEmployee, $percentAssistant)
    {
        $bill = $this->billModel->findOrFail($billId);

        if ($assistantId == 0) {
            $assistantId = NULL;
        }

        if ($bill->status != config('config.order.status.check-out')) {
            $convertMoney = str_replace(',', '', $money);
            $id = $this->billDetailModel->insertGetId([
                'bill_id' => $billId,
                'other_service' => $serviceName,
                'employee_id' => $employeeId,
                'assistant_id' => $assistantId,
                'money' => $convertMoney,
                'other_service_percent' => $percent,
                'date' => date('Y-m-d'),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            $this->employeeCommisionModel->create(
                [
                    'employee_id' => $employeeId,
                    'bill_detail_id' => $id,
                    'percent' => $percentEmployee,
                ]
            );
            $this->employeeCommisionModel->create(
                [
                    'employee_id' => $assistantId,
                    'bill_detail_id' => $id,
                    'percent' => $percentAssistant,
                ]
            );

            return $this->billDetailModel->findOrFail($id);
        } else {
            return '';
        }
    }

    public function updateCashier($billId)
    {
        if (auth()->check()) {
            $idUser = auth()->user()->id;
        } else if (auth('employees')->check()) {
            $idUser = auth('employees')->user()->id;
        }

        return $this->billModel->updateOrCreate(
            ['id' => $billId],
            [
                'cashier' => $idUser,
            ]
        );
    }

    public function checkCard($customer_id, $service_id, $price)
    {
        $checkCard = $this->cardDetailModel->where('customer_id', $customer_id)
                                            ->where('service_id', $service_id)
                                            ->first();
        if (isset($checkCard) && (strtotime(date('Y-m-d')) <= strtotime($checkCard->card->end_time))) {
            $sale_money = $price - $price * $checkCard->percent/100;
        } else {
            $sale_money = $price;
        }

        return $sale_money;
    }

    public function addBill($request)
    {
        $phone = $request->phone;
        $service_id = $request->service_id;
        $employee = $request->employee_id;
        $date = date('Y-m-d');
        $time = $request->time_id;

        $checkPhone = $this->customerModel->where('phone', $phone)->first();
        $service = $this->serviceModel->findOrFail($service_id);
        
        if (!isset($checkPhone)) {
            $customer_id = $this->customerModel->insertGetId([
                'full_name' => $request->full_name,
                'phone' => $phone,
            ]);
        } else {
            $customer_id = $checkPhone->id;
        }
    /*thêm vào bảng order*/
        $orderId = $this->orderModel->insertGetId([
            'customer_id' => $customer_id,
            'date' => $date,
            'time_id' => $time,
            'status' => config('config.order.status.check-in'),
            'request' => $request->requirement,
        ]);
    /*end*/

        $saleMoney = $this->checkCard($customer_id, $service_id, $service->price);

    /*thêm vào bảng chi tiết order*/
        $this->orderDetailModel->create(
            [
                'service_id' => $request->service_id,
                'employee_id' => $request->employee_id,
                'order_id' => $orderId,
            ]
        );

        if ($request->assistant_id != 0) {
            $this->orderDetailModel->create(
                [
                    'service_id' => $request->service_id,
                    'employee_id' => $request->assistant_id,
                    'order_id' => $orderId,
                ]
            );
        }
    /*end*/

        $billId = $this->billModel->insertGetId([
            'customer_id' => $customer_id,
            'order_id' => $orderId,
            'price' => $service->price,
            'status' => config('config.order.status.check-in'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $this->orderModel->updateOrCreate(
            ['id' => $orderId],
            [
                'bill_id' => $billId,
            ]
        );

    /*thêm dịch vụ vào bảng chi tiết dịch vụ*/
        $billDetailId =  $this->billDetailModel->insertGetId([
            'bill_id' => $billId,
            'service_id' => $service_id,
            'employee_id' => $employee,
            'money' => $service->price,
            'sale_money' => $saleMoney,
            'date' => $date,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    /*end*/

    /*thêm hoa hồng cho nhân viên*/
        if ($request->requirement == config('config.request.yes')) {
            $percentEmployee = $service->main_request_percent;
            $percentAssistant = $service->assistant_percent;
        } else {
            $percentEmployee = $service->percent;
            $percentAssistant = $service->assistant_percent;
        }

        if ($request->assistant_id != 0) {
            $this->employeeCommisionModel->create(
                [
                    'employee_id' => $request->assistant_id,
                    'bill_detail_id' => $billDetailId,
                    'percent' => $percentAssistant,
                ]
            );
        }
    /*end*/

        return $this->employeeCommisionModel->create(
            [
                'employee_id' => $request->employee_id,
                'bill_detail_id' => $billDetailId,
                'percent' => $percentEmployee,
            ]
        );

    }

    public function rateUpdate($billId)
    {
        $bill = $this->billModel->findOrFail($billId);
        $data = [
            'bill' => $bill,
        ];

        return $data;
    }

    public function payView($billId, $request) {
        $sale = $request->get('sale');

        if ($request->get('saleDetail') == '0') {
            $saleDetail = '';
        } else {
            $saleDetail = $request->get('saleDetail');
        }

        $sum = $this->billDetailModel->where('bill_id', $billId)->sum('sale_money');
        $bill = $this->billModel->findOrFail($billId);
        $customer = $this->customerModel->findOrFail($bill->customer_id);
        $serviceListUse = $this->billDetailModel->where('bill_id', $billId)->get();
            $balance = $customer->balance;
        $total = $sum - $bill->sale; // số tiền phải trả

        $bill->sale = str_replace(',', '', $sale);
        $bill->sale_detail = $saleDetail;
        $bill->save();
        $card = $this->cardModel->where('customer_id', $bill->customer_id)
                                ->where('end_time', '>=', date('Y-m-d'))
                                ->first();

        if (isset($card)) {
            $cardName = $card->card_name;
        } else {
            $cardName = '';
        }

        if ($balance >= $total) {
            $payPrice = $customer->balance - $total;
        } elseif ($balance > 0 && $balance < $total) {
            $payPrice = $total - $balance;
        } else {
            $payPrice = $total;
        }
        $data = [
            'cardName' => $cardName,
            'serviceListUse' => $serviceListUse,
            'rate' => $bill,
            'comment' => $bill,
            'payPrice' => $payPrice,
            'billId' => $billId,
            'bill' => $bill,
        ];

        return $data;
    }
}