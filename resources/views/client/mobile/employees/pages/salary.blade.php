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
            @php 
                $total = 0; 
                $luongCung = (auth('employees')->user()->salary)/config('config.full');
            @endphp

            @foreach ($salaryToday as $salary)
                @if ($salary->billDetail->bill->status == config('config.order.status.check-out'))
                    @php 
                        $total = $total + $salary->billDetail->money * $salary->percent/100;
                    @endphp
                @endif
            @endforeach
            {{ str_replace(',', '.', number_format($total + $luongCung)) }}<sup>đ</sup>
        </h3><br>
        <h6 style="margin-bottom: 0px; background: #eee; padding: 10px 0px; font-weight: bold;">CHIẾT KHẤU DỊCH VỤ</h6>
        <div class="row" style="overflow-x: auto;">
            <table>
                <tr style="background: #BBDEFB; color: #000">
                    <td>Time</td>
                    <td>DV</td>
                    <td>CK</td>
                    <td>yc/số</td>
                    <td>D.Số</td>
                    <td>L.Cứng</td>
                    <td>Cầm về</td>
                    <!-- <td>Tổng</td> -->
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td>
                        @php
                            $khachSo = 0; 
                            $khachQuen = 0;
                            $billList = App\Helper\ClassHelper::groupByBillId($today, $employeeId);
                        @endphp
                        @foreach ($billList as $billId => $billDetail)
                            @if (\App\Helper\ClassHelper::countCustomer($billId) == 1)
                                @php $khachQuen++; @endphp
                            @elseif (\App\Helper\ClassHelper::countCustomer($billId) == 0 && \App\Helper\ClassHelper::checkBillFinish($billId) == 1)
                                @php $khachSo++; @endphp
                            @endif
                        @endforeach
                        {{ $khachQuen }} / {{ $khachSo }}
                    </td>
                    <td style="text-align: right; font-weight: bold;" class="revenue"></td>
                    <td style="text-align: right; font-weight: bold;">
                        {{ number_format($luongCung) }}<sup>đ</sup>
                    </td>
                    <td style="text-align: right; font-weight: bold;" class="tong"></td>
                </tr>
                @php 
                    $tong = 0; 
                    $revenue = 0;
                @endphp
                @if ($salaryToday->count() > 0)
                    @foreach ($salaryToday as $salary)
                        @if ($salary->billDetail->bill->status == config('config.order.status.check-out'))
                            <tr>
                                <td style="color: #727272; font-size: 13px">
                                    {{ date('d/m', strtotime($salary->date)) }}<br>năm
                                    {{ date('Y', strtotime($salary->date)) }}
                                </td>
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
                                <td></td>
                                <td style="text-align: right;">
                                    {{ number_format($salary->billDetail->money) }}<sup>đ</sup>
                                    @php
                                        $revenue = $revenue + $salary->billDetail->money;
                                    @endphp
                                </td>
                                <td></td>
                                <td style="text-align: right;">
                                    {{ number_format($salary->percent/100 * $salary->billDetail->money) }}<sup>đ</sup>
                                </td>
                                
                                @php
                                    $tong = $tong + ($salary->percent/100 * $salary->billDetail->money);
                                @endphp
                            </tr>
                        @endif
                    @endforeach
                    
                @else
                    <tr>
                        <td colspan="7" style="text-align: center;">
                            <i>Bạn không phục vụ khách nào</i>
                        </td>
                    </tr>
                @endif
                    <tr style="display: none;">
                        <td colspan="3"></td>
                        <td></td>
                        <td id="revenue">
                            {{ number_format($revenue) }}<sup>đ</sup>
                        </td>
                        <td id="salary">{{ number_format($luongCung) }}<sup>đ</sup></td>
                        <td id="tong">{{ number_format($tong + $luongCung) }}<sup>đ</sup></td>
                    </tr>
            </table>
        </div>
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
            {{ str_replace(',', '.', number_format($total + $luongCung)) }}<sup>đ</sup>
        </h3>
        <br>
        <h6 style="margin-bottom: 0px; background: #eee; padding: 10px 0px; font-weight: bold;">CHIẾT KHẤU DỊCH VỤ</h6>
        <div class="row" style="overflow-x: auto;">
            <table>
                <tr style="background: #BBDEFB; color: #000">
                    <td>Time</td>
                    <td>DV</td>
                    <td>CK</td>
                    <td>yc/số</td>
                    <td>D.Số</td>
                    <td>L.Cứng</td>
                    <td>Cầm về</td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td>
                        @php
                            $khachSo = 0; 
                            $khachQuen = 0;
                            $billList = App\Helper\ClassHelper::groupByBillId($yesterday, $employeeId);
                        @endphp
                        @foreach ($billList as $billId => $billDetail)
                            @if (\App\Helper\ClassHelper::countCustomer($billId) == 1)
                                @php $khachQuen++; @endphp
                            @elseif (\App\Helper\ClassHelper::countCustomer($billId) == 0 && \App\Helper\ClassHelper::checkBillFinish($billId) == 1)
                                @php $khachSo++; @endphp
                            @endif
                        @endforeach
                        {{ $khachQuen }} / {{ $khachSo }}
                    </td>
                    <td style="text-align: right; font-weight: bold;" class="revenue-yesterday"></td>
                    <td style="text-align: right; font-weight: bold;">
                        {{ number_format($luongCung) }}<sup>đ</sup>
                    </td>
                    <td style="text-align: right; font-weight: bold;" class="total-yesterday"></td>
                </tr>
            @php 
                $tong = 0; 
                $revenueYesterday = 0;
            @endphp
            @if ($salaryYesterday->count() > 0)
                @foreach ($salaryYesterday as $salary)
                    @if ($salary->billDetail->bill->status == config('config.order.status.check-out'))
                        <tr>
                            <td>
                                {{ date('d/m', strtotime($salary->date)) }}<br>năm
                                {{ date('Y', strtotime($salary->date)) }}
                            </td>
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
                            <td></td>
                            <td style="text-align: right;">
                                {{ number_format($salary->billDetail->money) }}<sup>đ</sup>
                                @php
                                    $revenueYesterday = $revenueYesterday + $salary->billDetail->money;
                                @endphp
                            </td>
                            <td></td>
                            <td style="text-align: right;">
                                {{ number_format($salary->percent/100 * $salary->billDetail->money) }}<sup>đ</sup>
                            </td>
                            @php
                                $tong = $tong + ($salary->percent/100 * $salary->billDetail->money);
                            @endphp
                        </tr>
                    @endif
                @endforeach
                    
                @else
                    <tr>
                        <td colspan="7" style="text-align: center;">
                            <i>Bạn không phục vụ khách nào</i>
                        </td>
                    </tr>
                @endif
                    <tr style="display: none;">
                        <td colspan="3"></td>
                        <td></td>
                        <td id="revenue-yesterday" style="text-align: right; font-weight: bold;">
                            {{ $revenueYesterday }}<sup>đ</sup>
                        </td>
                        <td style="text-align: right; font-weight: bold;">
                            {{ number_format($luongCung) }}<sup>đ</sup>
                        </td>
                        <td id="total-yesterday">{{ number_format($tong + $luongCung) }}<sup>đ</sup></td>
                    </tr>
            </table>
        </div>
    </div>
    
<!-- end -->

<!-- Lương tháng này -->
    <div class="col-12 tab" id="month" style="text-align: center; padding: 15px 5px; display: none;">
        <h5>Tổng lương thực nhận</h5>
        <h3 style="font-weight: bold;">
            @php 
                $total = 0;
                $luongCungThang = auth('employees')->user()->salary; 
            @endphp
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
        <div class="row" style="overflow-x: auto;">
            <table>
                <tr style="background: #BBDEFB; color: #000">
                    <td>Time</td>
                    <td>DV</td>
                    <td>CK</td>
                    <td>yc/số</td>
                    <td>D.Số</td>
                    <td>L.Cứng</td>
                    <td>Cầm về</td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td>
                        @php
                            $khachSo = 0; 
                            $khachQuen = 0;
                            $billList = App\Helper\ClassHelper::groupByBillId($month, $employeeId);
                        @endphp
                        @foreach ($billList as $billId => $billDetail)
                            @if (\App\Helper\ClassHelper::countCustomer($billId) == 1 && \App\Helper\ClassHelper::checkBillFinish($billId) == 1)
                                @php $khachQuen++; @endphp
                            @elseif(\App\Helper\ClassHelper::countCustomer($billId) == 0 && \App\Helper\ClassHelper::checkBillFinish($billId) == 1)
                                @php $khachSo++; @endphp
                            @endif
                        @endforeach
                        {{ $khachQuen }} / {{ $khachSo }}
                    </td>
                    <td style="text-align: right; font-weight: bold;" class="revenue-month"></td>
                    <td style="text-align: right; font-weight: bold;">
                        {{ number_format(auth('employees')->user()->salary) }}<sup>đ</sup>
                    </td>
                    <td style="text-align: right; font-weight: bold;" class="total-month"></td>
                </tr>
                @php 
                    $tong = 0;
                    $revenueMonth = 0; 
                @endphp
                @if ($salaryMonth->count() > 0)
                    @foreach ($salaryMonth as $salary)
                        @if ($salary->billDetail->bill->status == config('config.order.status.check-out'))
                            <tr>
                                <td>
                                    {{ date('d/m', strtotime($salary->date)) }}<br>năm
                                    {{ date('Y', strtotime($salary->date)) }}
                                </td>
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
                                    
                                </td>
                                <td style="text-align: right;">
                                    {{ number_format($salary->billDetail->money) }}<sup>đ</sup>
                                    @php
                                        $revenueMonth = $revenueMonth + $salary->billDetail->money;
                                    @endphp
                                </td>
                                <td></td>
                                <td style="text-align: right;">
                                    {{ number_format($salary->percent/100 * $salary->billDetail->money) }}<sup>đ</sup>
                                </td>
                                @php
                                    $tong = $tong + ($salary->percent/100 * $salary->billDetail->money);
                                @endphp
                            </tr>
                        @endif
                    @endforeach
                    
                @else
                    <tr>
                        <td colspan="4">
                            <i>Bạn không phục vụ khách nào</i>
                        </td>
                        
                    </tr>
                @endif
                <tr style="display: none;">
                    <td colspan="3"></td>
                    <td>
                        
                    </td>
                    <td id="revenue-month">
                        {{ number_format($revenueMonth) }}<sup>đ</sup>
                    </td>
                    <td></td>
                    <td id="total-month">{{ number_format($tong + $luongCungThang) }}<sup>đ</sup></td>
                </tr>
            </table>
        </div>
    </div>
<!-- end -->

<!-- Lương tháng trước -->
    <div class="col-12 tab" id="last-month" style="text-align: center; padding: 15px 5px; display: none;">
        <h5>Tổng lương thực nhận</h5>
        <h3 style="font-weight: bold;">
            @php 
                $total = 0; 
                $revenueLastMonth = 0;
            @endphp
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
                <td>Time</td>
                <td>DV</td>
                <td>CK</td>
                <td>yc/số</td>
                <td>D.Số</td>
                <td>L.Cứng</td>
                <td>Cầm về</td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td>
                    @php
                        $khachSo = 0; 
                        $khachQuen = 0;
                        $billList = App\Helper\ClassHelper::groupByBillId($lastMonth, $employeeId);
                    @endphp
                    @foreach ($billList as $billId => $billDetail)
                        @if (\App\Helper\ClassHelper::countCustomer($billId) == 1 && \App\Helper\ClassHelper::checkBillFinish($billId) == 1)
                            @php $khachQuen++; @endphp
                        @elseif(\App\Helper\ClassHelper::countCustomer($billId) == 0 && \App\Helper\ClassHelper::checkBillFinish($billId) == 1)
                            @php $khachSo++; @endphp
                        @endif
                    @endforeach
                    {{ $khachQuen }} / {{ $khachSo }}
                </td>
                <td class="revenue-last-month" style="font-weight: bold; text-align: right;"></td>
                <td style="text-align: right; font-weight: bold;">
                    {{ number_format(auth('employees')->user()->salary) }}<sup>đ</sup>
                </td>
                <td style="text-align: right; font-weight: bold;" class="total-last-month"></td>
            </tr>
            @php 
                $tong = 0; 
                $luongCungThangTruoc = auth('employees')->user()->salary;
            @endphp
            @if ($salaryLastMonth->count() > 0)
                @foreach ($salaryLastMonth as $salary)
                    @if ($salary->billDetail->bill->status == config('config.order.status.check-out'))
                        <tr>
                            <td>
                                {{ date('d/m', strtotime($salary->date)) }}<br>năm
                                    {{ date('Y', strtotime($salary->date)) }}
                            </td>
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
                            <td></td>
                            <td>
                                {{ number_format($salary->billDetail->money) }}<sup>đ</sup>
                                @php
                                    $revenueLastMonth = $revenueLastMonth + $salary->billDetail->money;
                                @endphp
                            </td>
                            <td></td>
                            <td style="text-align: right;">
                                {{ number_format($salary->percent/100 * $salary->billDetail->money) }}<sup>đ</sup>
                            </td>
                        </tr>
                        @php
                            $tong = $tong + ($salary->percent/100 * $salary->billDetail->money);
                        @endphp
                    @endif
                @endforeach
            @else
                <tr>
                    <td colspan="7" style="text-align: center;">
                        <i>Bạn không phục vụ khách nào</i>
                    </td>
                </tr>
            @endif
                <tr>
                    <td colspan="3"></td>
                    <td></td>
                    <td id="revenue-last-month">
                        {{ number_format($revenueLastMonth) }}<sup>đ</sup>
                    </td>
                    <td>
                    </td>
                    <td id="total-last-month">{{ number_format($tong + $luongCungThangTruoc) }}<sup>đ</sup></td>
                </tr>
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
</div>
@endsection
