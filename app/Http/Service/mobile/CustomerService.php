<?php
namespace App\Http\Service\mobile;

use App\Model\Time;
use App\Model\Employee;
use App\Model\Service;
use App\Model\Bill;
use App\Model\Card;

class CustomerService
{
	protected $timeModel, $employeeModel, $serviceModel, $billModel, $cardModel;

	public function __construct(Time $time, Employee $employee, Service $service, Bill $bill, Card $card)
	{
		$this->timeModel = $time;
		$this->employeeModel = $employee;
		$this->serviceModel = $service;
		$this->billModel = $bill;
		$this->cardModel = $card;
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

    public function history()
    {
    	$historyList = $this->billModel->where('status', config('config.order.status.check-out'))
    									->where('customer_id', auth('customers')->user()->id)
    									->get();
    	$data = [
    		'historyList' => $historyList,
    	];

    	return $data;
    }

    public function card()
    {
    	$card = $this->cardModel->where('customer_id', auth('customers')->user()->id)
    							->first();

    	if (isset($card)) {
    		$data = [
    			'card' => $card,
    		];
    	} else {
    		$data = [
    			'card' => '',
    		];
    	}

    	return $data;
    }

}
