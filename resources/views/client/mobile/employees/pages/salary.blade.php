@extends('client.mobile.employees.layouts.index')
    
@section('content')
<div class="row" style="margin-top: 92px !important; margin-bottom: 100px !important">
    <div class="col-12" style="background: #262626; height: 40px;">
        <div class="rio-promos">
            <a class="menu-tab active" value="today" data="?today={{ date('Y-m-d') }}">
                Hôm nay
            </a>
            <a class="menu-tab" value="last-day" data="?last_day={{ date('Y-m-d') }}">
                Hôm qua
            </a>
            <a class="menu-tab" value="month" data="?month={{ date('Y-m') }}">
                Tháng này
            </a>
            <a class="menu-tab" value="last-month" data="?last_month={{ date('Y-m', strtotime('-1 month')) }}">
                Tháng trước
            </a>
            <a class="menu-tab" value="pick-day">
                Chọn ngày
            </a>
           
        </div>
    </div>
    <div class="col-12 tab" id="today" style="text-align: center; padding: 15px 5px;">
        <h5>Tổng lương thực nhận</h5>
        <h3 style="font-weight: bold;">
            @php $total = 0; @endphp

            @foreach ($salaryToday as $salary)
                @if ($salary->billDetail->bill->status == config('config.order.status.check-out'))
                    @php 
                        $total = $total + $salary->billDetail->money * $salary->percent/100;
                    @endphp
                @endif
            @endforeach
            {{ str_replace(',', '.', number_format($total)) }} Đ
        </h3><br>
        <h6 style="margin-bottom: 0px; background: #eee; padding: 10px 0px; font-weight: bold;">CHIẾT KHẤU DỊCH VỤ</h6>
        <table>
            @if ($salaryToday->count() > 0)
                @foreach ($salaryToday as $salary)
                    @if ($salary->billDetail->bill->status == config('config.order.status.check-out'))
                        <tr>
                            <td style="text-align: left;">
                                @if ($salary->billDetail->service_id != '')
                                    {{ $salary->billDetail->service->name }}
                                @else
                                    {{ $salary->billDetail->other_service }}
                                @endif
                            </td>
                            <td>
                                {{ $salary->percent }}%
                            </td>
                            <td style="text-align: right;">
                                {{ number_format($salary->percent/100 * $salary->billDetail->money) }}<sup>đ</sup>
                            </td>
                            <td>
                                {{ date('d/m/Y H:i', strtotime($salary->created_at)) }}
                            </td>
                        </tr>
                    @endif
                @endforeach
            @else
                <tr>
                    <i>chưa có dịch vụ nào</i>
                </tr>
            @endif
        </table>
    </div>
    <div class="col-12 tab" id="last-day" style="text-align: center; padding: 15px 5px; display: none;">
        <h5>Tổng lương thực nhận</h5>
        <h3 style="font-weight: bold;">
            @php $total = 0; @endphp

            @foreach ($salaryYesterday as $salary)
                @if ($salary->billDetail->bill->status == config('config.order.status.check-out'))    
                    @php 
                        $total = $total + $salary->billDetail->money * $salary->percent/100;
                    @endphp
                @endif
            @endforeach
            {{ str_replace(',', '.', number_format($total)) }}<sup>đ</sup>
        </h3>
        <br>
        <h6 style="margin-bottom: 0px; background: #eee; padding: 10px 0px; font-weight: bold;">CHIẾT KHẤU DỊCH VỤ</h6>
        <table>
        @if ($salaryYesterday->count() > 0)
            @foreach ($salaryYesterday as $salary)
                @if ($salary->billDetail->bill->status == config('config.order.status.check-out'))
                    <tr>
                        <td style="text-align: left;">
                            @if ($salary->billDetail->service_id != '')
                                {{ $salary->billDetail->service->name }}
                            @else
                                {{ $salary->billDetail->other_service }}
                            @endif
                        </td>
                        <td>
                            {{ $salary->percent }}%
                        </td>
                        <td style="text-align: right;">
                            {{ number_format($salary->percent/100 * $salary->billDetail->money) }}<sup>đ</sup>
                        </td>
                        <td>
                            {{ date('d/m/Y H:i', strtotime($salary->created_at)) }}
                        </td>
                    </tr>
                @endif
            @endforeach
        @else
            <tr>
                <td colspan="3">
                    <i>
                        Chưa có dịch vụ nào
                    </i>
                </td>

            </tr>
        @endif
        </table>
    </div>
    <div class="col-12 tab" id="month" style="text-align: center; padding: 15px 5px; display: none;">
        <h5>Tổng lương thực nhận</h5>
        <h3 style="font-weight: bold;">
            @php $total = 0; @endphp

            @foreach ($salaryMonth as $salary)
                @if ($salary->billDetail->bill->status == config('config.order.status.check-out'))
                    @php 
                        $total = $total + $salary->billDetail->money * $salary->percent/100;
                    @endphp
                @endif
            @endforeach
            {{ str_replace(',', '.', number_format($total + auth('employees')->user()->salary)) }}<sup>đ</sup>
        </h3><br>
        <h6 style="margin-bottom: 0px; background: #eee; padding: 10px 0px; font-weight: bold;">CHIẾT KHẤU DỊCH VỤ</h6>
        <table>
            @if ($salaryMonth->count() > 0)
                @foreach ($salaryMonth as $salary)
                    @if ($salary->billDetail->bill->status == config('config.order.status.check-out'))
                        <tr>
                            <td style="text-align: left;">
                                @if ($salary->billDetail->service_id != '')
                                    {{ $salary->billDetail->service->name }}
                                @else
                                    {{ $salary->billDetail->other_service }}
                                @endif
                            </td>
                            <td>
                                {{ $salary->percent }}%
                            </td>
                            <td style="text-align: right;">
                                {{ number_format($salary->percent/100 * $salary->billDetail->money) }}<sup>đ</sup>
                            </td>
                            <td>
                                {{ date('d/m/Y H:i', strtotime($salary->created_at)) }}
                            </td>
                        </tr>
                    @endif
                @endforeach
            @else
                <tr>
                    <td colspan="3">
                        <i>Chưa có dịch vụ nào</i>
                    </td>
                    
                </tr>
            @endif
        </table>
    </div>
    <div class="col-12 tab" id="last-month" style="text-align: center; padding: 15px 5px; display: none;">
        <h5>Tổng lương thực nhận</h5>
        <h3 style="font-weight: bold;">
            @php $total = 0; @endphp

            @foreach ($salaryLastMonth as $salary)
                @if ($salary->billDetail->bill->status == config('config.order.status.check-out'))    
                    @php 
                        $total = $total + $salary->billDetail->money * $salary->percent/100;
                    @endphp
                @endif
            @endforeach
            {{ str_replace(',', '.', number_format($total + auth('employees')->user()->salary)) }}<sup>đ</sup>
        </h3><br>
        <h6 style="margin-bottom: 0px; background: #eee; padding: 10px 0px; font-weight: bold;">CHIẾT KHẤU DỊCH VỤ</h6>
        <table>
            @if ($salaryLastMonth->count() > 0)
                @foreach ($salaryLastMonth as $salary)
                    @if ($salary->billDetail->bill->status == config('config.order.status.check-out'))
                        <tr>
                            <td style="text-align: left;">
                                @if ($salary->billDetail->service_id != '')
                                    {{ $salary->billDetail->service->name }}
                                @else
                                    {{ $salary->billDetail->other_service }}
                                @endif
                            </td>
                            <td>
                                {{ $salary->percent }}%
                            </td>
                            <td style="text-align: right;">
                                {{ number_format($salary->percent/100 * $salary->billDetail->money) }} Đ
                            </td>
                            <td>
                                {{ date('H:i', strtotime($salary->created_at)) }}
                            </td>
                        </tr>
                    @endif
                @endforeach
            @else
                <tr>
                    <td colspan="3">
                        <i>Chưa có dịch vụ nào</i>
                    </td>
                    
                </tr>
            @endif
        </table>

    </div>
    <div class="col-12 tab" id="pick-day" style="padding: 15px 15px; display: none;">
        <label>Chọn ngày <b>bắt đầu</b> và <b>kết thúc</b></label>
        <input type="text" placeholder="dd/mm/yyyy - dd/mm/yyyy" id="demo-2" class="form-control form-control-sm date-pick"/>
        <button id="seen" style="margin-top: 20px">XEM</button>
        <!-- <table style="width: 100%">
            <tr>
                <td>
                    TỪ
                </td>
                <td>
                    <input placeholder="Chọn ngày bắt đầu" id="date-from" type="date" name="">
                </td>
            </tr>
            <tr>
                <td style="padding-top: 10px">
                    ĐẾN
                </td>
                <td style="padding-top: 10px">
                    <input placeholder="Chọn ngày kết thúc" id="date-to" type="date" name="">
                </td>
            </tr>
            <tr>
                <td style="padding-top: 10px">
                    
                </td>
                <td id="seen" style="padding-top: 10px">
                    <button>XEM</button>
                </td>
            </tr>
        </table> -->
        <div class="row" id="result">
            
        </div>
    </div>
</div>
@endsection
