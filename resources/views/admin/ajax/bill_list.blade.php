@php $stt = 0; @endphp
@foreach ($customer as $customer)
    @foreach ($customer->bill as $bill)
        <tr>        
            <td>{{ ++$stt }}</td>  
            <td>
                {{ 
                    ($bill->customer->full_name == '') ? 'Chưa điền thông tin' : $bill->customer->full_name 
                }}
            </td>              
            <td>
                {{ $bill->customer->phone }}
            </td>
            <td style="text-align: right;">
                {{ number_format($bill->price) }}<sup>đ</sup>
            </td>
            <td style="text-align: right;">
                {{ number_format($bill->total) }}<sup>đ</sup>
            </td>
            <td>
                {{ ($bill->rate == '') ? 'chưa có đánh giá' : $bill->rate }}
            </td>
            <td>
                {{ $bill->sale }}
            </td>
            <td>
                {{ ($bill->rate == '') ? '' : $bill->sale_detail }}
            </td>
            <td>
                {{ ($bill->rate == '') ? 'chưa có' : $bill->comment }}
            </td>
            <td>
                @if ($bill->status == config('config.order.status.check-in'))
                    <span>Chưa thanh toán</span>
                @else
                    <span>Đã thanh toán</span>
                @endif
            </td>
        </tr>
    @endforeach
@endforeach
 
