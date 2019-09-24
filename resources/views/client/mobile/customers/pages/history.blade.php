@extends('client.mobile.customers.layouts.index')

@section('content')
	<div class="row history">
		<div class="container" style="margin-top: 100px; padding: 0px;">
			<div class="col-12">
				<p>Những lần đến SALON</p>
				<ul>
					@foreach ($historyList as $history)
						<li>
							<p>
								<b>Ngày:</b> {{ date('d-m-Y', strtotime($history->order->date)) }}
							</p>
							<p>
								<b>Thời gian:</b> {{ $history->order->time->time }}
							</p>
							<p>
								<b>Đánh giá:</b> 
								@for ($i = 1; $i <= 3; $i++)
									@if ($i <= $history->rate_id)
										<img src="{{ asset('/image/star.png') }}" style="width: 16px; margin-top: -5px">
									@else
										<img src="{{ asset('/image/star-rate.png') }}" style="width: 16px; margin-top: -5px">
									@endif
								@endfor
							</p>
							<p>
								<b>Dịch vụ: </b>
								@foreach ($history->billDetail as $service)
									@if ($service->service_id != '')
										{{ $service->service->name }},
									@else
										{{ $service->other_service }},
									@endif
								@endforeach
							</p>
						</li>
					@endforeach
					<br><br>
				</ul>
			</div>
		</div>
	</div>
@endsection