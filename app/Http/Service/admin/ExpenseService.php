<?php

namespace App\Http\Service\admin;

use App\Model\Expense;
use App\Model\Bill;
use App\Model\Order;

class ExpenseService
{
	protected $expenseModel, $billModel, $orderModel;

	public function __construct(Expense $expense, Bill $bill, Order $order)
	{
		$this->expenseModel = $expense;
		$this->billModel = $bill;
		$this->orderModel = $order;
	}

	public function getViewExpense()
	{
		$month = date('m');
		$year = date('Y');
		$yearMonth = $year . '-' . $month;
		$date = date('Y/m/d');
		$expenseList = $this->expenseModel->where('date', 'like', $yearMonth . '%')
											->orderBy('created_at', 'desc')
											->get();
		$revenueList = $this->orderModel->where('date', 'like', $yearMonth . '%')
										->where('status', config('config.order.status.check-out'))
										->get();
		$data = [
			'date' => $date,
			'month' => $month,
			'year' => $year,
			'revenueList' => $revenueList,
			'expenseList' => $expenseList,
		];

		return $data;
	}

	public function expenseMonth($request)
	{
		$month = $request->month;
		$year = $request->year;
		$date = $year . '/' . $month . '/' . date('d');

		if ($request->month < 10) {
			$month = 0 . $request->month;
		} else {
			$month = $request->month;
		}
		$yearMonth = $year . '-' . $month;
		$expenseList = $this->expenseModel->where('date', 'like', $yearMonth . '%')
											->orderBy('created_at', 'desc')
											->get();
		$revenueList = $this->orderModel->where('date', 'like', $yearMonth . '%')
										->where('status', config('config.order.status.check-out'))
										->get();
		$data = [
			'date' => $date,
			'month' => $month,
			'year' => $year,
			'expenseList' => $expenseList,
			'revenueList' => $revenueList,
		];

		return $data;
	}

	public function expenseAdd($inputs)
	{
		return $this->expenseModel->create(
			[
				'content' => $inputs['content'],
				'money' => str_replace(',', '', $inputs['money']),
				'date' => date('Y-m-d'),
			]
		);
	}

	public function expenseDay($request)
	{
		$month = date('m');
		$year = date('Y');
		$dateFrom = $request->date_from;
		$dateTo = $request->date_to;
		$expenseList = $this->expenseModel->whereBetween('date', [$dateFrom, $dateTo])
										->get();
		$revenueList = $this->orderModel->where('status', config('config.order.status.check-out'))
										->whereBetween('date', [$dateFrom, $dateTo])
										->get();
		$data = [
			'dateFrom' => $dateFrom,
			'dateTo' => $dateTo,
			'month' => $month,
			'year' => $year,
			'expenseList' => $expenseList,
			'revenueList' => $revenueList,
		];

		return $data;
	}
}