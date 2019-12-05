<div class="row" style="border: 1px solid #e5e5e5;">
	<div class="col-lg-12" style="padding: 15px 30px">
		<h3 style="text-align: center;">
			Thông tin nhân viên
		</h3>
		<table>
			<tr>
				<td>
					Tên nhân viên
				</td>
				<td>:</td>
				<td>
					{{ $employee->full_name }}
				</td>
			</tr>
			<tr>
				<td>Địa chỉ</td>
				<td>:</td>
				<td>
					{{ $employee->address }}
				</td>
			</tr>
			<tr>
				<td>Lương cứng</td>
				<td>:</td>
				<td style="font-weight: bold; font-size: 30px; color: #007bff">
					{{ number_format($employee->salary) }}<sup>đ</sup>
				</td>
			</tr>
		</table><hr>
		<h3 style="text-align: center; margin-bottom: 20px">
			Thống kê khách<br> (
				<span style="color: #007bff">
					@if ($type == 'month')
						{{ date('m/Y', strtotime($date)) }}
					@else
						<span style="color: #000">từ</span> {{ explode('-', $date)[0] }}<span style="color: #000"> đến </span>{{ explode('-', $date)[1] }}
					@endif
				</span>)
		</h3>
		<table class="list-table">
			<tr style="background: #BBDEFB">
				<th style="text-align: center;">Khách số</th>
				<th style="text-align: center;">Khách quen</th>
			</tr>
			<tr>
				<td style="text-align: center;">
					@php 
						$khachSo = 0; $khachQuen = 0;
					@endphp
					@foreach ($billId as $id => $billDetail)
						@if (\App\Helper\ClassHelper::countCustomer($id) == 1 && \App\Helper\ClassHelper::checkBillFinish($id) == 1)
							@php $khachQuen++; @endphp
						@elseif (\App\Helper\ClassHelper::countCustomer($id) == 0 && \App\Helper\ClassHelper::checkBillFinish($id) == 1)
							@php $khachSo++; @endphp
						@endif
					@endforeach
					{{ $khachSo }}
				</td>
				<td style="text-align: center;">
					{{ $khachQuen }}
				</td>
			</tr>
		</table><br>
		<h3 style="text-align: center; margin-bottom: 20px">
			Đánh giá của khách<br> (
				<span style="color: #007bff">
					@if ($type == 'month')
						{{ date('m/Y', strtotime($date)) }}
					@else
						<span style="color: #000">từ</span> {{ explode('-', $date)[0] }}<span style="color: #000"> đến </span>{{ explode('-', $date)[1] }}
					@endif
				</span>)
		</h3>
		<table class="list-table">
			<tr style="background: #BBDEFB">
				<th style="text-align: center;">Tệ</th>
				<th style="text-align: center;">Được</th>
				<th style="text-align: center;">Rất hài lòng</th>
				
			</tr>
			<tr>
				<td style="text-align: center;">
					{{ $rate1 }}
				</td>
				<td style="text-align: center;">
					{{ $rate2 }}
				</td>
				<td style="text-align: center;">
					{{ $rate3 }}
				</td>
			</tr>
		</table><br>
		<h3 style="text-align: center; margin-bottom: 20px">
			Chi tiết hoa hồng<br> (
				<span style="color: #007bff">
					@if ($type == 'month')
						{{ date('m/Y', strtotime($date)) }}
					@else
						<span style="color: #000">từ</span> {{ explode('-', $date)[0] }}<span style="color: #000"> đến </span>{{ explode('-', $date)[1] }}
					@endif
				</span>)
		</h3>
		<div class="row" style="height: 400px; overflow: auto;">
		<table class="list-table">
			<tr style="background: #BBDEFB">
				<th>STT</th>
				<th>Dịch vụ</th>
				<th>Giá</th>
				<th>Chiết khấu (%)</th>
				<th>Thời gian</th>
				<th>Hoa hồng (vnđ)</th>
			</tr>
			@php $stt = 0; $total = 0; @endphp
			@foreach ($commisionList as $commision)
				@if ($commision->billDetail->bill->status == config('config.order.status.check-out'))
					<tr>
						<td>
							{{ ++$stt }}
						</td>
						<td>
							@if ($commision->billDetail->service_id == '')
								{{ $commision->billDetail->other_service }}
							@else
								{{ $commision->billDetail->service->name }}
							@endif
						</td>
						<td style="text-align: right;">
							{{ number_format($commision->billDetail->money) }}<sup>đ</sup>
						</td>
						<td style="text-align: center;">
							{{ $commision->percent }}%
						</td>
						<td>
							{{ date('d/m/Y', strtotime($commision->billDetail->date)) }}
						</td>
						<td style="text-align: right; font-size: 20px; font-weight: bold;">
							{{ number_format($commision->percent/100 * $commision->billDetail->money) }}<sup>đ</sup>
						</td>
						@php $total =  $total + $commision->percent/100 * $commision->billDetail->money @endphp
					</tr>
				@endif
			@endforeach
				<tr>
					<td colspan="5" style="text-align: right;">TỔNG</td>
					<td style="text-align: right; font-size: 20px; font-weight: bold; color: #007bff">
						{{ number_format($total) }}<sup>đ</sup>
					</td>
				</tr>
				<tr>
					<td colspan="5" style="text-align: right;">TỔNG LƯƠNG</td>
					<td style="text-align: right; font-size: 20px; font-weight: bold; color: #007bff">
						@if ($type == 'month')
							{{ number_format($total + $employee->salary) }}<sup>đ</sup>
						@else
							{{ number_format($total) }}<sup>đ</sup>
						@endif
					</td>
				</tr>
		</table>
		</div>
	</div>
</div>