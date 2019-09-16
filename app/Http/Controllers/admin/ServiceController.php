<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Service\admin\DvService;

class ServiceController extends Controller
{
	protected $service;

    public function __construct(DvService $service)
    {
        $this->service = $service;
    }

    public function serviceAdd(Request $request)
    {
        $this->service->serviceAdd($request->all());

        return back()->with('thongbao', 'Thêm dịch vụ thành công');
    }

   	public function serviceListView()
    {
        return view('admin.pages.service.list', $this->service->serviceListView());
    }

    public function serviceEditView($id)
    {
        return view('admin.pages.service.edit', $this->service->oldDataService($id));
    }

    public function serviceEdit(Request $request, $id)
    {
        $this->service->serviceEdit($request->all(), $id);
        
        return back()->with('thongbao', 'Sửa thành công');
    }
}
