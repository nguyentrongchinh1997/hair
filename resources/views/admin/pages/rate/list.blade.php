@extends('admin.layouts.index')

@section('content')
	<div class="row" style="padding-left: 40px; margin-top: 20px">
		<div class="col-lg-6">
			<h2>QUẢN LÝ ĐÁNH GIÁ</h2>
			@if (session('thongbao'))
                <div class="alert alert-success">
                    {{ session('thongbao') }}
                </div>
            @endif
			<table class="rate">
				<tr>
					<td>Tên</td>
					<td>
						Phần trăm
					</td>
					<td>
						Ghi chú
					</td>
					<td>
						Sửa
					</td>
				</tr>
				@foreach ($rateList as $rate)
					<form method="post" action="{{ route('rate.post', ['id' => $rate->id]) }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<tr>
							<td>
								{{ $rate->name }}
							</td>
							<td>
								<input type="number" class="form-control" value="{{ $rate->percent }}" name="percent">
							</td>
							<td style="font-weight: bold;">
								@if ($rate->type == config('config.rate.type.substract'))
									<span>-{{ $rate->percent }}%</span>
								@else
									<span>+{{ $rate->percent }}%</span>
								@endif
							</td>
							<td>
								<input class="btn btn-primary" value="Sửa" type="submit" name="">
							</td>
						</tr>
					</form>
				@endforeach
			</table>
			
		</div>
	</div>
@endsection
