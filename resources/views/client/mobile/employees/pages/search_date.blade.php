<div class="col-12" style="text-align: center; padding: 30px 0px">
    <h5>Tổng lương thực nhận</h5>
    <h3 style="font-weight: bold;">
        @php 
            $total = 0; 
            $luongCung = (auth('employees')->user()->salary)/config('config.full') * $numberDays;
        @endphp

        @foreach ($salary as $s)
            @if ($s->billDetail->bill->status == config('config.order.status.check-out'))    
                @php 
                    $total = $total + $s->billDetail->money * $s->percent/100;
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
                        $billList = App\Helper\ClassHelper::groupByBillIdNumberDate($dateFromFormat, $dateToFormat, $employeeId);
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
                <td class="revenue-date" style="font-weight: bold; text-align: right;"></td>
                <td style="font-weight: bold; text-align: right;">
                    {{ number_format($luongCung) }}<sup>đ</sup>
                </td>
                <td style="text-align: right; font-weight: bold;" class="search-date"></td>
            </tr>
            @php 
                $tong = 0; 
                $revenue = 0;
            @endphp
            @if ($salary->count() > 0)
                @foreach ($salary as $salary)
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
                                    $revenue = $revenue + $salary->billDetail->money;
                                @endphp
                            </td>
                            <td></td>
                            <td style="text-align: right;">
                                    {{ number_format($salary->percent/100 * $salary->billDetail->money) }}<sup>đ</sup>
                            </td>
                        </tr>
                        @php $tong = $tong + ($salary->percent/100 * $salary->billDetail->money) @endphp
                    @endif
                @endforeach
                
            @else
                <tr>
                    <td colspan="7" style="text-align: center;">
                        <i>Bạn chưa phục vụ khách nào</i>
                    </td>
                </tr>
            @endif
                <tr>
                    <td colspan="3"></td>
                    <td></td>
                    <td id="revenue-date">
                        {{ number_format($revenue) }}<sup>đ</sup>
                    </td>
                    <td>
                        
                    </td>
                    <td id="search-date">
                        {{ number_format($tong + $luongCung) }}<sup>đ</sup>
                    </td>
                </tr>
        </table>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $('.search-date').html($('#search-date').html());
        $('.revenue-date').html($('#revenue-date').html());
    })
</script>

