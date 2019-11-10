<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Service\admin\OrderService;
use App\Model\Bill;
use App\Model\Order;

class OrderController extends Controller
{
	protected $orderService;

	public function __construct(OrderService $order)
	{
		$this->orderService = $order;
	}

    public function checkIn($idOrder, Request $request)
    {
        $this->orderService->checkIn($idOrder, $request);

        return back()->with('thongbao', 'Check-in thành công');
    }

    public function orderListView()
    {
        return view('admin.pages.order.list', $this->orderService->orderListView());
    }

    public function postOrderListView(Request $request)
    {
        return view('admin.pages.order.list', $this->orderService->postOrderListView($request));
    }

    public function resultList(Request $request)
    {
        $key = $request->get('keySearch');
        $date = $request->get('date');
        $data = [
            'customer' => $this->orderService->resultList($key, $date),
        ];

        return view('admin.ajax.order_list', $data);
    }

    public function orderDetail($orderId)
    {
        return view('admin.pages.order.detail',$this->orderService->orderDetail($orderId));
    }

    public function deleteOrder($orderDetailId, $orderId)
    {
        $notification = $this->orderService->deleteOrder($orderDetailId, $orderId);

        echo $notification;
    }

    public function editService($serviceId, $orderDetailId)
    {
        echo $this->orderService->editService($serviceId, $orderDetailId);
    }

    public function editEmployee($employeeId, $orderDetailId)
    {
        $this->orderService->editEmployee($employeeId, $orderDetailId);
    }

    public function addOrder(Request $request)
    {
        $this->orderService->addOrder($request);

        return back()->with('thongbao', 'Thêm lịch thành công');
    }

    public function updateAssistant($assistantId, $id)
    {
        $this->orderService->updateAssistant($assistantId, $id);
    }

    public function orderCancel($id)
    {
        $this->orderService->orderCancel($id);

        return back()->with('thongbao', 'Hủy đơn thành công');
    }

    public function serviceAdd(Request $request)
    {
        return view('admin.pages.order.add_service', $this->orderService->serviceAdd($request));
    }

    public function customerName(Request $request)
    {
        echo $this->orderService->customerName($request->get('phone'));
    }

    public function convert()
    {
        $order = Order::all();
        foreach ($order as $order) {
            Bill::where('id', $order->bill_id)->update(['request' => $order->request]);
        }
    }
}
