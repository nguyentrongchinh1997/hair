<?php

namespace App\Http\Service\client;

use App\Model\Employee;

class AjaxService
{
	protected $employeeModel;

    public function __construct(Employee $employee)
    {
        $this->employeeModel = $employee;
    }

    public function employeeList($type)
    {
    	$employee = $this->employeeModel->where('type', $type)->get();
    	$data = [
    		'employeeList' => $employee,
    	];

    	return $data; 
    }
}