<div class="col-lg-12" style="border: 1px solid #e5e5e5">
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
						<button type="button" class="btn btn-primary" style="float: right" data-toggle="modal" data-target="#myModal">
                    NẠP TIỀN
                </button>
					</td>
				</tr>
			</table>
		</div>
	</div><hr>
	<div class="row">
		<div class="col-lg-12">
			<h3>Lịch sử</h3>
			<table class="history-customer" style="width: 100%">
				<tr>
					<th>Ngày đến</th>
					<th>Giờ đặt</th>
					<th>Dịch vụ + thợ</th>
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
								<p>
									» {{ $service->service->name }} + {{ $service->employee->full_name }}
								</p>
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
          <h4 class="modal-title">NẠP TIỀN</h4>
        	
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
            <form method="post" action="{{ route('recharge') }}">
                @csrf
                <table>
                	<tr>
                		<td>Khách hhàng</td>
                		<td>:</td>
                		<td>
                			<select name="customer_id" class="form-control">
                				<option value="{{ $customer->id }}">
                					{{ $customer->full_name }}
                				</option>
                			</select>
                		</td>
                	</tr>
                    <tr>
                        <td>
                            Số tiền
                        </td>
                        <td>
                            :
                        </td>
                        <td>
                            <input required="required" id="format" type="text" class="form-control" name="money">
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            <button class="btn btn-primary" type="submit">NẠP</button>
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