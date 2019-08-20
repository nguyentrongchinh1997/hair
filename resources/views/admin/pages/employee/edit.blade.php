@extends('admin.layouts.index')

@section('content')
<div class="row employee-add" style="padding-left: 40px; padding-top: 40px">
	<div class="col-lg-6">
		<h3>Sửa nhân viên</h3>
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
		<form method="post" action="{{ route('employee.edit', ['id' => $oldData->id]) }}">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<table>
				<tr>
					<td>
						Tên nhân viên
						<input type="hidden" value="{{ $oldData->id }}" name="id">
					</td>
					<td>
						:
					</td>
					<td>
						<input type="text" class="form-control" required="required" value="{{ $oldData->full_name }}" name="full_name">
					</td>
				</tr>
				<tr>
					<td>
						Số điện thoại
					</td>
					<td>
						:
					</td>
					<td>
						<input type="text" class="form-control" required="required" value="{{ $oldData->phone }}" name="phone">
					</td>
				</tr>
				<tr>
					<td>
						Loại nhân viên
					</td>
					<td>
						:
					</td>
					<td>
						<select name="type" class="form-control">
							<option @if ($oldData->type == config('config.employee.type.skinner')) {{ 'selected' }} @endif value="0">Gội</option>
							<option @if ($oldData->type == config('config.employee.type.stylist')) {{ 'selected' }} @endif value="1">Cắt</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						Địa chỉ
					</td>
					<td>
						:
					</td>
					<td>
						<input value="{{ $oldData->address }}" type="text" class="form-control" name="address">
					</td>
				</tr>
				<tr>
					<td>
						Hoa hồng 
					</td>
					<td>
						:
					</td>
					<td>
						<input type="number" value="{{ $oldData->percent }}" name="percent" class="form-control">
					</td>
				</tr>
				<tr>
					<td>
						Trạng thái
					</td>
					<td>:</td>
					<td>
						<select class="form-control" name="status">
							<option @if ($oldData->status == config('config.employee.status.doing')) {{ 'selected' }} @endif value="1">
								Đang làm
							</option>
							<option @if ($oldData->status == config('config.employee.status.leave')) {{ 'selected' }} @endif value="0">
								Nghỉ làm
							</option>
						</select>
					</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td>
						<input class="btn btn-primary" value="Sửa" type="submit" name="">
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
@endsection