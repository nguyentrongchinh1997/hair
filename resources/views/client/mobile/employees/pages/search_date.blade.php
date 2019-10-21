<div class="col-12" style="text-align: center; padding: 30px 0px">
    <h5>Tổng lương thực nhận</h5>
    <h3 style="font-weight: bold;">
        @php $total = 0; @endphp

        @foreach ($salary as $s)
            @if ($s->billDetail->bill->status == config('config.order.status.check-out'))    
                @php 
                    $total = $total + $s->billDetail->money * $s->percent/100;
                @endphp
            @endif
        @endforeach
        {{ str_replace(',', '.', number_format($total + auth('employees')->user()->s)) }} Đ
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
            <td style="text-align: right; font-weight: bold; font-size: 18px" colspan="4" class="search-date"></td>
        </tr>
        @php $tong = 0; @endphp
        @if ($salary->count() > 0)
            @foreach ($salary as $salary)
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
                    @php $tong = $tong + ($salary->percent/100 * $salary->billDetail->money) @endphp
                @endif
            @endforeach
            <tr style="display: none;">
                <td id="search-date">
                    {{ number_format($tong) }}<sup>đ</sup>
                </td>
            </tr>
        @else
            <tr>
                <td colspan="4" style="text-align: center;">
                    <i>Bạn chưa phục vụ khách nào</i>
                </td>
                
            </tr>
        @endif
    </table>
</div>
<script type="text/javascript">
    $(function(){
        $('.search-date').html($('#search-date').html());
    })
</script>

