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
                            {{ date('H:i:s', strtotime($salary->created_at)) }}
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
