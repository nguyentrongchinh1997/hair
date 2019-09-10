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

    public function updateComment(Request $request, $billId)
    {
        $this->ajaxService->updateComment($request, $billId);
    }

    public function deleteComment(Request $request, $billId)
    {
        $this->ajaxService->deleteComment($request, $billId);
    }

    public function getService($serviceId)
    {
        return view('client.view_ajax.service_list', $this->ajaxService->getService($serviceId));
    }

    public function getSkinner($serviceId)
    {
        return view('client.view_ajax.skinner_list', $this->ajaxService->getSkinner($serviceId));
    }
}
