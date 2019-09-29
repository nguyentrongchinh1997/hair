@extends('admin.layouts.index')

@section('content')
	<div class="row" style="padding-left: 40px; padding-top: 40px; margin-top: 20px">
		<div class="col-lg-4">
			@if (session('thongbao'))
                <div class="alert alert-success">
                    {{ session('thongbao') }}
                </div>
            @endif
			<table class="list-table">
				<tr style="background: #BBDEFB">
					<th>Tên</th>
					<th style="text-align: center;">Sửa</th>
				</tr>
				@foreach ($rateList as $rate)
					<form method="post" action="{{ route('rate.post', ['id' => $rate->id]) }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<tr>
							<td style="width: 50%">
								<input type="text" value="{{ $rate->name }}" name="name" class="form-control input-control">
							</td>
							<td style="text-align: center;">
								<input class="btn btn-primary input-control" value="Sửa" type="submit" name="">
							</td>
						</tr>
					</form>
				@endforeach
			</table>
			
		</div>
	</div>
@endsection
