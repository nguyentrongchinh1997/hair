<?php

namespace App\Http\Service\admin;

use App\Model\Employee;
use App\Model\Service;

class AdminService
{
	protected $employeeModel, $serviceModel;

    public function __construct(Employee $employee, Service $service)
    {
        $this->employeeModel = $employee;
        $this->serviceModel = $service;
    }

    public function employeeAdd($request)
    {
    	return $this->employeeModel->create($request->all());
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
    	$data = [
    		'employeeList' => $employeeList,
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
}