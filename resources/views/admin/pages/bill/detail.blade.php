<h2 style="text-align: center;">
    THANH TOÁN
    <input type="hidden" id="bill_id" value="{{ $bill->id }}" class="id-order" name="">
    <input type="hidden" id="employee_id" value="{{ $bill->order->employee_id }}" class="customer-id">
    <input type="hidden" id="price_total" value="{{ $moneyServiceTotal }}" name="">
</h2>

<div class="row">
	<div class="col-lg-12">
		<script>
			// $('.change').click(function(event){
			// 	$('.change:checked').each(function(){
			// 		if ($(this).val() == -1) {
			// 			$('.fee').show();
			// 			$(".change").attr("disabled", true);
			// 			$(this).attr("disabled", false);
			// 		}
			// 	})
			// 	// event.preventDefault();
			//  //    var searchIDs = $("input:checkbox:checked").map(function(){
			//  //        return this.value;
			//  //    }).toArray();
			//  //    if (searchIDs == -1) {
			//  //    	$('.fee').show();
			//  //    }
			//     // alert(searchIDs);
			// });
			function click1(id)
			{
				if ($('#h').is(':checked')){
					$(".change").attr("disabled", true);	
				} else {
					$(".change").attr("disabled", false);	
				}
				if ($('.change').is(':checked')) {
					$('#h').attr("disabled", true);
				} else {
					$('#h').attr("disabled", false);
				}
				// if (id == -1) {
				// 	$(".change").attr("disabled", true);					
				// } else {
				// 	var t = $('.change').is(':checked'); 
				// 	if (t){
				// 		$('#h').attr("disabled", true);
				// 	} else {
				// 		$('#h').attr("disabled", false);
				// 	}
				// }
			}
			$('input.number').keyup(function(event) {
				var price_total = $('#price_total').val();
				if(event.which >= 37 && event.which <= 40) return;
				  // format number
				$(this).val(function(index, value) {
					if (value != '') {
						// value = 0;
							$.get('admin/hoa-don/tong/' + value + '/' + price_total, function(data){
							$('#tong').html(data);
							$('#tong').show();
						})
					} else {
						$('#tong').hide();
					}
					
					return value
					.replace(/\D/g, "")
				    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
				    ;

				});
			});
			
		</script>
		<script>
			$('.finish').click(function(){
				var bill_id = $('#bill_id').val();
				var employee_id = $('#employee_id').val();
				var price_total = $('#price_total').val();
				var number = $('.number').val();
				if (number == '') {
					number = 0;
				}
				$.get('admin/hoa-don/them/' + bill_id + '/' + employee_id + '/' + price_total + '/' + number, function(data){
					$('#finish').html(data);
				})
			});
		</script>
	<table style="width: 100%">
		<tr>
			<td>
				Tên khách hàng
			</td>
			<td>
				:
			</td>
			<td>
				{{ $bill->customer->full_name }}
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
		<tr class="fee" style="display: none;">
			<td>Phát sinh</td>
			<td>:</td>
			<td>
				<input type="text" placeholder="Số tiền phát sinh (nếu có)..." class="number form-control">
			</td>
			<td>
				<input class="form-control" type="text" placeholder="Tên dịch vụ phát sinh..." name="">
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
					<input class="change" style="width: 50%" value="{{ $service->id }}" type="checkbox" onclick="click1({{ $service->id }})" name="service">{{ $service->name }}
				@endforeach
				<input onclick="click1(-1)" style="width: 50%" id="h" value="-1" type="checkbox" name="service">Khác
				<!-- <select class="change form-control">
					<option>Chọn dịch vụ (nếu có)</option>
					@foreach ($serviceList as $service)
						<option value="{{ $service->id }}">
							{{ $service->name }}
						</option>
					@endforeach
					<option data='-1' value="-1">Khác</option>

				</select> -->
			</td>
		</tr>
	</table>
	
</div>
<div id="tong" class="row">
	
</div>
<!-- <div class="row">
	<div class="col-lg-3"></div>
	<div class="col-lg-1"></div>
	<div class="col-lg-8" id="finish">
		<a class="finish btn btn-primary" style="cursor: pointer; color: #fff">HOÀN TẤT</a>
	</div>
</div> -->