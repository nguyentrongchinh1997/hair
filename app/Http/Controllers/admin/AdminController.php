<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Service\admin\AdminService;

class AdminController extends Controller
{
    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }
/*view trang chủ admin*/
    public function homeView()
    {
    	return view('admin.pages.home');
    }
/*end*/

/*view thêm dịch vụ*/
    public function serviceAddView()
    {
        return view('admin.pages.service.add');
    }
/*end*/

/*view thêm nhân viên*/
    public function employeeAddView()
    {
    	return view('admin.pages.employee.add');
    }
/*end*/

/*thêm nhân viên*/
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
    	$this->adminService->employeeAdd($request);

        return redirect()->back()->withInput()->with('thongbao', 'Thêm nhân viên thành công');
    }
/*end*/

/*thêm dịch vụ*/
    public function serviceAdd(Request $request)
    {
        $this->adminService->serviceAdd($request->all());

        return back()->with('thongbao', 'Thêm dịch vụ thành công');
    }
/*end*/

/*view danh sách nhân viên*/
    public function employeeListView()
    {
        return view('admin.pages.employee.list', $this->adminService->employeeListView());
    }
/*end*/

/*view danh sách dịch vụ*/
    public function serviceListView()
    {
        return view('admin.pages.service.list', $this->adminService->serviceListView());
    }
/*end*/

/*view sửa nhân viên*/
    public function employeeEditView($id)
    {
        return view('admin.pages.employee.edit', $this->adminService->oldDataEmployee($id));
    }
/*end*/

/*view sửa dịch vụ*/
    public function serviceEditView($id)
    {
        return view('admin.pages.service.edit', $this->adminService->oldDataService($id));
    }
/*end*/

/*sửa nhân viên*/
    public function employeeEdit(Request $request, $id)
    {
        $this->adminService->employeeEdit($request, $id);
        
        return back()->with('thongbao', 'Sửa thành công');
    }
/*end*/

/*sửa nhân viên*/
    public function serviceEdit(Request $request, $id)
    {
        $this->adminService->serviceEdit($request->all(), $id);
        
        return back()->with('thongbao', 'Sửa thành công');
    }
/*end*/
}
