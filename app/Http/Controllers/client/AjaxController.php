<?php

namespace App\Http\Controllers\client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Service\client\AjaxService;
use App\Model\Employee;

class AjaxController extends Controller
{
	protected $ajaxService;

	public function __construct(AjaxService $ajaxService)
	{
		$this->ajaxService = $ajaxService;
	}

    public function getEmployee($type)
    {
    	return view('client.view_ajax.employee_list', $this->ajaxService->employeeList($type));
    }
}
