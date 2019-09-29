@extends('admin.layouts.index')

@section('content')
    <div class="row" style="padding: 40px 40px 0px 40px;">
    	<div class="col-lg-9">
    		@if (session('thongbao'))
	            <div class="alert alert-success">
	                {{ session('thongbao') }}
	            </div>
	        @endif
    		<button style="float: right; margin-bottom: 20px" type="button" class="btn btn-primary input-control" data-toggle="modal" data-target="#myModal">
            Thêm hội viên
            </button>
    		<table class="list-table">
    			<tr style="background: #BBDEFB">
    				<th>STT</th>
    				<th>Khách hàng</th>
    				<th>SĐT</th>
    				<th>Tên thẻ</th>
    				<th>Dịch vụ áp dụng</th>
    				<th>Ngày làm thẻ</th>
    				<th>Ngày hết hạn</th>
    				<th>Trạng thái</th>
    				<th>
    					Gia hạn
    				</th>
    			</tr>
    			@php $stt = 0; @endphp
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
    						  {{ $service->service->name }} <span style="color: red">(Giảm {{ $service->percent }}%)</span><br>
    						@endforeach
    					</td>
    					<td>
    						{{ date('d/m/Y', strtotime($member->start_time)) }}
    					</td>
    					<td>
    						{{ date('d/m/Y', strtotime($member->end_time)) }}
    					</td>

    					<td>
    						@if (strtotime(date('Y-m-d')) <= strtotime($member->end_time))
    							<span style="color: #007bff; font-weight: bold;">Còn hạn</span>
    						@else
    							<span style="color: red; font-weight: bold;">Hết hạn</span>
    							
    						@endif
    					</td>
    					<td>
    						<button type="button" onclick="extension({{ $member->id }})" class="btn btn-primary button-control" data-toggle="modal" data-target="#cart-extension">Gia hạn</button>
                            <div class="modal fade" id="cart-extension">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title">Gia hạn thẻ</h3>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body extension">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
    					</td>
    				</tr>
    			@endforeach
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
                    <h3 class="modal-title">Thêm hội viên</h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                	<form onsubmit="return validateFormMembership()" method="post" action="{{ route('membership.add') }}">
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
	                    				@foreach ($cardList as $card)
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
                </div>
            </div>
        </div>
    </div>
@endsection