@extends('client.layouts.index')

@section('content')
<div class="row">
	<div id="demo" class="carousel slide" data-ride="carousel">
	  <!-- Indicators -->
	  <ul class="carousel-indicators">
	    <li data-target="#demo" data-slide-to="0" class="active"></li>
	    <li data-target="#demo" data-slide-to="1"></li>
	    <li data-target="#demo" data-slide-to="2"></li>
	  </ul>
	  
	  <!-- The slideshow -->
	  <div class="carousel-inner">
	    <div class="carousel-item active">
	      <img src="https://storage.30shine.com/banner_web_summer_remix.jpg" alt="Los Angeles" width="1100" height="500">
	    </div>
	    <div class="carousel-item">
	      <img src="https://storage.30shine.com/banner/khai_truong_20190814_w.jpg" alt="Chicago" width="1100" height="500">
	    </div>
	    <div class="carousel-item">
	      <img src="https://storage.30shine.com/banner/20190620_Shinemember_web.jpg" alt="New York" width="1100" height="500">
	    </div>
	  </div>
	  
	  <!-- Left and right controls -->
	  <a class="carousel-control-prev" href="#demo" data-slide="prev">
	    <span class="carousel-control-prev-icon"></span>
	  </a>
	  <a class="carousel-control-next" href="#demo" data-slide="next">
	    <span class="carousel-control-next-icon"></span>
	  </a>
	</div>
</div>
<div class="row">
	<div class="container">
		<div class="row order" style="background: #fff; padding: 15px;">
			<div class="col-lg-12">
				<!-- <center> -->
					<form onsubmit="return validateForm()" method="post" action="{{ route('order') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<h4 style="text-align: center;"><i class="far fa-clock"></i> ĐẶT LỊCH</h4>
						<br>
						<div class="row">
							<div class="col-lg-6">
								<p><b>Số điện thoại:</b></p>
							</div>
							<div class="col-lg-6">
								<input type="text" id="phone" placeholder="* VD: 096xxxxxxx" name="phone">
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<p>
									<b>Dịch vụ:</b>
								</p>
							</div>
							<div class="col-lg-6">
								<table>
									<tr>
										@foreach ($serviceList as $service)
											<td>
												<input type="radio" class="service" name="service" value="{{ $service->id }}"> {{ $service->name }}
											</td>
										@endforeach
									</tr>
								</table>
							</div>
						</div>
						<div class="row stylist">
							
							
						</div>
						<div class="row">
							<div class="col-lg-12">
								<p>
									<b>Chọn khung giờ:</b>
								</p>
								
							</div>
								
								@foreach ($time as $time)
									<div class="col-lg-2">
										<input 
											@if (strtotime($time->time) < strtotime(date('H:i')))
												{{ 'disabled' }}
											@endif 
										type="radio" class="time" value="{{ $time->id }}" name="time">{{ $time->time }}<br>
									</div>
								@endforeach
							
						</div>
						<div class="row">
							<div class="col-lg-12">
								<center>
									<input type="submit" value="ĐẶT LỊCH" name="">
								</center>
							</div>
						</div>
						
					</form>
				<!-- </center> -->
				
			</div>
		</div>
		
	</div>
</div>
@endsection