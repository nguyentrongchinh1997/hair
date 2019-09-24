@extends('client.mobile.employees.layouts.index')
    
@section('content')
    <div class="row employee-order" style="margin-top: 92px !important;">
        <div class="col-12" style="background: #eee; padding: 10px 15px">
            » Khách đang phục vụ
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
            » Khách đang đợi
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
                        <tr>
                            <td>
                                {{ App\Helper\ClassHelper::customerNameOrder($key)->customer->full_name }}
                            </td>
                            <td>
                                {{ App\Helper\ClassHelper::customerNameOrder($key)->time->time }}
                            </td>
                            <td>
                                @foreach (App\Helper\ClassHelper::customerNameOrder($key)->orderDetail as $service)
                                    {{ $service->service->name }},
                                @endforeach
                            </td>
                        </tr>
                       
                    @endforeach
                @endif
           
            </table>
        </div>
    </div>
@endsection