<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Service\admin\ExpenseService;

class ExpenseController extends Controller
{
    protected $expenseService;

    public function __construct(ExpenseService $expense)
    {
        $this->expenseService = $expense;
    }
    public function getViewExpense()
    {
        return view('admin.pages.expense.list', $this->expenseService->getViewExpense());
    }

    public function expenseAdd(Request $request)
    {
        $this->expenseService->expenseAdd($request->all());

        return redirect()->route('expense.list')->with('thongbao', 'Thêm chi tiêu thành công');
    }

    public function expenseMonth(Request $request)
    {
        return view('admin.pages.expense.list', $this->expenseService->expenseMonth($request));
    }

    public function expenseDay(Request $request)
    {
        return view('admin.pages.expense.list', $this->expenseService->expenseDay($request));
    }
}
