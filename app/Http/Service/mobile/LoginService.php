<?php

namespace App\Http\Service\mobile;

use App\Model\Customer;
use Illuminate\Support\Facades\Auth; //Thư viện để đăng nhập

class loginService
{
	protected $customerModel;

	public function __construct(Customer $customer)
	{
		$this->customerModel = $customer;
	}
	public function postLogin($request)
	{
		$phone = str_replace('.', '', $request->phone);
		$checkPhone = $this->customerModel->where('phone', $phone)->count();

		if ($checkPhone > 0) {
			Auth::guard('customers')->attempt(['phone' => $phone, 'password' => $phone], true);
		} else {
			/*insert vào bảng orders*/
                $user = $this->customerModel->create([
                    'phone' => $phone,
                    'password' => bcrypt($phone),
                ]);
                auth('customers')->login($user);
            /*end*/
		}
	}

	public function postLoginEmployee($request)
	{
		$phone = str_replace('.', '', $request->phone);
		$password = $request->password;

		if (Auth::guard('employees')->attempt(['phone' => $phone, 'password' => $password], true)){
			return true;
		} else {
			return false;
		}
	}
}