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
use App\Model\Membership;
use App\Model\Salary;

class BillService
{
	protected $employeeModel, $serviceModel, $orderModel, $billModel, $customerModel, $billDetailModel, $rateModel, $timeModel, $employeeCommisionModel, $cardModel, $cardDetailModel, $orderDetailModel, $membershipModel, $salaryModel;

    public function __construct(Employee $employee, Service $service, Order $order, Bill $bill, Customer $customer, BillDetail $billDetail, Rate $rate, Time $time, EmployeeCommision $commision, Card $card, CardDetail $cardDetail, OrderDetail $orderDetail, Membership $membership, Salary $salary)
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
        $this->membershipModel = $membership;
        $this->salaryModel = $salary;
    }

	public function finish($billId, $request)
    {
        $bill = $this->billModel->findOrFail($billId);
        $customer = $this->customerModel->findOrFail($bill->customer_id);
        $sumService = $this->billDetailModel->where('bill_id', $billId)->sum('sale_money');
        $total = $sumService - $bill->sale;
        $balance = $customer->balance;

        foreach ($bill->billDetail as $billDetail) {
            $checkUseCard = $this->membershipModel->where('customer_id', $bill->customer->id)
                                                  ->where('card_id', $billDetail->card_id)
                                                  ->where('number', '!=', '')
                                                  ->where('status', 1)
                                                  ->first();
            if (isset($checkUseCard)) {
                if (($checkUseCard->number - 1) == 0) {
                    $status = 0;
                } else {
                    $status = 1;
                }
                $this->membershipModel->updateOrCreate(
                    ['id' => $checkUseCard->id],
                    [
                        'number' => ($checkUseCard->number - 1),
                        'status' => $status,
                    ]
                );
            }
        }

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
        if ($request->money_transfer == NULL) {
            $moneyTransfer = NULL;
        } else {
            $moneyTransfer = str_replace(',', '', $request->money_transfer);
        }
        $this->billModel->updateOrCreate(
            ['id' => $billId],
            [
                'rate_id' => $rate_id,
                'comment' => $comment,
                'status' => 2,
                'total' => $total,
                'rate_status' => 0,
                'money_transfer' => $moneyTransfer,
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
                     ->where('date', $date)
                     ->orderBy('id', 'desc')
                     ->get();
        $serviceList = $this->serviceModel->where('status', '>', 0)->get();
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
                     ->where('date', $date)
                     ->orderBy('id', 'desc')
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
        if ($keySearch != '') {
            $customer = $this->customerModel
                             ->where('phone', 'like', $keySearch . '%')
                             ->orWhere('full_name', 'like', '%' . $keySearch . '%')
                             ->with(['bill' => function($query) use ($date){
                                    $query->where('date', $date);
                                }
                             ])
                             ->has('bill')
                             ->orderBy('id', 'desc')
                             ->get();
        } else {
            $customer = $this->customerModel
                             ->with(['bill' => function($query) use ($date){
                                    $query->where('date', $date);
                                }
                             ])
                             ->has('bill')
                             ->orderBy('id', 'desc')
                             ->get();
        }
        
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
        $serviceList = $this->serviceModel->where('status', '>', 0)->get();
        $moneyServiceTotal = $this->billDetailModel->where('bill_id', $billId)->sum('money');
        $serviceListUse = $this->billDetailModel->where('bill_id', $billId)->get();
        $customer = $this->customerModel->findOrFail($bill->customer_id);
        $card = $this->membershipModel->where('customer_id', $bill->customer_id)
                                ->where('end_time', '>=', date('Y-m-d'))
                                ->first();

        if (isset($card)) {
            $cardName = $card->card->card_name;
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
                'sale_money' => $service->price,
                'date' => date('Y-m-d'),
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            $this->employeeCommisionModel->create(
                [
                    'employee_id' => $employeeId,
                    'bill_detail_id' => $id,
                    'percent' => $percent,
                    'date' => $bill->date,
                ]
            );
            if ($assistantId != 0) {
                $this->employeeCommisionModel->create(
                    [
                        'employee_id' => $assistantId,
                        'bill_detail_id' => $id,
                        'percent' => $service->assistant_percent,
                        'date' => date('Y-m-d'),
                    ]
                );
            }
            $billDetail = $this->billDetailModel->findOrFail($id);
            $data = [
                'billDetail' => $billDetail,
                // 'cardName' => $cardName,
            ];

            return $data;
        } else {
            return '';
        }
    }

    public function checkCard($customer_id, $serviceId, $price)
    {
        $date = date('Y-m-d');
        $checkMembership = $this->membershipModel->where('customer_id', $customer_id)
                                                ->first();
        if (isset($checkMembership)) {
            $detailCard = $this->cardDetailModel->where('card_id', $checkMembership->card_id)
                                              ->where('service_id', $serviceId)
                                              ->first();
            if ($checkMembership->status > 0 && isset($detailCard)) {

                $saleMoney = $price - ($price * $detailCard->percent/100);
            } else {

                $saleMoney = $price;
            }
        } else {
            $saleMoney = $price;
        }
        return $saleMoney;
    }


    public function serviceDelete($billDetailId)
    {
        $bill = $this->billDetailModel->findOrFail($billDetailId);

        if ($bill->bill->status != config('config.order.status.check-out')) {
            $this->employeeCommisionModel->where('bill_detail_id', $billDetailId)->delete();
            $employeeCommision = $this->employeeCommisionModel->where('bill_detail_id', $billDetailId)->delete();
            $billDetail = $this->billDetailModel->findOrFail($billDetailId);
            $price = $billDetail->money;
            $billDetail->delete();

            return $price;
        } else {
            return '';
        }

    }

    public function serviceOtherAdd($billId, $serviceName, $employeeId, $assistantId, $money, $percentEmployee, $percentAssistant)
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
                'sale_money' => $convertMoney,
                'date' => date('Y-m-d'),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            $this->employeeCommisionModel->create(
                [
                    'employee_id' => $employeeId,
                    'bill_detail_id' => $id,
                    'percent' => $percentEmployee,
                    'date' => $bill->date,
                ]
            );
            if ($assistantId != 0) {
                $this->employeeCommisionModel->create(
                    [
                        'employee_id' => $assistantId,
                        'bill_detail_id' => $id,
                        'percent' => $percentAssistant,
                        'date' => date('Y-m-d'),
                    ]
                );
            }


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

    public function addBill($request)
    {
        $phone = $request->phone;
        $service_id = $request->service_id;
        $employee = $request->employee_id;
        $date = $request->date;
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
        if ($request->assistant_id != 0) {
            $assistantId = $request->assistant_id;
        } else {
            $assistantId = NULL;
        }
        $this->orderDetailModel->create(
            [
                'service_id' => $request->service_id,
                'employee_id' => $request->employee_id,
                'assistant_id' => $assistantId,
                'order_id' => $orderId,
            ]
        );
        
    /*end*/

        $billId = $this->billModel->insertGetId([
            'customer_id' => $customer_id,
            'order_id' => $orderId,
            'price' => $service->price,
            'date' => $date,
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
            'assistant_id' => $assistantId,
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
                    'date' => date('Y-m-d'),
                ]
            );
        }
    /*end*/

        return $this->employeeCommisionModel->create(
            [
                'employee_id' => $request->employee_id,
                'bill_detail_id' => $billDetailId,
                'percent' => $percentEmployee,
                'date' => date('Y-m-d'),
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
        $bill->rate_status = 1;
        $bill->save();
        $this->billModel->where('id', '!=', $billId)->update(['rate_status' => 0]);
        $card = $this->membershipModel->where('customer_id', $bill->customer_id)
                                ->where('end_time', '>=', date('Y-m-d'))
                                ->first();

        if (isset($card)) {
            $cardName = $card->card->card_name;
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

    public function printBill($billId)
    {
        $bill = $this->billModel->findOrFail($billId);
        $card = $this->membershipModel->where('customer_id', $bill->customer_id)
                                ->where('end_time', '>=', date('Y-m-d'))
                                ->first();

        if (isset($card)) {
            $cardName = $card->card->card_name;
        } else {
            $cardName = '';
        }
        $data = [
            'bill' => $bill,
            'cardName' => $cardName
        ];

        return $data;
    }

    public function checkEmptyServiceInCard($serviceId, $cardId)
    {
        $card = $this->cardModel->where('id', $cardId)->whereHas('cardDetail', function($query) use ($serviceId){
            $query->where('service_id', $serviceId);
        })->get();

        return $card->count();
    }

    public function cardCheck($idBillDetail, $cardId)
    {
        $card = $this->cardModel->findOrFail($cardId);
        $billDetail = $this->billDetailModel->findOrFail($idBillDetail);
        $customer_id = $billDetail->bill->customer->id;
        $service_id = $billDetail->service_id;
    /*Nếu là thẻ hội viên theo thời gian ngược lại nếu là thẻ tính theo số lần*/
        if ($card->type == 0) {
            $cardDetail = $this->cardDetailModel->where('card_id', $cardId)->where('service_id', $service_id)->first();
            $saleMoney = $billDetail->money - ($billDetail->money * $cardDetail->percent/100);
        } elseif ($card->type == 1) {
            foreach ($card->cardDetail as $service) {
                $serviceId = $service->service_id; // id dịch vụ ứng với thẻ đó
            }

            if ($service_id == $serviceId) {
                $saleMoney = 0;
            } else {
                $saleMoney = $billDetail->money;
            }
        }

        $checkEmptyServiceInCard = $this->checkEmptyServiceInCard($service_id, $cardId);

        if ($checkEmptyServiceInCard > 0) {
            $this->billDetailModel->updateOrCreate(
                ['id' => $idBillDetail],
                [
                    'card_id' => $cardId,
                    'sale_money' => $saleMoney
                ]
            );
        }

        return number_format($saleMoney) . '<sup>đ</sup>';;
    /*end*/
    }

    public function priceRestore($idBillDetail)
    {
        $billDetail = $this->billDetailModel->findOrFail($idBillDetail);
        $this->billDetailModel->updateOrCreate(
            ['id' => $idBillDetail],
            [
                'card_id' => NULL,
                'sale_money' => $billDetail->money,
            ]
        );

        return number_format($billDetail->money) . '<sup>đ</sup>';
    }
}
