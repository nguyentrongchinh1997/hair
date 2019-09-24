<?php

namespace App\Http\Service\mobile;

use App\Model\Bill;
use App\Model\BillDetail;
use App\Model\Order;
use App\Model\EmployeeCommision;

class EmployeeService
{
	protected $billModel, $billDetailModel, $orderModel, $employeeCommisionModel;

	public function __construct(Bill $bill, BillDetail $billDetail, Order $order, EmployeeCommision $employeeCommision)
	{
		$this->billModel = $bill;
		$this->billDetailModel = $billDetail;
		$this->orderModel = $order;
		$this->employeeCommisionModel = $employeeCommision;
	}
	public function homeView()
	{
		$date = date('Y-m-d');
		$employeeId = auth('employees')->user()->id;
		$billListCheckIn = $this->billDetailModel->where('created_at', 'like', $date . '%')
												->where('employee_id', $employeeId)
												->orWhere('assistant_id', $employeeId)
												->get()
												->groupBy('bill_id');
		$billListCreate = $this->orderModel->where('date', $date)
									->where('status', config('config.order.status.create'))
									->with(['orderDetail' => function($query) use ($employeeId){
										$query->where('employee_id', $employeeId)
												->orWhere('assistant_id', $employeeId);
									}])
									->orderBy('created_at', 'DESC')
									->get();
		$data = [
			'billListCreate' => $billListCreate,
			'billListCheckIn' => $billListCheckIn,
			'employeeId' =>  $employeeId,
		];

		return $data;
	}

	public function salary($request)
	{
		$today = $request->get('today');
		$month = date('Y-m');
		$lastMonth = date('Y-m', strtotime('-1 month'));
		$yesterday = date('Y-m-d', strtotime('-1 day'));
		$employeeId = auth('employees')->user()->id;

		$salaryToday = $this->employeeCommisionModel
							->where('created_at', 'like', $today . '%')
							->where('employee_id', $employeeId)
							->get();
		$salaryYesterday = $this->employeeCommisionModel
								->where('created_at', 'like', $yesterday . '%')
								->where('employee_id', $employeeId)
								->get();
		$salaryLastMonth = $this->employeeCommisionModel
								->where('created_at', 'like', $lastMonth . '%')
								->where('employee_id', $employeeId)
								->get();
		$salaryMonth = $this->employeeCommisionModel
							->where('created_at', 'like', $month . '%')
							->where('employee_id', $employeeId)
							->get();
		$data = [
			'salaryYesterday' => $salaryYesterday,
			'salaryToday' => $salaryToday,
			'salaryLastMonth' => $salaryLastMonth,
			'salaryMonth' => $salaryMonth,
		];

		return $data;
	}

	public function search($request)
	{
		$dateFrom = $request->get('from');
		$dateTo = $request->get('to');
		$employeeId = auth('employees')->user()->id;
		$salary = $this->employeeCommisionModel
						->whereBetween('date', [$dateFrom, $dateTo])
						->where('employee_id', $employeeId)
						->get();
		$data = [
			'salary' => $salary,
		];

		return $data;
	}
}
