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
        return view('admin.ajax.detail_customer', $this->customerService->viewDetailCustomer($customerId));
    }

   	public function customerSerachResult($phone)
    {
        return view('admin.ajax.list_customer', $this->customerService->customerSerachResult($phone));
    }

}
