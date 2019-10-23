@extends('admin.layouts.index')

@section('content')
    <div class="row" style="padding: 40px 40px 0px 40px;">
        <div class="col-lg-9">
            <h3>Xem thời gian:</h3>
            <form method="post" action="{{ route('membership.post.list') }}">
                @csrf
                <table>
                    <tr>
                        <td>
                            <input value="{{ $date }}" type="date" class="form-control input-control" name="date">
                        </td>
                        
                        <td>
                            <button class="btn btn-primary input-control">Xem</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <div class="row" style="padding: 20px 40px 0px 40px;">
        <div class="col-lg-6" style="margin-bottom: 20px">
            <h3>Tìm kiếm tại đây:</h3>
            <div class="input-group">
                <input type="text" id="member-search" class="form-control" placeholder="Nhập tên hoặc số điện thoại...">
                <div class="input-group-append">
                  <button class="btn btn-secondary" type="button">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <button style="float: right; margin-top: 35px" type="button" class="btn btn-primary input-control" data-toggle="modal" data-target="#myModal">Bán thẻ</button>
        </div>
    	<div class="col-lg-9">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
    		@if (session('thongbao'))
	            <div class="alert alert-success">
	                {{ session('thongbao') }}
	            </div>
	        @endif
    		<table class="list-table">
                <thead>
    			<tr style="background: #BBDEFB">
    				<th>STT</th>
    				<th>Khách hàng</th>
    				<th>SĐT</th>
    				<th>Tên thẻ</th>
    				<th>Dịch vụ áp dụng</th>
                    <th>Ngày bán</th>
    				<th>Ngày làm thẻ</th>
    				<th>Ngày hết hạn</th>
    				<th>Trạng thái</th>
                    <th>Tổng tiền</th>
    				<th>
    					Xóa
    				</th>
    			</tr>
                </thead>
    			@php $stt = 0; $tong = 0; @endphp
                <tbody id="member-result">
                    <tr style="background: #fcf8e3; font-weight: bold;">
                        <td style="text-align: right;" class="tong" colspan="10">
                            
                        </td>
                        <td>
                            
                        </td>
                    </tr>
    			@foreach ($membershipList as $member)
    				<tr>
    					<td>{{ ++$stt }}</td>
    					<td>{{ $member->customer->full_name }}</td>
    					<td>
    						{{ $member->customer->phone }}
    					</td>
    					<td>
    						{{ $member->card->card_name }}
    					</td>
    					<td>
                            @foreach ($member->card->cardDetail as $service)
                                @if ($service->percent == '')
                                    {{ $service->service->name }}<span style="color: red">(free {{ $service->number }} lần)</span>
                                @else
                                    {{ $service->service->name }} <span style="color: red">(Giảm {{ $service->percent }}%)</span><br>
                                @endif
                            @endforeach
                        </td>
                        
                        <td>
                            {{ date('d/m/Y', strtotime($member->created_at)) }}
                        </td>
    					<td>
                            @if ($member->start_time != '')
    						  {{ date('d/m/Y', strtotime($member->start_time)) }}
                            @endif
    					</td>
    					<td>
                            @if ($member->end_time != '')
    						  {{ date('d/m/Y', strtotime($member->end_time)) }}
                            @endif
    					</td>

    					<td>
                            @if ($member->number == '')
        						@if (strtotime(date('Y-m-d')) <= strtotime($member->end_time))
        							<span style="color: #007bff; font-weight: bold;">Còn hạn</span>
        						@else
        							<span style="color: red; font-weight: bold;">Hết hạn</span>
        							
        						@endif
                            @else
                                <span style="color: #007bff; font-weight: bold;">
                                    Còn {{ $member->number }} lần
                                </span>
                            @endif
    					</td>
                        <td style="text-align: right;">
                            {{ number_format($member->card->price) }}<sup>đ</sup>
                        </td>
    					<td style="text-align: center;">
                            <a onclick="return deleteMembership()" style="color: red" href="{{ route('membership.delete', ['id' => $member->id]) }}">
                                <i class="fas fa-times"></i>
                            </a>
    					</td>
    				</tr>
                    @php $tong = $tong +  $member->card->price; @endphp
    			@endforeach
                    <tr style="display: none;">
                        <td id="tong" style="text-align: right;" colspan="10">
                            <span style="font-size: 18px; font-weight: bold;">
                                {{ number_format($tong) }}<sup>đ</sup>
                            </span>
                        </td>
                        <td></td>
                    </tr>
                </tbody>
    		</table>
    	</div>
        <div class="col-lg-9">
            {{ $membershipList->links() }}
            <style type="text/css">
                .pagination{
                    float: right; margin-top: 20px;
                }
            </style>
        </div>
    </div>
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Bán thẻ</h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div data="the-dich-vu" class="col-lg-6 card-active card-type" style="padding: 0px; background: #eee; cursor: pointer;">
                            <h3 style="text-align: center; margin-bottom: 0px; padding: 10px 0px">
                                Thẻ dịch vụ
                            </h3>
                        </div>
                        <div data="the-hoi-vien" class="col-lg-6 card-type" style="padding: 0px; cursor: pointer; background: #eee">
                            <h3 style="text-align: center; margin-bottom: 0px; padding: 10px 0px">
                                Thẻ hội viên
                            </h3>
                        </div>
                    </div>
                	<form class="form-card" id="the-hoi-vien" onsubmit="return validateFormMembership()" method="post" action="{{ route('membership.add') }}">
                		@csrf
	                    <table class="add-bill" style="width: 100%">
	                    	<tr>
	                    		<td>Chọn khách hàng</td>
	                    		<td>
	                    			<select id="customer_id" class="selectpicker form-control" data-live-search="true" data-width="fit" tabindex="-98" name="customer_id">
	                    				<option value="0">Chọn khách hàng</option>
	                    				@foreach ($customerList as $customer)
	                    					<option value="{{ $customer->id }}">
	                    						{{ $customer->phone }} ({{ $customer->full_name }})
	                    					</option>
	                    				@endforeach
	                    			</select>
	                    		</td>
	                    	</tr>
	                    	<tr>
	                    		<td>Chọn thẻ</td>
	                    		<td>
	                    			<select id="card_id" class="form-control input-control" name="card_id">
	                    				<option value="0">Chọn thẻ</option>
	                    				@foreach ($cardList1 as $card)
	                    					<option value="{{ $card->id }}">
	                    						{{ $card->card_name }} ({{ number_format($card->price) }})
	                    					</option>
	                    				@endforeach
	                    			</select>
	                    		</td>
	                    	</tr>
	                    	<tr>
	                    		<td>Ngày bắt đầu</td>
	                    		<td>
	                    			<input value="{{ date('Y-m-d') }}" type="date" class="input-control form-control" name="start_time">
	                    		</td>
	                    	</tr>
	                    	<tr>
	                    		<td>
	                    			Ngày hết hạn
	                    		</td>
	                    		<td>
	                    			<input id="end_time" type="date" class="input-control form-control" name="end_time">
	                    		</td>
	                    	</tr>
	                    	<tr>
	                    		<td></td>
	                    		<td>
	                    			<button class="btn btn-primary" type="submit">Thêm</button>
	                    		</td>
	                    	</tr>
	                    </table>
                    </form>
                    <form class="form-card" id="the-dich-vu" method="post" action="{{ route('membership.add.other') }}">
                        @csrf
                        <table class="add-bill" style="width: 100%">
                            <tr>
                                <td>Chọn khách hàng</td>
                                <td>
                                    <select id="customer_id" class="selectpicker form-control" data-live-search="true" data-width="fit" tabindex="-98" name="customer_id">
                                        <option value="0">Chọn khách hàng</option>
                                        @foreach ($customerList as $customer)
                                            <option value="{{ $customer->id }}">
                                                {{ $customer->phone }} ({{ $customer->full_name }})
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Chọn thẻ</td>
                                <td>
                                    <select id="card_id" class="form-control input-control" name="card_id">
                                        <option value="0">Chọn thẻ</option>
                                        @foreach ($cardList2 as $card)
                                            <option value="{{ $card->id }}">
                                                {{ $card->card_name }} ({{ number_format($card->price) }})
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <button class="btn btn-primary" type="submit">Thêm</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
