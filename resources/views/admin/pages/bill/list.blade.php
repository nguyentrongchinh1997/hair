@extends('admin.layouts.index')

@section('content')
<div class="row" style="padding-left: 40px; margin-top: 20px">
    <div class="col-lg-6 left">
        <div class="col-lg-12" style="background: #f8f8f8; border: 1px solid #e5e5e5; padding: 0px; height: 100%;">
            <div class="col-lg-12" style="margin-bottom: 20px; padding-top: 20px">
                @if (session('thongbao'))
                    <div class="alert alert-success">
                        {{ session('thongbao') }}
                    </div>
                @endif
                <h3>Xem thời gian</h3>
                <form method="post" action="{{ route('bill.post.list') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <table>
                        <tr>
                            <td>
                                <select name="day" id="day" class="input-control form-control">
                                    @for ($i = 1; $i <= 31; $i++)
                                        <option @if ($i == $day) {{ 'selected' }} @endif value="{{ $i }}">
                                            @if ($i < 10)
                                                0{{ $i }}
                                            @else
                                                {{ $i }}
                                            @endif
                                        </option>
                                    @endfor
                                </select>
                            </td>
                            <td style="padding-left: 10px">
                                <select name="month" id="month" class="input-control form-control">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option @if ($i == $month) {{ 'selected' }} @endif value="{{ $i }}">Tháng
                                            @if ($i < 10)
                                                0{{ $i }}
                                            @else
                                                {{ $i }}
                                            @endif
                                        </option>
                                    @endfor
                                </select>
                            </td>
                            <td style="padding-left: 10px">
                                <select name="year" id="year" class="input-control form-control">
                                    @for ($i = 2019; $i <= date('Y'); $i++)
                                        <option @if ($i == $year) {{ 'selected' }} @endif value="{{ $i }}">Năm
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </td>
                            <td style="padding-left: 10px">
                                <button class="btn btn-primary input-control" type="submit">
                                    Xem thời gian
                                </button>
                            </td>
                        </tr>
                    </table>
                </form><br>
                <div class="row">
                    <div class="col-lg-8" style="padding-left: 0px">
                        <h3>Tìm kiếm tại đây:</h3>
                        <div class="input-group">
                            <input type="text" id="key-search" class="form-control" placeholder="Nhập số điện thoại hoặc tên khách hàng...">
                            <div class="input-group-append">
                              <button class="btn btn-secondary" type="button">
                                <i class="fas fa-search"></i>
                              </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4" style="padding-right: 0px">
                        <button style="float: right; margin-top: 30px" type="button" class="button-control btn btn-primary" data-toggle="modal" data-target="#billAdd">Thêm hóa đơn</button><br>
                    </div><br>
                </div>
                <div class="row" style="height: 420px; overflow: auto; margin-top: 20px">
                    <table class="list-table">
                        <thead>
                            <tr style="background: #BBDEFB">
                                <th scope="col">STT</th>
                                <th scope="col">Khách</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Chuyển khoản</th>
                                <th scope="col">Tổng tiền</th>
                            </tr>
                        </thead>
                        <tbody class="order-list">
                            <tr style="background: #fcf8e3; font-weight: bold;">
                                <td style="text-align: right; font-size: 20px" colspan="3">
                                    
                                </td>
                                <td class="transfer" style="text-align: right; font-size: 20px; font-weight: bold;">
                                    
                                </td>
                                <td class="tong" style="text-align: right; font-size: 20px; font-weight: bold;"></td>
                            </tr>
                            @php $stt = $billList->count(); $total = 0; $transfer = 0@endphp
                            @foreach ($billList as $bill)
                                <!-- @if ($bill->order->date == $date) -->
                                    <tr title="click để xem chi tiết" style="cursor: pointer;" value="{{ $bill->id }}" class="list-bill" id="bill{{ $bill->id }}">        
                                        <td style="text-align: center; width: 7%">{{ $stt-- }}</td>  
                                        <td>
                                            <span style="font-weight: bold;">
                                                {{ $bill->customer->full_name }}
                                            </span><br>
                                            {{ substr($bill->customer->phone, 0, 4) }}.{{ substr($bill->customer->phone, 4, 3) }}.{{ substr($bill->customer->phone, 7) }}
                                        </td> 
                                        
                                        <td>
                                            @if ($bill->status == config('config.order.status.check-in'))
                                                <span style="color: red; font-weight: bold;">Chưa thanh toán</span>
                                            @else
                                                <span style="@if ($bill->status == config('config.order.status.check-out')) {{ 'color: #007BDF; font-weight: bold;' }} @endif">Đã thanh toán</span>
                                            @endif
                                        </td>
                                        <td style="text-align: right; font-size: 18px">
                                            @if ($bill->money_transfer != '')
                                                {{ number_format($bill->money_transfer) }}<sup>đ</sup>
                                                @php 
                                                    $transfer = $transfer + $bill->money_transfer
                                                @endphp
                                            @else
                                                0<sup>đ</sup>
                                            @endif
                                        </td>
                                        <td style="text-align: right; font-size: 18px">
                                            @php $tong = 0; @endphp
                                                @foreach ($bill->billDetail as $servicePrice)
                                                    @php 
                                                        $tong = $tong + $servicePrice->sale_money; 
                                                    @endphp
                                                @endforeach
                                            @if ($bill->status == config('config.order.status.check-out'))
                                                @php 
                                                    $total = $total + $tong - $bill->sale;
                                                @endphp
                                            @endif
                                            {{ number_format($tong - $bill->sale) }}<sup>đ</sup>
                                        </td>  
                                    </tr>
                                <!-- @endif -->
                            @endforeach
                            <tr style="display: none;">
                                <td style="text-align: right; font-size: 20px" colspan="4">
                                    Tổng
                                </td>
                                <td id="tong" style="text-align: right; font-size: 20px; font-weight: bold;">
                                    {{ number_format($total) }}<sup>đ</sup>
                                </td>
                            </tr>
                            <tr style="display: none;">
                                <td style="text-align: right; font-size: 20px" colspan="3">
                                    Tổng
                                </td>
                                <td id="transfer" style="text-align: right; font-size: 20px; font-weight: bold;">
                                    {{ number_format($transfer) }}<sup>đ</sup>
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
    <div class="col-lg-6 right">
        
    </div>
</div>
<div class="modal fade" id="billAdd">
    <div class="modal-dialog">
        <div class="modal-content">
      <!-- Modal Header -->
            <div class="modal-header">
                <h3 class="modal-title">THÊM HÓA ĐƠN</h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
          <!-- Modal body -->
            <div class="modal-body">
                <form onsubmit = "return validateBillAdd()" method="post" action="{{ route('bill.add') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <table class="add-bill" style="width: 100%">
                        <tr>
                            <td>Số điện thoại</td>
                            <td>
                                <input id="phone" required="required" placeholder="Số điện thoại khách hàng" type="text" class="form-control input-control" name="phone">
                            </td>
                        </tr>
                        <tr>
                            <td>Tên khách hàng</td>
                            <td>
                                <input id="name-customer" placeholder="Nhập tên khách hàng..." type="text" required="required" class="form-control input-control" name="full_name">
                            </td>
                        </tr>
                        <tr>
                            <td>Dịch vụ</td>
                            <td>
                                <select name="service_id" class="form-control input-control">
                                    @foreach ($serviceList as $service)
                                        <option value="{{ $service->id }}">
                                            {{ $service->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Thợ chính
                            </td>
                            <td>
                                <select id="employee_id" name="employee_id" class="form-control input-control">
                                    <option value="0">Chọn thợ chính</option>
                                    @foreach ($employeeList as $employee)
                                        <option value="{{ $employee->id }}">
                                            {{ $employee->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Thợ phụ
                            </td>
                            <td>
                                <select id="assistant_id" name="assistant_id" class="form-control input-control">
                                    <option value="0">Chọn thợ phụ</option>
                                    @foreach ($employeeList as $employee)
                                        <option value="{{ $employee->id }}">
                                            {{ $employee->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Giờ phục vụ</td>
                            <td>
                                <select name="time_id" class="form-control input-control">
                                    @foreach ($timeList as $time)
                                        <option value="{{ $time->id }}">
                                            {{ $time->time }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Yêu cầu khách hàng</td>
                            <td>
                                <input class="no-request" type="radio" value="0" name="requirement"> Không
                                <input class="request" type="radio" value="1" name="requirement"> Có
                            </td>
                        </tr>
                        <tr>
                            <td>Ngày lập hóa đơn</td>
                            <td>
                                <input type="date" name="date" value="{{ date('Y-m-d') }}" class="form-control input-control">
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input class="btn btn-primary button-control" type="submit" value="Thêm" name="">
                            </td>
                        </tr>
                        
                    </table>
                </form>
            </div>
          <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
  </div>
</div>
@endsection
