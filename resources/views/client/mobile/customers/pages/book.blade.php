@extends('client.mobile.customers.layouts.index')

@section('content')
    <div class="row history">
        <div class="container" style="margin-top: 100px; padding: 0px; margin-bottom: 100px !important">
            <div class="col-12">
                <p style="font-weight: bold;">Lịch đặt hôm nay</p>
                <table>
                    @if ($order->count() > 0)
                        @foreach ($order as $order)
                            @if ($order->status == config('config.order.status.create'))
                                <table>
                                    <tr>
                                        <td>Thời gian</td>
                                        <td>{{ $order->time->time }}</td>
                                    </tr>
                                    <tr>
                                        <td>Dịch vụ</td>
                                        <td>
                                            @foreach ($order->orderDetail as $service)
                                                <span>{{ $service->service->name }}</span>
                                                (@if($service->employee_id != '')
                                                    <span style="color: #727272">{{$service->employee->full_name}}</span>
                                                @endif
                                                @if($service->assistant_id != '')
                                                    <span style="color: #727272">
                                                        ,{{$service->assistant->full_name}}
                                                    </span>
                                                    
                                                @endif)
                                                <br>
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Trạng thái</td>
                                        <td>
                                            Chưa đến
                                        </td>
                                    </tr>
                                </table>
                            @else
                                <table>
                                    <tr>
                                        <td>Thời gian</td>
                                        <td>{{ $order->time->time }}</td>
                                    </tr>
                                    <tr>
                                        <td>Dịch vụ</td>
                                        <td>
                                            @foreach ($order->bill->billDetail as $service)
                                                <span>
                                                    @if ($service->service_id != '')
                                                        {{ $service->service->name }}
                                                    @else
                                                        {{ $service->other_service }}
                                                    @endif
                                                </span>
                                                <span style="color: #727272">({{$service->employee->full_name}}</span>
                                                @if($service->assistant_id != '')
                                                    <span style="color: #727272">
                                                        ,{{$service->employeeAssistant->full_name}}
                                                    </span>
                                                @endif)
                                                <br>
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Trạng thái</td>
                                        <td>
                                            @if ($order->status == config('config.order.status.check-in'))
                                                <span>Đã đến</span>
                                            @else
                                                <span>Đã thanh toán</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            @endif
                        @endforeach
                    @else
                        <tr>
                            <td colspan="2" style="background: #fff; border: 0px; text-align: center; font-weight: normal;">
                                <i>Không có lịch đặt của bạn</i>
                            </td>
                        </tr>   
                    @endif 
                </table>
                
            </div>
        </div>
    </div>
@endsection
