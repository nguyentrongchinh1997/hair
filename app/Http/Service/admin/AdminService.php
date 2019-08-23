<?php

namespace App\Http\Service\admin;

use App\Model\Employee;
use App\Model\Service;
use App\Model\Order;
use App\Model\Bill;

class AdminService
{
    protected $employeeModel, $serviceModel, $orderModel, $billModel;

    public function __construct(Employee $employee, Service $service, Order $order, Bill $bill)
    {
        $this->employeeModel = $employee;
        $this->serviceModel = $service;
        $this->orderModel = $order;
        $this->billModel = $bill;
    }

    public function employeeAdd($request)
    {
        return $this->employeeModel->create([
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'type' => $request->type,
            'address' => $request->address,
            'percent' => $request->percent,
            'password' => bcrypt($request->password),
        ]);
    }

    public function serviceAdd($inputs)
    {
        return $this->serviceModel->create([
            'name' => $inputs['name'],
            'price' => str_replace(',', '', $inputs['price']),
        ]);
    }

    public function employeeListView()
    {
        $employeeList = $this->employeeModel->orderBy('created_at', 'desc')->paginate(20);
        $serviceList = $this->serviceModel->all();
        $data = [
            'employeeList' => $employeeList,
            'serviceList' => $serviceList,
        ];

        return $data;
    }

    public function serviceListView()
    {
        $serviceList = $this->serviceModel->orderBy('created_at', 'desc')->paginate(20);
        $data = [
            'serviceList' => $serviceList,
        ];

        return $data;
    }

    public function orderListView()
    {
        $orderList = $this->orderModel->where('status', config('config.order.status.create'))->orderBy('created_at', 'desc')->paginate(20);
        $bill = $this->billModel->where('status', config('config.order.status.check-in'))->paginate(20);
        $data = [
            'orderList' => $orderList,
            'billList' => $bill,
        ];

        return $data;
    }

    public function oldDataEmployee($id)
    {
        $oldData = $this->employeeModel->findOrFail($id);
        $data = [
            'oldData' => $oldData,
        ];

        return $data;
    }

    public function oldDataService($id)
    {
        $oldData = $this->serviceModel->findOrFail($id);
        $data = [
            'oldData' => $oldData,
        ];

        return $data;
    }

    public function employeeEdit($request, $id)
    {
        $this->employeeModel->updateOrCreate(
            ['id' => $id],
            $request->all()
        );
    }

    public function serviceEdit($inputs, $id)
    {
        $service = $this->serviceModel->findOrFail($id);
        $service->name = $inputs['name'];
        $service->price = str_replace(',', '', $inputs['price']);
        
        return $service->save();
    }

    public function billList()
    {
        $bill = $this->billModel->paginate(20);
        $data = [
            'billList' => $bill,
        ];

        return $data;
    }
}
