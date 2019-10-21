<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Service\admin\MembershipService;

class MembershipController extends Controller
{
	protected $membershipService;

	public function __construct(MembershipService $membership)
	{
		$this->membershipService = $membership;
	}
    public function viewListMemberShip()
    {
    	return view('admin.pages.membership.list', $this->membershipService->viewListMemberShip());
    }

    public function membershipTimeList(Request $request)
    {
        return view('admin.pages.membership.list', $this->membershipService->membershipTimeList($request));
    }

    public function membershipAdd(Request $request)
    {
    	$this->membershipService->membershipAdd($request);

    	return back()->with('thongbao', 'Thêm hội viên thành công');
    }

    public function getExtensionView($id)
    {
        return view('admin.ajax.extension_card', $this->membershipService->getExtensionView($id));
    }

    public function postExtension(Request $request, $id)
    {
        $this->membershipService->postExtension($request, $id);

        return back()->with('thongbao', 'Gia hạn thành công');
    }

    public function search(Request $request)
    {
        return view('admin.pages.membership.search', $this->membershipService->search($request->get('key')));
    }

    public function membershipAddOther(Request $request)
    {
        $this->membershipService->membershipAddOther($request);

        return back()->with('thongbao', 'thêm thẻ thành công');
    }

    public function membershipDelete($id)
    {
        $this->membershipService->membershipDelete($id);

        return back()->with('thongbao', 'xóa thành công');
    }
}
