<tr style="background: #fcf8e3; font-weight: bold;">
    <td class="tong" style="text-align: right; font-size: 20px" colspan="4">

    </td>
</tr>
@php $stt = 0; $total = 0;@endphp
@if ($customer->count() > 0)
    @foreach ($customer as $customer)
        @foreach ($customer->bill as $bill)
            <tr style="cursor: pointer;" value="{{ $bill->id }}" class="list-bill" id="bill{{ $bill->id }}" value="{{ $bill->id }}" class="list-bill" id="bill{{ $bill->id }}"> 
                <td>{{ $bill->id }}</td>  
                <td>
                    <span style="font-weight: bold;">
                        {{ ($bill->customer->full_name == '') ? 'chưa có tên' : $bill->customer->full_name }}
                    </span><br>
                    {{ substr($bill->customer->phone, 0, 4) }}.{{ substr($bill->customer->phone, 4, 3) }}.{{ substr($bill->customer->phone, 7) }}
                </td>
                <td>
                    @if ($bill->status == config('config.order.status.check-in'))
                        <span style="color: red">Chưa thanh toán</span>
                    @else
                        <span style="color: green">Đã thanh toán</span>
                    @endif
                </td>
                <td style="text-align: right; font-weight: bold;">
                    @php $tong = 0; @endphp
                    @foreach ($bill->billDetail as $servicePrice)
                        @php 
                            $tong = $tong + $servicePrice->sale_money; 
                        @endphp
                    @endforeach
                    @php 
                        $total = $total + $tong - $bill->sale;
                    @endphp
                    {{ number_format($tong) }}<sup>đ</sup>
                </td>
            </tr>
        @endforeach
    @endforeach
    <tr style="display: none;">
        <td style="text-align: right; font-size: 20px" colspan="4">
            Tổng
        </td>
        <td id="tong" style="text-align: right; font-size: 20px; font-weight: bold;">
            {{ number_format($total) }}<sup>đ</sup>
        </td>
    </tr>
@else
    <tr>
        <td colspan="6">
            <center>
                <i>Không có hóa đơn nào</i>
            </center>
        </td>
    </tr>
    <tr style="display: none;">
        <td style="text-align: right; font-size: 20px" colspan="4">
            Tổng
        </td>
        <td id="tong" style="text-align: right; font-size: 20px; font-weight: bold;">
            0<sup>đ</sup>
        </td>
    </tr>
@endif
<script type="text/javascript">
    $(document).ready(function(){
        $('.list-bill').click(function() {
            $('.list-bill').removeClass('active');
            $(this).addClass('active');
            var billId = $(this).attr('value');
            if (billId != '') {
                $.get('admin/hoa-don/chi-tiet/' + billId, function(data){
                  $('.right').html(data);
              });
            }
        });
        $('.tong').html($('#tong').html());
    })
</script>