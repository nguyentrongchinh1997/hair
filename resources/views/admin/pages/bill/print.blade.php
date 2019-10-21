<div class="bill">

	<p>Ngày: {{ date('d/m/Y', strtotime($bill->date)) }}</p>
	<p>
		KH: {{ $bill->order->customer->full_name }}
	</p>
	<p>
		SĐT: {{ $bill->order->customer->phone }}
	</p>
	<p>
		Giờ book: {{ $bill->order->time->time }}
	</p>

	<table>
		<tr style="background: #BBDEFB">
            <th>Dịch vụ</th>
            <!-- <th>Thợ</th> -->
            <th>Giá</th>
            <!-- <th>Ghi chú</th> -->
        </tr>
        @php $totalPrice = 0 @endphp
        @foreach ($bill->billDetail as $service)
            <tr>
                <td>
                    @if ($service->service_id != '') 
                        {{ $service->service->name }}
                    @else
                        {{ $service->other_service }}
                    @endif
                </td>
                <td style="text-align: right;">
                    {{ number_format($service->money) }}<sup>đ</sup>
                </td>                
            </tr>
            @if ($service->card_id != '')
                <tr>
                    <td>
                        Áp dụng thẻ {{ $service->card->card_name }}
                    </td>
                    <td style="text-align: right;">
                        {{ number_format(($service->money - $service->sale_money) * -1) }}<sup>đ</sup>
                    </td>
                </tr>
            @endif
            @php $totalPrice = $totalPrice + $service->sale_money @endphp
        @endforeach
        <tr>
            <td style="text-align: right; font-size: 20px; font-weight: bold;" colspan="2">
                Tổng: {{ number_format($totalPrice) }}<sup>đ</sup>
            </td>
        </tr>
	</table>
</div>
<style type="text/css">
	.bill{
		max-width: 300px;
		margin: auto;
		height: auto;
	}
	table{

		border-collapse: collapse;
		width: 100%;
	}
	table tr td, table tr th{
        padding: 10px;
		border: 1px solid #e5e5e5;
	}
</style>