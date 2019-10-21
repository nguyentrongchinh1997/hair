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
                                          ->where('type', 0)
                                          ->orderBy('id', 'desc')
                                          ->get();
        // $revenueList = $this->orderModel->where('date', 'like', $yearMonth . '%')
        //                                 ->where('status', config('config.order.status.check-out'))
        //                                 ->orderBy('id', 'desc')
        //                                 ->get();
        $revenueList = $this->billModel->where('date', 'like', $yearMonth . '%')
                                       ->where('status', config('config.order.status.check-out'))
                                       ->orderBy('id', 'desc')
                                       ->with('billDetail')
                                       ->get();
        $otherRevenueList = $this->expenseModel->where('date', 'like', $yearMonth . '%')
                                               ->where('type', 1)
                                               ->orderBy('id', 'desc')
                                               ->get();                          
        $data = [
            'date' => $date,
            'month' => $month,
            'year' => $year,
            'otherRevenueList' => $otherRevenueList,
            'revenueList' => $revenueList,
            'expenseList' => $expenseList,
        ];

        return $data;
    }

    public function expenseMonth($request)
    {
        if ($request->input('pick-month') == 'month') {
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
                                              ->where('type', 0)
                                              ->orderBy('id', 'desc')
                                              ->get();
            // $revenueList = $this->orderModel->where('date', 'like', $yearMonth . '%')
            //                                 ->where('status', config('config.order.status.check-out'))
            //                                 ->orderBy('id', 'desc')
            //                                 ->get();
            $revenueList = $this->billModel->where('date', 'like', $yearMonth . '%')
                                           ->where('status', config('config.order.status.check-out'))
                                           ->orderBy('id', 'desc')
                                           ->get();
            $otherRevenueList = $this->expenseModel->where('date', 'like', $yearMonth . '%')
                                                   ->where('type', 1)
                                                   ->orderBy('id', 'desc')
                                                   ->get();          
            $data = [
                'date' => $date,
                'month' => $month,
                'year' => $year,
                'otherRevenueList' => $otherRevenueList,
                'expenseList' => $expenseList,
                'revenueList' => $revenueList,
            ];
        } elseif ($request->input('pick-day') == 'day') {
            $month = date('m');
            $year = date('Y');
            // $dateFrom = $request->date_from;
            // $dateTo = $request->date_to;
            $date_start = str_replace('/', '-', $request->date_start);
            $dateStartFormat = date('Y-m-d', strtotime($date_start));
            $date_end = str_replace('/', '-', $request->date_end);
            $dateEndFormat = date('Y-m-d', strtotime($date_end));
            $expenseList = $this->expenseModel->whereBetween('date', [$dateStartFormat, $dateEndFormat])
                                              ->where('type', 0)
                                              ->orderBy('id', 'desc')
                                              ->get();
            $revenueList = $this->billModel->where('status', config('config.order.status.check-out'))
                                            ->whereBetween('date', [$dateStartFormat, $dateEndFormat])
                                            ->orderBy('id', 'desc')
                                            ->get();

            $otherRevenueList = $this->expenseModel->whereBetween('date', [$dateStartFormat, $dateEndFormat])
                                                   ->where('type', 1)
                                                   ->orderBy('id', 'desc')
                                                   ->get();
            $data = [
                'month' => $month,
                'year' => $year,
                'date_start' => $date_start,
                'date_end' => $date_end,
                'otherRevenueList' => $otherRevenueList,
                'expenseList' => $expenseList,
                'revenueList' => $revenueList,
            ];

        }

        return $data;
    }

    public function expenseAdd($inputs)
    {
        return $this->expenseModel->create(
            [
                'content' => $inputs['content'],
                'money' => str_replace(',', '', $inputs['money']),
                'date' => $inputs['date'],
            ]
        );
    }

    public function revenueAdd($inputs)
    {
        return $this->expenseModel->create(
            [
                'content' => $inputs['content'],
                'money' => str_replace(',', '', $inputs['money']),
                'date' => $inputs['date'],
                'type' => 1,
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
                                          ->where('type', 0)
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

    public function deleteExpense($id)
    {
        return $this->expenseModel->findOrFail($id)->delete();
    }

    public function editExpense($id)
    {
        $expense = $this->expenseModel->findOrFail($id);
        $data = ['expense' => $expense];

        return $data;
    }

    public function editPostExpense($id, $request)
    {
        $money = str_replace(',', '', $request->money);
        $this->expenseModel->updateOrCreate(
            ['id' => $id],
            [
                'content' => $request->content,
                'money' => $money,
                'date' => $request->date
            ]
        );
    }
}
