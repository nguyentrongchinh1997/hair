<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Service\admin\CardService;

class CardController extends Controller
{
	protected $cardService;

	public function __construct(CardService $cardService)
	{
		$this->cardService = $cardService;
	}

	public function getCardList()
    {
        return view('admin.pages.cart.list', $this->cardService->getCartList());
    }

    public function postCard(Request $request)
    {
        $this->validate($request,
            [
                'service' => 'required|array',
            ],
            [
                'service.required' =>'* Bạn chưa chọn dịch vụ áp dụng cho thẻ hội viên',
            ]
        );
        $this->cardService->postCard($request);

        return back()->withInput()->with('thongbao', 'Thêm thẻ hội viên thành công');
    }

    public function postExtension(Request $request, $id)
    {
        $this->cardService->postExtension($request, $id);

        return back()->with('thongbao', 'Gia hạn thành công');
    }

    public function cardDelete($id)
    {
        $this->cardService->cardDelete($id);

        return back()->with('thongbao', 'Xóa thẻ thành công');
    }

    public function postOtherCard(Request $request)
    {
        $this->cardService->postOtherCard($request);
        
        return back()->with('thongbao', 'Thêm thẻ thành công');
    }
}
