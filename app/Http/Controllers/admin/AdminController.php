<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Service\admin\AdminService;

class AdminController extends Controller
{
    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }
/*view trang chủ admin*/
    public function homeView()
    {
    	return view('admin.pages.home');
    }
/*end*/

/*view thêm dịch vụ*/
    public function serviceAddView()
    {
        return view('admin.pages.service.add');
    }
/*end*/
}
