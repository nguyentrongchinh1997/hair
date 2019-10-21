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

    public function revenueAdd (Request $request)
    {
        $this->expenseService->revenueAdd($request->all());

        return back()->with('thongbao', 'Thêm thu nhập thành công');
    }

    public function expenseMonth(Request $request)
    {
        return view('admin.pages.expense.list', $this->expenseService->expenseMonth($request));
    }

    public function expenseDay(Request $request)
    {
        return view('admin.pages.expense.list', $this->expenseService->expenseDay($request));
    }

    public function deleteExpense($id)
    {
        $this->expenseService->deleteExpense($id);

        return back()->with('thongbao', 'Xóa chi tiêu thành công');
    }

    public function editExpense($id)
    {
        return view('admin.pages.expense.edit', $this->expenseService->editExpense($id));
    }

    public function editPostExpense(Request $request, $id)
    {
        $this->expenseService->editPostExpense($id, $request);

        return back()->with('thongbao', 'Sửa thành công');
    }
}
