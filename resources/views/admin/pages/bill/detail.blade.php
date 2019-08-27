<h2 style="text-align: center;">
    THANH TOÁN
    <input type="hidden" id="bill_id" value="{{ $bill->id }}" class="id-order" name="">
    <input type="hidden" id="employee_id" value="{{ $bill->order->employee_id }}" class="customer-id">
    <input type="hidden" id="price_total" value="{{ $moneyServiceTotal }}" name="">
</h2>

<div class="row">
	<div class="col-lg-12">
		<script>
			function click1(id)
			{
				if ($('#h').is(':checked')){
					// $(".change").attr("disabled", true);	
					$('.fee').show();
				} else {
					$('#price-fee').val(0);
					$('.fee').hide();
					// $(".change").attr("disabled", false);	
				}
				if (id != -1) {
					if ($('.service' + id).is(':checked')) {
						var price = $('.service' + id).attr('data');
						total = parseInt($('#total').val()) + parseInt(price);
						$('#total').val(total);
						$('#tong-test').html(total);
						$('#service' + id).show();
						$('#hidden' + id).val($('.service' + id).val());
					} else {
						var price = $('.service' + id).attr('data');
						total = parseInt($('#total').val()) - parseInt(price);
						$('#total').val(total);
						$('#tong-test').html(total);
						$('#service' + id).hide();
						$('#hidden' + id).val(0);
					}
				}
			}
		</script>
	<table style="width: 100%">
		<tr>
			<td style="width: 30%">
				Tên khách hàng
			</td>
			<td style="width: 2%">
				:
			</td>
			<td>
				{{ $bill->customer->full_name }}
			</td>
		</tr>
		<tr>
			<td>So du</td>
			<td>:</td>
			<td>
				{{ number_format($bill->customer->balance) }}
				<input type="hidden" value="{{ $bill->customer->balance }}" id="balance" name="">
			</td>
		</tr>
		<tr>
			<td>
				Dịch vụ
			</td>
			<td>:</td>
			<td>
				{{ $bill->order->service->name }}
			</td>
		</tr>
		<tr>
			<td>
				Giá 
			</td>
			<td>
				:
			</td>
			<td>
				{{ number_format($moneyServiceTotal) }}<sup>đ</sup>
			</td>
		</tr>
		@foreach ($serviceList as $service)
			<tr class="service-fee" id="service{{$service->id}}">
				<td>
					{{ $service->name }}
				</td>
				<td>:</td>
				<td>
					{{ number_format($service->price) }}<sup>d</sup>
					<input type="hidden" id="hidden{{ $service->id }}" value="0" name="">
				</td>
			</tr>
		@endforeach
		<tr class="fee" style="display: none;">
			<td>Phát sinh</td>
			<td>:</td>
			<td>
				<input type="text" id="price-fee" value="0" placeholder="Số tiền phát sinh (nếu có)..." class="number form-control">
			</td>
			<td>
				<input class="form-control" type="text" placeholder="Tên dịch vụ phát sinh..." name="">
			</td>
		</tr>
		
		<tr>
			<td>
				Giam gia (%)
			</td>
			<td>:</td>
			<td>
				<input type="number" value="0"  id="sale" class="form-control" name="">
			</td>
			<td>
				<input type="text" class="form-control" placeholder="Noi dung giam gia" name="">
			</td>
		</tr>
		<tr>
			<td>
				Dịch vụ phát sinh
			</td>
			<td>
				:
			</td>
			<td>
				@foreach ($serviceList as $service)
				<label>
					<input style="margin-left: 10px" data="{{ $service->price }}" class="change service{{ $service->id }}" value="{{ $service->id }}" type="checkbox" onclick="click1({{ $service->id }})" name="service[]">
					<span>{{ $service->name }}</span>
				</label>
				
			@endforeach
			<label>
				<input style="margin-left: 15px" onclick="click1(-1)" id="h" value="-1" type="checkbox" name="service"><span>Khác</span>
			</label>
			</td>
		</tr>
	</table>
</div>
<div class="col-lg-12">
	<table id="list-service">
		<tr>
			<td>STT</td>
			<td>Dich vu</td>
			<td>Gia</td>
		</tr>
		<tr>
			<td>
				1
			</td>
			<td>
				{{ $bill->order->service->name }}
			</td>
			<td>
				{{ number_format($bill->order->service->price) }}
			</td>
		</tr>
	</table>
</div>
<div class="row" style="display: none;">
	<table>
		<tr>
			<td>Tong</td>
			<td>:</td>
			<td>
				<input type="text" id="total" value="{{ $moneyServiceTotal }}" name="">
				<span id="tong-test"></span>
			</td>
		</tr>
	</table>
</div>
<div class="col-lg-12">
	<script type="text/javascript">
		function addCommas(nStr)
		{
		    nStr += '';
		    x = nStr.split('.');
		    x1 = x[0];
		    x2 = x.length > 1 ? '.' + x[1] : '';
		    var rgx = /(\d+)(\d{3})/;
		    while (rgx.test(x1)) {
		        x1 = x1.replace(rgx, '$1' + ',' + '$2');
		    }
		    return x1 + x2;
		}
		$('.finally').click(function(){
			var tong = parseInt($('#total').val()) + parseInt($('#price-fee').val());
			var sale = $('#sale').val();
			var tong2 = parseInt(tong) - parseInt(tong * (sale/100)) - parseInt($('#balance').val());
			// var tong2 = tong - parseFloat($('#balance').val());

			$('#result').html(addCommas(tong2));
		})
	</script>
	<center>
		<button class="finally btn btn-primary">Total</button>
	</center>
</div>
<div class="col-lg-12">
	<center>
		<h2>Can thanh toan: <span id="result"></span></h2>
	</center>
</div>

<div id="tong" class="row">
	
</div>
