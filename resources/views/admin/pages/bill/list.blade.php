@extends('admin.layouts.index')

@section('content')
<div class="row" style="padding-left: 40px; margin-top: 20px">
    <div class="col-lg-6 left">
        <div class="col-lg-5" style="background: #f8f8f8; border: 1px solid #e5e5e5; padding: 15px; position: fixed; height: 100%">
            <div class="col-lg-12" style="margin-bottom: 20px;">
                <h2>QUẢN LÝ HÓA ĐƠN</h2><br>
                @if (session('thongbao'))
                    <div class="alert alert-success">
                        {{ session('thongbao') }}
                    </div>
                @endif
                <form method="post" action="{{ route('bill.post.list') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <table>
                        <tr>
                            <td>
                                <select name="day" id="day" class="form-control">
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
                                <select name="month" id="month" class="form-control">
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
                                <select name="year" id="year" class="form-control">
                                    @for ($i = 2019; $i <= date('Y'); $i++)
                                        <option @if ($i == $year) {{ 'selected' }} @endif value="{{ $i }}">Năm
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </td>
                            <td style="padding-left: 10px">
                                <input class="btn btn-primary" type="submit" value="XEM" name="">
                            </td>
                        </tr>
                    </table>
                </form><br>
                <div class="offset-lg-6">
                    <label>Tìm kiếm tại đây:</label>
                    <div class="input-group">
                        <input type="text" id="key-search" class="form-control" placeholder="Nhập số điện thoại...">
                        <div class="input-group-append">
                          <button class="btn btn-secondary" type="button">
                            <i class="fas fa-search"></i>
                          </button>
                        </div>
                    </div><br>
                    @if ($date == date('Y-m-d'))
                        <button style="float: right;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#billAdd">Thêm hóa đơn</button><br>
                    @endif
                </div><br>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">SĐT</th>
                            <th scope="col">Khách hàng</th>
                            <th scope="col">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody class="order-list">
                        @php $stt = 0; @endphp
                        @foreach ($billList as $bill)
                            @if ($bill->order->date == $date)
                                <a href="">
                                    <tr style="cursor: pointer;" value="{{ $bill->id }}" class="list-bill" id="bill{{ $bill->id }}">        
                                        <td>{{ ++$stt }}</td>  
                                                 
                                        <td>
                                            {{ $bill->customer->phone }}
                                        </td>
                                        <td>
                                            {{ $bill->customer->full_name }}
                                        </td>    
                                        <td>
                                            @if ($bill->status == config('config.order.status.check-in'))
                                                <span style="color: red">Chưa thanh toán</span>
                                            @else
                                                <span style="color: green">Đã thanh toán</span>
                                            @endif
                                        </td>
                                    </tr>
                                </a>
                            @endif
                        @endforeach
                    </tbody>
                </table>
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
                <h4 class="modal-title">Thêm hóa đơn</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
          <!-- Modal body -->
            <div class="modal-body">
                <form onsubmit = "return validateForm()" method="post" action="{{ route('bill.add') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <table class="add-bill" style="width: 100%">
                        <tr>
                            <td>Tên khách hàng</td>
                            <td>:</td>
                            <td>
                                <input type="text" required="required" class="form-control" name="full_name">
                            </td>
                        </tr>
                        <tr>
                            <td>Số điện thoại</td>
                            <td>:</td>
                            <td>
                                <input id="phone" required="required" placeholder="Số điện thoại khách hàng" type="text" class="form-control" name="phone">
                            </td>
                        </tr>
                        <tr>
                            <td>Dịch vụ</td>
                            <td>:</td>
                            <td>
                                <select name="service_id" class="form-control">
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
                                Thợ
                            </td>
                            <td>:</td>
                            <td>
                                <select name="employee_id" class="form-control">
                                    @foreach ($employeeList as $employee)
                                        <option value="{{ $employee->id }}">
                                            {{ $employee->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Ngày thực hiện</td>
                            <td>:</td>
                            <td>
                                <input required="required" value="{{ date('Y-m-d') }}" type="date" class="form-control" name="date">
                            </td>
                        </tr>
                        <tr>
                            <td>Giờ phục vụ</td>
                            <td>
                                :
                            </td>
                            <td>
                                <select name="time_id" class="form-control">
                                    @foreach ($timeList as $time)
                                        <option value="{{ $time->id }}">
                                            {{ $time->time }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>
                                <input class="btn btn-primary" type="submit" value="Thêm" name="">
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
