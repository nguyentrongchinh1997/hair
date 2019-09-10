<?php

namespace App\Http\Service\client;

use App\Model\Employee;
use App\Model\Bill;
use App\Model\Service;

class AjaxService
{
    protected $employeeModel, $billModel, $serviceModel;

    public function __construct(Employee $employee, Bill $bill, Service $service)
    {
        $this->employeeModel = $employee;
        $this->billModel = $bill;
        $this->serviceModel = $service;
    }

    public function employeeList($type)
    {
        $employee = $this->employeeModel->where('service_id', $type)->where('status', config('config.employee.status.doing'))->get();
        $data = [
            'employeeList' => $employee,
        ];

        return $data; 
    }

    public function updateComment($request, $billId)
    {
        $bill = $this->billModel->findOrFail($billId);
        $comment = $request->get('message');
        if ($bill->comment == '') {
            $commentUpdate = $comment;
        } else {
            $commentUpdate = $bill->comment . $comment;
        }
        
        return $this->billModel->updateOrCreate(
            ['id' => $billId],
            [
                'comment' => $commentUpdate,
            ]
        );
    }

    public function deleteComment($request, $billId)
    {
        $bill = $this->billModel->findOrFail($billId);
        $commentUpdate = str_replace($request->get('message'), '', $bill->comment);

        return $this->billModel->updateOrCreate(
            ['id' => $billId],
            [
                'comment' => $commentUpdate,
            ]
        );
    }

    public function getService($serviceId)
    {
        $employee = $this->employeeModel->where('service_id', $serviceId)->get();
        $data = [
            'employee' => $employee,
        ];

        return $data;
    }
    public function getSkinner($serviceId)
    {
        $employee = $this->employeeModel->where('service_id', $serviceId)->get();
        $data = [
            'employee' => $employee,
        ];

        return $data;
    }
}
