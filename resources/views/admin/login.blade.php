@extends('admin.layouts.index')
@section('content')
<div class="row login" style="padding-left: 40px; padding-top: 40px">
	<div class="col-lg-6">
		<h3>Đăng nhập</h3>
		<!-- <input type="file" class="test" onchange="my()" name="">
		<script type="text/javascript">
			function my(){
				var x = $(".test").val();
				alert(x);
			}
		</script> -->
		@if (session('thongbao'))
            <div class="alert alert-danger">
                {{ session('thongbao') }}
            </div>
        @endif
		<form method="post" action="{{ route('login') }}">
		{{csrf_field()}}
			<table>
				<tr>
					<td>
						Tên đăng nhập
					</td>
					<td>
						:
					</td>
					<td>
						<input type="text" class="form-control" required="required" name="username">
					</td>
				</tr>
				<tr>
					<td>
						Mật khẩu
					</td>
					<td>
						:
					</td>
					<td>
						<input type="password" required="required" class="form-control" name="password">
					</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td>
						<input type="submit" class="btn btn-primary" value="Đăng nhập" name="">
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
@endsection