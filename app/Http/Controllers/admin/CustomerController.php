<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Service\admin\CustomerService;

class CustomerController extends Controller
{
    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function customerListview()
    {
        return view('admin.pages.customer.list', $this->customerService->customerListview());
    }

    public function postDeposit(Request $request)
    {
        $this->customerService->postDeposit($request);

        return back()->with('thongbao', 'Nạp tiền thành công');
    }

    public function viewDetailCustomer($customerId)
    {
        return view('admin.pages.customer.detail', $this->customerService->viewDetailCustomer($customerId));
    }

   	public function customerSerachResult($phone)
    {
        return view('admin.pages.customer.list_search', $this->customerService->customerSerachResult($phone));
    }

    public function customerAdd(Request $request)
    {
        $this->validate($request,
            [
                'phone' => 'unique:customers,phone',
            ],
            [
                'phone.unique' => 'Số điện thoại này đã được thêm',
            ]
        );
        $this->customerService->customerAdd($request->all());
        
        return back()->with('thongbao', 'Thêm khách hàng thành công');
    }
}
