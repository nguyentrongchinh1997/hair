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
        $this->cardService->postCard($request);

        return back()->with('thongbao', 'Thêm thẻ hội viên thành công');
    }

    public function postExtension(Request $request, $id)
    {
        $this->cardService->postExtension($request, $id);

        return back()->with('thongbao', 'Gia hạn thành công');
    }
}
