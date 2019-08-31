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

/*sửa dịch vụ*/
    public function serviceEdit(Request $request, $id)
    {
        $this->adminService->serviceEdit($request->all(), $id);
        
        return back()->with('thongbao', 'Sửa thành công');
    }
/*end*/

/*Danh sách đặt lịch khách hàng*/
    public function orderListView()
    {
        return view('admin.pages.order.list', $this->adminService->orderListView());
    }
/*end*/

/*Danh sách đặt lịch khách hàng khi tìm kiếm theo thời gian*/
    public function postOrderListView(Request $request)
    {
        return view('admin.pages.order.list', $this->adminService->postOrderListView($request));
    }
/*end*/

    public function postBillList(Request $request)
    {
        return view('admin.pages.bill.list', $this->adminService->postBillList($request));
    }

/*Hóa đơn*/
    public function billList()
    {
        return view('admin.pages.bill.list', $this->adminService->billList());
    }
/*end*/

/*check-in*/
    public function checkIn($idOrder, Request $request)
    {
        $this->adminService->checkIn($idOrder, $request);

        return back()->with('thongbao', 'Check-in thành công');
    }
/*end*/

    public function getRate($billId)
    {
        $rate = $this->adminService->getRate($billId);

        if ($rate->rate_id != '') {
            echo $rate->rate->name;
        } else {
            echo "<i>Đợi đánh giá</i>";
        }
    }

    public function getComment($billId)
    {
        $comment = $this->adminService->getComment($billId);
        echo $comment->comment . "<br>";
    }

    public function priceTotal($billId)
    {
        echo $this->adminService->priceTotal($billId);
    }

    public function getRateList()
    {
        return view('admin.pages.rate.list', $this->adminService->getRateList());
    }

    public function postRate(Request $request, $rateId)
    {
        $this->adminService->postRate($request, $rateId);

        return back()->with('thongbao', 'Sửa phần trăm thành công');
    }

    public function pay(Request $request, $billId)
    {
        $this->adminService->pay($billId, $request->price_service);

        return back();
    }
}
