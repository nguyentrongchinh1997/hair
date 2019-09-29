@extends('client.mobile.employees.layouts.index')
    
@section('content')
    <div class="row employee-order" style="margin-top: 92px !important; margin-bottom: 100px !important">
        <div class="col-12" style="background: #eee; padding: 10px 15px">
            » Khách đã check-in
        </div>
        <div class="col-12">
            <table>
                <tr style="background: #fafafa">
                    <th>
                        Tên
                    </th>
                    <th>
                        Thời gian
                    </th>
                    <th>
                        Dịch vụ
                    </th>
                </tr>
                @if (App\Helper\ClassHelper::check() == 0)
                    <tr>
                        <td style="text-align: center;" colspan="3">
                            <i>
                                Hiện chưa có bill nào
                            </i>
                        </td>
                    </tr>
                @else
                    @foreach (App\Helper\ClassHelper::getBillId() as $key => $order)
                        @if (App\Helper\ClassHelper::checkBill($key) == true)
                            <tr>
                                
                                <td>
                                    {{ App\Helper\ClassHelper::customerName($key)->customer->full_name }}
                                </td>
                                <td>
                                    {{ App\Helper\ClassHelper::customerName($key)->order->time->time }}
                                </td>
                                <td>
                                    @foreach (App\Helper\ClassHelper::customerName($key)->billDetail as $service)
                                        {{ $service->service->name }},
                                    @endforeach
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endif
            </table>
        </div>
        <div class="col-12" style="background: #eee; padding: 10px 15px; margin-top: 20px">
            » Khách đặt lịch
        </div>
        <div class="col-12">
            <table>
                <tr style="background: #fafafa">
                    <th>
                        Tên
                    </th>
                    <th>
                        Thời gian
                    </th>
                    <th>
                        Dịch vụ
                    </th>
                </tr>
                @if (App\Helper\ClassHelper::checkOrder() == 0)
                    <tr>
                        <td style="text-align: center;" colspan="3">
                            <i>
                                Hiện chưa có bill nào
                            </i>
                        </td>
                    </tr>
                @else
                    @foreach (App\Helper\ClassHelper::getOrderId() as $key => $order)
                        @if (App\Helper\ClassHelper::checkOrderCreate($key) == true)
                            <tr>
                                <td>
                                    @if (App\Helper\ClassHelper::customerNameOrder($key)->customer->full_name == '')
                                        <i>Chưa có tên</i>
                                    @else
                                        {{ App\Helper\ClassHelper::customerNameOrder($key)->customer->full_name }}
                                    @endif
                                </td>
                                <td>
                                    {{ App\Helper\ClassHelper::customerNameOrder($key)->time->time }}
                                </td>
                                <td>
                                    @foreach (App\Helper\ClassHelper::customerNameOrder($key)->orderDetail as $service)
                                        @if ($service->service_id != '')
                                            {{ $service->service->name }}, 
                                        @else
                                            {{ $service->other_service }}, 
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endif
           
            </table>
        </div>
        <div class="col-12">
            <center>
                <a style="color: #fff" href="{{ route('mobile.employee.home') }}">
                    <button style="color: #fff; background: #000; border: 0px; margin-top: 20px; padding: 7px 20px; border-radius: 4px">
                        Tải lại
                    </button>
                </a>
            </center>
        </div>
    </div>
@endsection
