<?php

namespace App\Http\Service\admin;

use App\Model\Employee;
use App\Model\Service;
use App\Model\BillDetail;
use App\Model\EmployeeCommision;

class EmployeeService
{
	protected $employeeModel, $serviceModel, $billDetailModel, $employeeCommisionModel;

	public function __construct(Employee $employee, Service $service, BillDetail $billDetail, EmployeeCommision $employeeCommision)
    {
        $this->employeeModel = $employee;
        $this->serviceModel = $service;
        $this->billDetailModel = $billDetail;
        $this->employeeCommisionModel = $employeeCommision;
    }

    public function employeeAdd($request)
    {
        return $this->employeeModel->create([
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'service_id' => $request->type,
            'address' => $request->address,
            'percent' => $request->percent,
            'password' => bcrypt($request->password),
            'salary' => str_replace(',', '', $request->salary),
        ]);
    }

	public function employeeListView()
    {
        $today = date('Y-m');
        $month = date('m');
        $year =date('Y');
        $employeeList = $this->employeeModel
                            ->with(['employeeCommision' => function($q) use ($today){
                                $q->where('created_at', 'like', $today . '%');
                            }])
                            ->orderBy('created_at', 'desc')
                            ->get();
        $serviceList = $this->serviceModel->all();
        $data = [
            'year' => $year,
            'month' => $month,
            'employeeList' => $employeeList,
            'serviceList' => $serviceList,
        ];

        return $data;
    }

    public function commisionTime($request)
    {
        $month = $request->month;
        $year = $request->year;
        $today = $year . '-' . $month;
        $employeeList = $this->employeeModel
                            ->with(['employeeCommision' => function($q) use ($today){
                                $q->where('created_at', 'like', $today . '%');
                            }])
                            ->orderBy('created_at', 'desc')
                            ->get();
        $serviceList = $this->serviceModel->all();
        $data = [
            'year' => $year,
            'month' => $month,
            'employeeList' => $employeeList,
            'serviceList' => $serviceList,
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

    public function employeeEdit($request, $id)
    {
        $orderPhone = $this->employeeModel->findOrFail($id);
        $check = $this->employeeModel->where('phone', $request->phone)->count();

        if ($check == 0 || $orderPhone->phone == $request->phone) {
            $this->employeeModel->updateOrCreate(
                ['id' => $id],
                [
                    'full_name' => $request->full_name,
                    'phone' => $request->phone,
                    'service_id' => $request->service_id,
                    'address' => $request->address,
                    'percent' => $request->percent,
                    'salary' => str_replace(',', '', $request->salary),
                    'status' => $request->status,
                ]
            );
            return 1;
        } else {
            return 0;
        }
    }

    public function salary($employeeId)
    {
        $today = date('Y-m');
        $employee = $this->employeeModel->findOrFail($employeeId);
        $billDetail = $this->billDetailModel
                            ->where('date', 'like', $today . '%')
                            ->where('employee_id', $employeeId)
                            ->orderBy('date', 'DESC')
                            ->get();
        $month = date('m');
        $year =date('Y');
        $data = [
            'billDetail' => $billDetail,
            'month' => $month,
            'year' => $year,
            'employee' => $employee,
        ];

        return $data;
    }
    
    public function postSalary($employeeId, $request)
    {
        $today = $request->year . '-' . $request->month;
        $employee = $this->employeeModel->findOrFail($employeeId);
        $billDetail = $this->billDetailModel->where('date', 'like', $today . '%')->where('employee_id', $employeeId)->get();
        $month = $request->month;
        $year = $request->year;
        $data = [
            'billDetail' => $billDetail,
            'month' => $month,
            'year' => $year,
            'employee' => $employee,
        ];

        return $data;
    }

    public function detail($employeeId, $date)
    {
        $employee = $this->employeeModel->findOrFail($employeeId);
        $commisionList = $this->employeeCommisionModel
                            ->where('employee_id', $employeeId)
                            ->where('created_at', 'like', $date . '%')
                            ->get();
        $data = [
            'employee' => $employee,
            'date' => $date,
            'commisionList' => $commisionList,
        ];

        return $data;
    }
}
