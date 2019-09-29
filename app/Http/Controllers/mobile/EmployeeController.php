<?php

namespace App\Http\Controllers\mobile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Service\mobile\EmployeeService;

class EmployeeController extends Controller
{
    protected $employeeService;

    public function __construct(EmployeeService $employee)
    {
        $this->employeeService = $employee;
    }

    public function homeView()
    {
        return view('client.mobile.employees.pages.home', $this->employeeService->homeView());
    }

    public function logout()
    {
        auth('employees')->logout();

        return redirect()->route('mobile.employee.login');
    }

    public function salary(Request $request)
    {
        return view('client.mobile.employees.pages.salary', $this->employeeService->salary($request));
    }

    public function search(Request $request)
    {
        return view('client.mobile.employees.pages.search_date', $this->employeeService->search($request));
    }

    public function history()
    {
        return view('client.mobile.employees.pages.history', $this->employeeService->history());
    }

    public function historySearch($date)
    {
        return view('client.mobile.employees.pages.search_history', $this->employeeService->historySearch($date));
    }
}
