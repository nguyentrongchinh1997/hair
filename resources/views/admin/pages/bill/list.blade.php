@extends('admin.layouts.index')

@section('content')
<div class="row employee-add" style="padding-left: 40px; padding-top: 40px">
    <div class="col-lg-12">
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
        <h3>Danh sách đặt lịch</h3>
        <div class="offset-lg-8">
            <label>Tìm kiếm tại đây:</label>
            <div class="input-group">
                <input type="text" id="key-search" class="form-control" placeholder="Nhập số điện thoại...">
                <div class="input-group-append">
                  <button class="btn btn-secondary" type="button">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <table class="table-order table table-striped">
              <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Tên khách hàng</th>
                    <th scope="col">Số điện thoại</th>
                    <th scope="col" style="text-align: center;">Giá</th>
                    <th scope="col" style="text-align: center;">Giá (tổng)</th>
                    <th scope="col">Đánh giá</th>
                    <th scope="col">Giảm giá (%)</th>
                    <th scope="col">Nội dung giảm giá</th>
                    <th scope="">Phản hồi</th>
                    <th scope="col">Trạng thái</th>
                </tr>
              </thead>
              <tbody class="order-list">
                    @php $stt = 0; @endphp
                    @foreach ($billList as $bill)
                        <tr>        
                            <td>{{ ++$stt }}</td>  
                            <td>
                                {{ 
                                    ($bill->customer->full_name == '') ? 'Chưa điền thông tin' : $bill->customer->full_name 
                                }}
                            </td>              
                            <td>
                                {{ $bill->customer->phone }}
                            </td>
                            <td style="text-align: right;">
                                {{ number_format($bill->price) }}<sup>đ</sup>
                            </td>
                            <td style="text-align: right;">
                                {{ number_format($bill->total) }}<sup>đ</sup>
                            </td>
                            <td>
                                {{ ($bill->rate == '') ? 'chưa có đánh giá' : $bill->rate }}
                            </td>
                            <td>
                                {{ $bill->sale }}
                            </td>
                            <td>
                                {{ ($bill->rate == '') ? '' : $bill->sale_detail }}
                            </td>
                            <td>
                                {{ ($bill->rate == '') ? 'chưa có' : $bill->comment }}
                            </td>
                            <td>
                                @if ($bill->status == config('config.order.status.check-in'))
                                    <span>Chưa thanh toán</span>
                                @else
                                    <span>Đã thanh toán</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
              </tbody>
            </table>
        </div>
    </div>
</div>
@endsection