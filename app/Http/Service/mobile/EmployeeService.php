<?php

namespace App\Http\Service\mobile;

use App\Model\Bill;
use App\Model\BillDetail;
use App\Model\Order;
use App\Model\EmployeeCommision;
use App\Model\OrderDetail;
use App\Model\Employee;
use App\Model\Salary;

class EmployeeService
{
	protected $billModel, $billDetailModel, $orderModel, $employeeCommisionModel, $orderDetailModel, $employeeModel, $salaryModel;

	public function __construct(Bill $bill, BillDetail $billDetail, Order $order, EmployeeCommision $employeeCommision, OrderDetail $orderDetail, Employee $employeeModel, Salary $salaryModel)
	{
		$this->billModel = $bill;
		$this->billDetailModel = $billDetail;
		$this->orderModel = $order;
		$this->employeeCommisionModel = $employeeCommision;
		$this->orderDetailModel = $orderDetail;
		$this->employeeModel = $employeeModel;
		$this->salaryModel = $salaryModel;
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
							->where('date', $today)
							->where('employee_id', $employeeId)
							->get();
		$salaryYesterday = $this->employeeCommisionModel
								->where('date', $yesterday)
								->where('employee_id', $employeeId)
								->get();
		$salaryLastMonth = $this->employeeCommisionModel
								->where('date', 'like', $lastMonth . '%')
								->where('employee_id', $employeeId)
								->get();
		$salaryMonth = $this->employeeCommisionModel
							->where('date', 'like', $month . '%')
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
		$date_start = trim(str_replace('/', '-', $request->get('dateStart')));
		$date_end = trim(str_replace('/', '-', $request->get('dateEnd')));
		$dateFromFormat = date('Y-m-d', strtotime($date_start));
		$dateToFormat = date('Y-m-d', strtotime($date_end));
		$employeeId = auth('employees')->user()->id;
		$salary = $this->employeeCommisionModel
						->whereBetween('date', [$dateFromFormat, $dateToFormat])
						->where('employee_id', $employeeId)
						->get();
		$data = [
			'salary' => $salary,
		];

		return $data;
	}

	public function history()
	{
		$employeeId = auth('employees')->user()->id;
		$date = date('Y-m-d');
		$history = $this->billDetailModel
						->where('created_at', 'like', $date . '%')
						->where(function($query) use ($employeeId){
							$query->where('employee_id', $employeeId)
								->orWhere('assistant_id', $employeeId);
						})
						->get()
						->groupBy('bill_id');
		$dem = 0;
		foreach ($history as $key => $bill) {
			$dataBill = $this->billModel->findOrFail($key);

			if ($dataBill->status == config('config.order.status.check-out')) {
				$dem++;
			}
		}

		$data = [
			'dem' => $dem,
			'history' => $history,
		];

		return $data;
	}

	public function historySearch($date)
	{
		$employeeId = auth('employees')->user()->id;
		$history = $this->billDetailModel
						->where('created_at', 'like', $date . '%')
						->where(function($query) use ($employeeId){
							$query->where('employee_id', $employeeId)
								->orWhere('assistant_id', $employeeId);
						})
						->get()
						->groupBy('bill_id');
		$dem = 0;
		foreach ($history as $key => $bill) {
			$dataBill = $this->billModel->findOrFail($key);

			if ($dataBill->status == config('config.order.status.check-out')) {
				$dem++;
			}
		}

		$data = [
			'dem' => $dem,
			'history' => $history,
		];

		return $data;
	}

	public function salaryList()
	{
		$date = date('Y-m');
		$employeeList = $this->employeeModel
                             ->with(['employeeCommision' => function($q) use ($date){
                                $q->where('created_at', 'like', $date . '%');
                             }])
                             ->get();
		foreach ($employeeList as $employee) {
                        $commisionTotal = 0;
            foreach ($employee->employeeCommision as $commision){
                if ($commision->billDetail->bill->status == config('config.order.status.check-out')) {
                    $commisionTotal = $commisionTotal + $commision->percent/100 * $commision->billDetail->money;
                }
            }
            $this->salaryModel->updateOrCreate(
            	[
            		'employee_id' => $employee->id,
            		'date' => $date,
            	],
            	[
            		'money' => $commisionTotal + $employee->salary,
            	]
            );
        }
        $salaryList = $this->salaryModel->where('date', $date)->orderBy('money', 'desc')->get();
        $data = [
        	'date' => $date,
        	'salaryList' => $salaryList
        ];

        return $data;
	}
}


