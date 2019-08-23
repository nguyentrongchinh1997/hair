@extends('admin.layouts.index')

@section('content')
<div class="row employee-add" style="padding-left: 40px; padding-top: 40px">
    <div class="col-lg-6">
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
        <h3>Danh sách đơn</h3>
        <div class="offset-lg-8">
            <label>Tìm kiếm tại đây:</label>
            <div class="input-group">
                <input type="text" id="search-input" class="form-control" placeholder="Nhập số điện thoại...">
                <div class="input-group-append">
                  <button class="btn btn-secondary" type="button">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
            </div>
        </div>
        <br>
        <div class="row order-list">
            <table class="table-order table table-striped">
              <thead>
                <tr>
                    <th style="text-align: center;" scope="col">Chọn</th>
                    <th style="text-align: center;" scope="col">STT</th>
                    <th scope="col">SĐT</th>
                    <th scope="col">Nhân viên</th>
                    <th scope="col">Trạng thái</th>
                </tr>
              </thead>
              <tbody class="order-list">
                @php $stt = 0; @endphp
                @foreach ($orderList as $order)
                    <tr>
                        <td style="text-align: center;">
                            <input type="radio" name="order" class="order" value="{{ $order->id }}">
                        </td>
                        <td style="text-align: center;">{{ ++$stt }}</td>
                        <td>
                        	{{ $order->customer->phone }}
                        </td>
                        <td>
                        	{{ $order->employee->full_name }}
                        </td>

                        <td id="status{{ $order->id }}">
                            <i style="color: red">Chưa check-in</i>
                        </td>
                    </tr>
                @endforeach
              </tbody>
            </table>
        </div>   
        @if ($orderList->count() == 0)
            <div class="row" style="text-align: center;">
                <div class="col-lg-12">
                    <i>Không có đơn đặt lịch nào</i>
                </div>
                    
            </div>
        @endif
    </div>
    <div class="col-lg-6 detail-order">
        
    </div>
    
</div>
<hr>
<div class="row employee-add" style="padding-left: 40px; padding-top: 40px;">
    <div class="col-lg-6">
        <h3>Đơn đang hoạt động</h3>
        <div class="offset-lg-8">
            <label>Tìm kiếm tại đây:</label>
            <div class="input-group">
                <input type="text" id="search-input" class="form-control" placeholder="Nhập số điện thoại...">
                <div class="input-group-append">
                  <button class="btn btn-secondary" type="button">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
            </div>
        </div><br>
        <table class="table-order table table-striped">
          <thead>
            <tr>
                <th style="text-align: center;" scope="col">Chọn</th>
                <th scope="col">STT</th>
                <th scope="col">Số điện thoại</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Nhân viên</th>
            </tr>
          </thead>
          <tbody class="order-list">
                @php $stt = 0; @endphp
                @foreach ($billList as $bill)
                    <tr>        
                        <td style="text-align: center;">
                            <input type="radio" value="{{ $bill->id }}" name="order">
                        </td>
                        <td>{{ ++$stt }}</td>              
                        <td>
                            {{ $bill->customer->phone }}
                        </td>
                        <td>
                            @if ($bill->status == config('config.order.status.check-in'))
                                <span>Chưa thanh toán</span>
                            @else
                                <span>Đã thanh toán</span>
                            @endif
                        </td>
                        <td>
                            {{ $bill->order->employee->full_name }}
                        </td>
                    </tr>
                @endforeach
          </tbody>
        </table>
    </div>
</div>
@endsection
