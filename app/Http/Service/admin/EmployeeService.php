<?php

namespace App\Http\Service\admin;

use App\Model\Employee;
use App\Model\Service;
use App\Model\BillDetail;
use App\Model\Bill;
use App\Model\EmployeeCommision;

class EmployeeService
{
	protected $employeeModel, $serviceModel, $billDetailModel, $employeeCommisionModel, $billModel;

	public function __construct(Employee $employee, Service $service, BillDetail $billDetail, EmployeeCommision $employeeCommision, Bill $bill)
    {
        $this->employeeModel = $employee;
        $this->serviceModel = $service;
        $this->billDetailModel = $billDetail;
        $this->employeeCommisionModel = $employeeCommision;
        $this->billModel = $bill;
    }

    public function employeeAdd($inputs)
    {
        if (!is_null($inputs['image'])) {
            $nameImage = str_slug($inputs['full_name']) . '-' . rand() . '.' . $inputs['image']->getClientOriginalExtension();
            $inputs['image']->move('upload/images/employee/', $nameImage);
        } else {
            $nameImage = NULL;
        }
        return $this->employeeModel->create([
            'full_name' => $inputs['full_name'],
            'phone' => $inputs['phone'],
            'service_id' => $inputs['type'],
            'address' => $inputs['address'],
            'image' => $nameImage,
            'password' => bcrypt($inputs['password']),
            'salary' => str_replace(',', '', $inputs['salary']),
        ]);
    }

	public function employeeListView()
    {
        $type = 'month';
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
            'type' => $type,
            'date_start' => '',
            'date_end' => '',
            'year' => $year,
            'month' => $month,
            'employeeList' => $employeeList,
            'serviceList' => $serviceList,
        ];

        return $data;
    }

    public function commisionTime($request, $type)
    {
        if ($type == 'month') {
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
                'date_end' => '',
                'date_start' => '',
                'type' => $type,
                'year' => $year,
                'month' => $month,
                'employeeList' => $employeeList,
                'serviceList' => $serviceList,
            ];
        } else if ($type == 'between') {
            $month = date('m');
            $year = date('Y');
            $startTime = str_replace('/', '-', $request->date_start);
            $startTimeFormat = date('Y-m-d', strtotime($startTime));
            $endTime = str_replace('/', '-', $request->date_end);
            $endTimeFormat = date('Y-m-d', strtotime($endTime));
            $employeeList = $this->employeeModel
                                ->with(['employeeCommision' => function($q) use ($startTimeFormat, $endTimeFormat){
                                    $q->whereBetween('date', [$startTimeFormat, $endTimeFormat]);
                                }])
                                ->orderBy('created_at', 'desc')
                                ->get();
            $serviceList = $this->serviceModel->all();
            $data = [
                'date_end' => $request->date_end,
                'date_start' => $request->date_start,
                'type' => $type,
                'year' => $year,
                'month' => $month,
                'employeeList' => $employeeList,
                'serviceList' => $serviceList,
            ];
        }
        

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
            if ($request->password != '') {
                $password = bcrypt($request->password);
            } else {
                $password = $request->older_password;
            }
            $this->employeeModel->updateOrCreate(
                ['id' => $id],
                [
                    'full_name' => $request->full_name,
                    'phone' => $request->phone,
                    'service_id' => $request->service_id,
                    'address' => $request->address,
                    'salary' => str_replace(',', '', $request->salary),
                    'status' => $request->status,
                    'password' => $password,
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

    public function detail($employeeId, $date, $type)
    {
        $employee = $this->employeeModel->findOrFail($employeeId);
        if ($type == 'month') {
            $commisionList = $this->employeeCommisionModel
                              ->where('employee_id', $employeeId)
                              ->where('created_at', 'like', $date . '%')
                              ->get();
            $rate = $this->billDetailModel->where('created_at', 'like', $date . '%')
                                          ->where(function($query) use ($employeeId){
                                                $query->where('employee_id', $employeeId)
                                                      ->orWhere('assistant_id', $employeeId);
                                          })
                                          ->get()
                                          ->groupBy('bill_id');
        } elseif ($type == 'between') {
            $startTime = explode('-', $date)[0];
            $startTimeFormat = date('Y-m-d', strtotime(str_replace('/', '-', $startTime)));
            $endTime = explode('-', $date)[1];
            $endTimeFormat = date('Y-m-d', strtotime(str_replace('/', '-', $endTime)));
            $commisionList = $this->employeeCommisionModel
                              ->where('employee_id', $employeeId)
                              ->whereBetween('date', [$startTimeFormat, $endTimeFormat])
                              ->get();
            $rate = $this->billDetailModel->whereBetween('created_at', [$startTimeFormat, $endTimeFormat])
                                          ->where(function($query) use ($employeeId){
                                                $query->where('employee_id', $employeeId)
                                                      ->orWhere('assistant_id', $employeeId);
                                          })
                                          ->get()
                                          ->groupBy('bill_id');
        }
        $data = [
            'type' => $type,
            'rate' => $rate,
            'employee' => $employee,
            'date' => $date,
            'commisionList' => $commisionList,
        ];

        return $data;
    }

    public function resultSearch($request)
    {
        $employeeName = $request->get('name');
        $type = $request->get('type');
        $date = $request->date;

        if ($employeeName == 'null') {
            if ($type == 'month') {
                $employeeList = $this->employeeModel
                                     ->with(['employeeCommision' => function($q) use ($date){
                                        $q->where('created_at', 'like', $date . '%');
                                     }])
                                     ->orderBy('created_at', 'desc')
                                     ->get();
            } elseif ($type == 'between') {
                $date_start = str_replace('/', '-', explode('-', $date)[0]);
                $date_end = str_replace('/', '-', explode('-', $date)[1]);
                $startTimeFormat = date('Y-m-d', strtotime($date_start));
                $endTimeFormat = date('Y-m-d', strtotime($date_end));
                $employeeList = $this->employeeModel
                                     ->with(['employeeCommision' => function($q) use ($startTimeFormat, $endTimeFormat){
                                        $q->whereBetween('date', [$startTimeFormat, $endTimeFormat]);
                                     }])
                                     ->orderBy('created_at', 'desc')
                                     ->get();
            }
        } else {
            if ($type == 'month') {
                $employeeList = $this->employeeModel
                                     ->where('full_name', 'like', '%' . $employeeName . '%')  
                                     ->with(['employeeCommision' => function($q) use ($date){
                                        $q->where('created_at', 'like', $date . '%');
                                     }])
                                     ->orderBy('created_at', 'desc')
                                     ->get();
            } elseif ($type == 'between') {
                $date_start = str_replace('/', '-', explode('-', $date)[0]);
                $date_end = str_replace('/', '-', explode('-', $date)[1]);
                $startTimeFormat = date('Y-m-d', strtotime($date_start));
                $endTimeFormat = date('Y-m-d', strtotime($date_end));
                $employeeList = $this->employeeModel
                                     ->where('full_name', 'like', '%' . $employeeName . '%')
                                     ->with(['employeeCommision' => function($q) use ($startTimeFormat, $endTimeFormat){
                                        $q->whereBetween('date', [$startTimeFormat, $endTimeFormat]);
                                     }])
                                     ->orderBy('created_at', 'desc')
                                     ->get();
            }
        }
       
        $data = [
            'type' => $type,
            'employeeList' => $employeeList,
        ];

        return $data;
    }
}