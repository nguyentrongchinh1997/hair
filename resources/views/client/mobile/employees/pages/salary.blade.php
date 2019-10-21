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
<!-- Lương hôm nay -->
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
            <tr style="background: #BBDEFB; color: #000">
                <td>Dịch vụ</td>
                <td>Chiết khấu</td>
                <td>Thời gian</td>
                <td>Tổng</td>
            </tr>
            <tr>
                <td style="text-align: right; font-weight: bold; font-size: 18px" colspan="4" class="tong"></td>
            </tr>
            @php $tong = 0; @endphp
            @if ($salaryToday->count() > 0)
                @foreach ($salaryToday as $salary)
                    @if ($salary->billDetail->bill->status == config('config.order.status.check-out'))
                        <tr>
                            <td style="text-align: center;">
                                @if ($salary->billDetail->service_id != '')
                                    {{ $salary->billDetail->service->name }}
                                @else
                                    {{ $salary->billDetail->other_service }}
                                @endif
                            </td>
                            <td style="color: #727272">
                                {{ $salary->percent }}%
                            </td>
                            <td style="color: #727272">
                                {{ date('d/m/Y', strtotime($salary->created_at)) }}
                            </td>
                            <td style="text-align: right;">
                                {{ number_format($salary->percent/100 * $salary->billDetail->money) }}<sup>đ</sup>
                            </td>
                            @php
                                $tong = $tong + ($salary->percent/100 * $salary->billDetail->money);
                            @endphp
                        </tr>
                    @endif
                @endforeach
                <tr style="display: none;">
                    <td colspan="4" id="tong">{{ number_format($tong) }}<sup>đ</sup></td>
                </tr>
            @else
                <tr>
                    <td colspan="4" style="text-align: center;">
                        <i>Bạn không phục vụ khách nào</i>
                    </td>
                    
                </tr>
            @endif
        </table>
    </div>
<!-- end -->

<!-- Lương hôm qua -->
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
            <tr style="background: #BBDEFB; color: #000">
                <td>Dịch vụ</td>
                <td>Chiết khấu</td>
                <td>Thời gian</td>
                <td>Tổng</td>
            </tr>
            <tr>
                <td style="text-align: right; font-weight: bold; font-size: 18px" colspan="4" class="total-yesterday"></td>
            </tr>
        @php $tong = 0; @endphp
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
                        <td>
                            {{ date('d/m/Y', strtotime($salary->created_at)) }}
                        </td>
                        <td style="text-align: right;">
                            {{ number_format($salary->percent/100 * $salary->billDetail->money) }}<sup>đ</sup>
                        </td>
                        @php
                            $tong = $tong + ($salary->percent/100 * $salary->billDetail->money);
                        @endphp
                    </tr>
                @endif
            @endforeach
                <tr style="display: none;">
                    <td colspan="4" id="total-yesterday">{{ number_format($tong) }}<sup>đ</sup></td>
                </tr>
            @else
                <tr>
                    <td colspan="4" style="text-align: center;">
                            <i>Bạn không phục vụ khách nào</i>
                    </td>

                </tr>
            @endif
        </table>
    </div>
<!-- end -->

<!-- Lương tháng này -->
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
            <tr style="background: #BBDEFB; color: #000">
                <td>Dịch vụ</td>
                <td>Chiết khấu</td>
                <td>Thời gian</td>
                <td>Tổng</td>
            </tr>
            <tr>
                <td style="text-align: right; font-weight: bold; font-size: 18px" class="total-month" colspan="4"></td>
            </tr>
            @php $tong = 0; @endphp
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
                            <td>
                                {{ date('d/m/Y', strtotime($salary->created_at)) }}
                            </td>
                            <td style="text-align: right;">
                                {{ number_format($salary->percent/100 * $salary->billDetail->money) }}<sup>đ</sup>
                            </td>
                            @php
                                $tong = $tong + ($salary->percent/100 * $salary->billDetail->money);
                            @endphp
                        </tr>
                    @endif
                @endforeach
                <tr style="display: none;">
                    <td id="total-month">{{ number_format($tong) }}<sup>đ</sup></td>
                </tr>
            @else
                <tr>
                    <td colspan="4">
                        <i>Bạn không phục vụ khách nào</i>
                    </td>
                    
                </tr>
            @endif
        </table>
    </div>
<!-- end -->

<!-- Lương tháng trước -->
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
            <tr style="background: #BBDEFB; color: #000">
                <td>Dịch vụ</td>
                <td>Chiết khấu</td>
                <td>Thời gian</td>
                <td>Tổng</td>
            </tr>
            <tr>
                <td style="text-align: right; font-weight: bold; font-size: 18px" class="total-last-month" colspan="4"></td>
            </tr>
            @php $tong = 0; @endphp
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
                            <td>
                                {{ date('d/m/Y', strtotime($salary->created_at)) }}
                            </td>
                            <td style="text-align: right;">
                                {{ number_format($salary->percent/100 * $salary->billDetail->money) }}<sup>đ</sup>
                            </td>
                        </tr>
                        @php
                            $tong = $tong + ($salary->percent/100 * $salary->billDetail->money);
                        @endphp
                    @endif
                @endforeach
                <tr style="display: none;">
                    <td id="total-last-month">{{ number_format($tong) }}<sup>đ</sup></td>
                </tr>
            @else
                <tr>
                    <td colspan="4" style="text-align: center;">
                        <i>Bạn không phục vụ khách nào</i>
                    </td>
                </tr>
            @endif
        </table>
    </div>
<!-- end -->

<!-- Lương chọn theo ngày -->
    <div class="col-12 tab" id="pick-day" style="padding: 15px 15px; display: none;">
        <label>Chọn ngày <b>bắt đầu</b> và <b>kết thúc</b></label>
        <table>
            <tr>
                <td>
                    Từ
                </td>
                <td>
                    <input type="text" placeholder="dd/mm/yyyy" id="demo-3_1" class="date-start form-control form-control-sm date-pick"/>
                </td>
                
            </tr>
            <tr>
                <td>
                    Đến
                </td>
                <td>
                    <input type="text" placeholder="dd/mm/yyyy" id="demo-3_2" class="date-end form-control form-control-sm date-pick"/>
                </td>
            </tr>
        </table>
        <button id="seen" style="margin-top: 20px">XEM</button>
        
        <div class="row" id="result">
            
        </div>
    </div>
<!-- end -->
</div>
@endsection
