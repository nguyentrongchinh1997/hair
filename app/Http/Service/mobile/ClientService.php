<?php
namespace App\Http\Service\mobile;

use App\Model\Time;
use App\Model\Employee;
use App\Model\Service;

class ClientService
{
	protected $timeModel, $employeeModel, $serviceModel;

	public function __construct(Time $time, Employee $employee, Service $service)
	{
		$this->timeModel = $time;
		$this->employeeModel = $employee;
		$this->serviceModel = $service;
	}
	public function viewHome($phone)
    {
        $timeList = $this->timeModel->all();
        $listStylist = $this->employeeModel
                            ->where('service_id', config('config.employee.type.skinner'))
                            ->orWhere('service_id', config('config.employee.type.stylist'))
                            ->get();
        $serviceList = $this->serviceModel->where('id', '<=', 2)->get();
        $hairCut = $this->serviceModel->findOrFail(config('config.service.cut'));
        $wash = $this->serviceModel->findOrFail(config('config.service.wash'));
        $data = [
            'phone' => $phone,
            'hairCut' => $hairCut,
            'wash' => $wash,
            'listStylist' => $listStylist,
            'time' => $timeList,
            'serviceList' => $serviceList,
        ];
        
        return $data;
    }
}