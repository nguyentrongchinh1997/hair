<!DOCTYPE html>
<html>
	<head>
		<title>Đăng nhập Admin</title>
        <base href="{{ asset('/') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/font/fontawesome-free-5.10.0-web/css/all.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/admin/style.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/admin/choosen.css') }}">  
        <link rel="stylesheet" type="text/css" href="{{ asset('/js/datepicker/css/lightpick.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
	</head>
	<body>
		<div class="row login" style="padding-left: 40px; padding-top: 40px">
			<div style="max-width: 500px; margin: auto; box-shadow: 0 1px 6px 0 rgba(32,33,36,.28); padding: 15px">
				<h2 style="text-align: center;">Đăng nhập</h2><hr>
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

	</body>
</html>