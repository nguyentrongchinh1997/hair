<div class="col-lg-12" style="border: 1px solid #e5e5e5; padding: 15px">
	<div class="row">
		<div class="col-lg-6">
			<table style="width: 100%">
				<tr>
					<td>Tên</td>
					<td>:</td>
					<td style="font-weight: bold;">
						{{ $customer->full_name }}
					</td>
				</tr>
				<tr>
					<td>Ngày sinh</td>
					<td>:</td>
					<td style="font-weight: bold;">
						{{ date('d/m/Y', strtotime($customer->birthday)) }}
					</td>
				</tr>
			</table>
		</div>
		<div class="col-lg-6">
			<table style="width: 100%">
				<tr>
					<td style="text-align: right;">Số dư</td>
					<td>:</td>
					<td style="text-align: right; font-weight: bold;">
						{{ number_format($customer->balance) }}<sup>đ</sup>
					</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td>
						<button type="button" class="btn btn-primary button-control" style="float: right" data-toggle="modal" data-target="#myModal">
                    Nạp tiền
                </button>
					</td>
				</tr>
			</table>
		</div>
	</div><hr>
	<div class="row">
		<div class="col-lg-12">
			<h3>Thẻ khách hàng</h3>
		</div>
		<div class="col-lg-12">
			<table class="list-table" style="width: 100%">
				<tr style="background: #BBDEFB">
					<th>STT</th>
					<th>Tên thẻ</th>
					<th>Loại thẻ</th>
					<th>Số lần còn (thời hạn hết hạn)</th>
					<th>
						Trang thái
					</th>
					<th>Giá thẻ</th>
				</tr>
			@if ($card->count() > 0)
				@php $stt = 0; @endphp
				@foreach ($card as $card)
					<tr>
						<th>{{ ++$stt }}</th>
						<td>
							{{ $card->card->card_name }}
						</td>
						<td>
							{{ ($card->card->type == 0 ? 'Thẻ hội viên' : 'Thẻ dịch vụ') }}
						</td>
						<td style="text-align: center;">
							@if ($card->card->type == 0)
								{{ date('d/m/Y', strtotime($card->end_time)) }}
							@else
								{{ $card->number }} lần
							@endif
						</td>
						<td>
							{!! ($card->status == 1 ? '<span style="color: #007bff; font-weight:bold;">Còn hạn</span>' : '<span style="color: red; font-weight:bold;">Còn hạn</span>Hết hạn</span>') !!}
						</td>
						<td style="text-align: right;">
							{{ number_format($card->card->price) }}<sup>đ</sup>
						</td>
					</tr>
				@endforeach
			@else
				<tr>
					<td style="text-align: center;" colspan="6">
						<i>
							Khách hàng chưa mua thẻ
						</i>
					</td>
				</tr>
			@endif
			</table>
		</div>
	</div><br>
	<div class="row">
		<div class="col-lg-12">
			<h3>Lịch sử</h3>
		</div>
		<div class="col-lg-12" style="height: 410px; overflow: auto;">
			<table class="list-table" style="width: 100%">
				<tr style="background: #BBDEFB">
					<th>Ngày đến</th>
					<th>Giờ đặt</th>
					<th>Dịch vụ(thợ)</th>
				</tr>
				@foreach ($customerHistory as $customerHistory)
					<tr>
						<td>
							{{ date('d/m/Y', strtotime($customerHistory->order->date)) }}
						</td>
						<td>
							{{ $customerHistory->order->time->time }}
						</td>
						<td>
							@foreach ($customerHistory->billDetail as $service)
								@if ($service->service_id !='')
									<p>
										@if ($service->assistant_id == '')
											{{ $service->service->name }} 
											<b>
												({{ $service->employee->full_name }})
											</b>
										@else
											{{ $service->service->name }} 
											<b>({{ $service->employee->full_name }}</b> và <b>
												{{ $service->employeeAssistant->full_name }})
											</b>
										@endif
									</p>
								@else
									<p>
										» {{ $service->other_service }} ({{ $service->employee->full_name }})
									</p>
								@endif
							@endforeach
						</td>
					</tr>
				@endforeach
			</table><br>
		</div>
	</div>
</div>
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h3 class="modal-title">Nạp tiền</h3>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
            <form method="post" action="{{ route('recharge') }}">
                @csrf
                <table class="list-table">
                	<tr>
                		<td style="background: #fafafa">Khách hhàng</td>
                		<td>
                			<select name="customer_id" class="form-control input-control">
                				<option value="{{ $customer->id }}">
                					{{ $customer->full_name }}
                				</option>
                			</select>
                		</td>
                	</tr>
                    <tr>
                        <td style="background: #fafafa">
                            Số tiền
                        </td>
                        <td>
                            <input required="required" id="format" type="text" class="form-control input-control" name="money">
                        </td>
                    </tr>
                    <tr>
                        <td style="background: #fafafa"></td>
                        <td>
                            <button class="btn btn-primary button-control" type="submit">Nạp</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
</div>
<script type="text/javascript">
	$('#format').keyup(function(event) {
      // skip for arrow keys
      if(event.which >= 37 && event.which <= 40) return;
      // format number
      $(this).val(function(index, value) {
        return value
        .replace(/\D/g, "")
        .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        ;
      });
    });
</script>
