<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Service\admin\EmployeeService;

class EmployeeController extends Controller
{
	protected $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function employeeAddView()
    {
    	return view('admin.pages.employee.add');
    }

    public function employeeListView()
    {
        return view('admin.pages.employee.list', $this->employeeService->employeeListView());
    }

    public function commisionTime(Request $request)
    {
        return view('admin.pages.employee.list', $this->employeeService->commisionTime($request));
    }

    public function employeeEditView($id)
    {
        return view('admin.pages.employee.edit', $this->employeeService->oldDataEmployee($id));
    }

    public function employeeEdit(Request $request, $id)
    {
        $check = $this->employeeService->employeeEdit($request, $id);
        
        if ($check == 0) {
            return back()->with('error', 'Số điện thoại đã bị trùng');
        } else {
            return back()->with('thongbao', 'Sửa thành công');
        }
    }

    public function salary($employeeId)
    {
        return view('admin.pages.employee.salary_list', $this->employeeService->salary($employeeId));
    }

    public function postSalary(Request $request, $employeeId)
    {
        return view('admin.pages.employee.salary_list', $this->employeeService->postSalary($employeeId, $request));
    }

    public function employeeAdd(Request $request)
    {
        $this->validate($request, 
            [
                'phone' => 'regex:/^([0-9\s\-\+\(\)]*)$/|size:10|unique:employees,phone',
            ],
            [

                'phone.max' => 'Số điện thoại phải 10 số',
                'phone.regex' => 'Số điện thoại phải là số',
                'phone.unique' => 'Số điện thoại đã bị trùng',
            ]
        );
    	$this->employeeService->employeeAdd($request);

        return redirect()->back()->withInput()->with('thongbao', 'Thêm nhân viên thành công');
    }

    public function detail(Request $request)
    {
        $employeeId = $request->id;
        $date = $request->date;

        return view('admin.pages.employee.detail', $this->employeeService->detail($employeeId, $date));
    }
}

