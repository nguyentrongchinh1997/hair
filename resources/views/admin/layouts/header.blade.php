<!DOCTYPE html>
<html>
	<head>
		<title>Trang quản trị ADmin</title>
		<base href="{{ asset('/') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap/css/bootstrap.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('/css/admin/style.css') }}">
		<script src="{{ asset('/js/jquery.min.js') }}"></script>

  		<script src="{{ asset('/js/bootstrap/js/bootstrap.min.js') }}"></script>
        
        <script src="{{ asset('/js/admin/js.js') }}"></script>


	</head>
	<body>
		<header>
			<div class="row menu">
				<div class="col-lg-12">
					<ul>
						<a href="{{ route('admin.home') }}">
							<li>
								Trang chủ
							</li>
						</a>
<!-- 						<a href="{{ route('service.add') }}">
							<li>
								Thêm dịch vụ
							</li>
						</a> -->
						<a href="{{ route('service.list') }}">
							<li>
								Quản lý dịch vụ
							</li>
						</a>
				
						<a href="{{ route('employee.list') }}">
							<li>
								Quản lý nhân viên
							</li>
						</a>
						@if (auth()->check())
							<a style="float: right;" href="{{ route('logout') }}">
								<li>
									Đăng xuất
								</li>
							</a>
							<a style="float: right;" href="{{ route('employee.list') }}">
								<li>
									{{ auth()->user()->name }}
								</li>
							</a>
						@elseif (auth('employees')->check())
							<a style="float: right;" href="{{ route('logout') }}">
								<li>
									Đăng xuất
								</li>
							</a>
							<a style="float: right;" href="{{ route('employee.list') }}">
								<li>
									{{ auth('employees')->user()->full_name }}
								</li>
							</a>
						@endif
					</ul>
				</div>
			</div>
		</header>