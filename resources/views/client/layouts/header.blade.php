<!DOCTYPE html>
<html>
	<head>
		<title>Trang quản trị Admin</title>
		<base href="{{ asset('/') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap/css/bootstrap.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('/css/client/style.css') }}">
		<link rel="stylesheet" href="{{ asset('/font/fontawesome-free-5.10.0-web/css/all.css') }}" crossorigin="anonymous">
		<script src="{{ asset('/js/jquery.min.js') }}"></script>

  		<script src="{{ asset('/js/bootstrap/js/bootstrap.min.js') }}"></script>
        
        <script src="{{ asset('/js/client/js.js') }}"></script>


	</head>
	<body>
		<header>
			@if (session('thongbao'))
				<div class="alert alert-success" style="margin-bottom: 0px; text-align: center;">
		        	{{ session('thongbao') }}
		        </div>
	        @endif
			<div class="row top-header">
				<div class="container">
					<center>
						<img src="{{ asset('/image/logo.webp') }}">
					</center>
				</div>
				
			</div>
			<div class="row menu">
				<div class="container">
					<div class="col-lg-12">
						<ul>
							<a href="{{ route('admin.home') }}">
								<li>
									<i class="fas fa-home"></i>
								</li>
							</a>
							<a href="">
								<li>DỊCH VỤ</li>
							</a>
							<a href="">
								<li>VỀ 30SHINE</li>
							</a>
							<a href="">
								<li>TUYỂN DỤNG</li>
							</a>
						</ul>
					</div>
				</div>
			</div>
		</header>