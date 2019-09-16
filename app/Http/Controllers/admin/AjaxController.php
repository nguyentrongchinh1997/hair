<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Service\admin\AjaxService;

class AjaxController extends Controller
{
    protected $ajaxService;

    public function __construct(AjaxService $ajax)
    {
        $this->ajaxService = $ajax;
    }

    // public function updateSale(Request $request, $billId)
    // {
    //     echo $this->ajaxService->updateSale($request, $billId);
    // }
}
