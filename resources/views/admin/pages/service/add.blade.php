@extends('admin.layouts.index')

@section('content')
<div class="row employee-add" style="padding-left: 40px; padding-top: 40px">
	<div class="col-lg-6">
		<h3>Thêm dịch vụ</h3>
		@if (count($errors)>0)
	        <div class="alert alert-danger">
	            @foreach($errors->all() as $err)
	                {{ $err }}<br>
	            @endforeach    
	        </div>
	    @endif
	    @if (session('thongbao'))
	        <div class="alert alert-success">
	            {{ session('thongbao') }}
	        </div>
	    @endif
		<form method="post" action="{{ route('service.add') }}">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<table>
				<tr>
					<td>
						Tên dịch vụ
					</td>
					<td>
						:
					</td>
					<td>
						<input type="text" class="form-control" required="required" value="{{ old('name') }}" name="name">
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
						<input type="text" id="formattedNumberField" class="form-control" required="required" name="price">
					</td>
				</tr>
				
				<tr>
					<td></td>
					<td></td>
					<td>
						<input class="btn btn-primary" value="Thêm" type="submit" name="">
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
@endsection