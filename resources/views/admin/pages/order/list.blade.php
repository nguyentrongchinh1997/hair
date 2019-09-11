@extends('admin.layouts.index')

@section('content')
<div class="row" style="padding-left: 40px; margin-top: 20px">
    <div class="col-lg-6 left">
        <div class="col-lg-5" style="background: #f8f8f8; border: 1px solid #e5e5e5; padding: 15px; position: fixed; height: 100%">
            <div class="col-lg-12" style="margin-bottom: 20px">
                <h2>QUẢN LÝ LỊCH ĐẶT</h2>
                @if (session('thongbao'))
                    <div class="alert alert-success">
                        {{ session('thongbao') }}
                    </div>
                @endif
            </div>
            <div class="col-lg-12" style="margin-bottom: 20px">
                <form method="post" action="{{ route('order.post.list') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <table>
                        <tr>
                            <td>
                                <select id="day" name="day" class="form-control">
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
                                <select id="month" name="month" class="form-control">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option @if ($i == $month) {{'selected'}} @endif value="{{ $i }}">Tháng
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
                                <select id="year" name="year" class="form-control">
                                    @for ($i = 2019; $i <= date('Y'); $i++)
                                        <option @if ($i == $year) {{'selected'}} @endif value="{{ $i }}">Năm
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </td>
                            <td style="padding-left: 10px">
                                <input class="btn btn-primary" type="submit" name="ok" value="XEM LỊCH" name="">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="col-lg-12" style="max-height: 500px; overflow: auto;">
                <div class="row">
                <div class="col-lg-6" style="padding: 2px 0px 0px 0px;">
                    <span style="padding: 2px 13px; border: 1px solid #ccc; background: #FFF; margin-top: 10px; margin-right: 10px"></span> Chưa check-in <br><br>
                    <span style="padding: 2px 13px; background: #4c9d2f; margin-top: 10px; margin-right: 10px"></span> Đã check-in <br><br>
                    <span style="padding: 2px 13px; background: #007bff; margin-right: 10px"></span> Hoàn thành <br>
                </div>
                <div class="col-lg-6">
                    <label>Tìm kiếm tại đây:</label>
                    <div class="input-group">
                        <input type="text" id="search-input" class="form-control" placeholder="Nhập số điện thoại...">
                        <div class="input-group-append">
                          <button class="btn btn-secondary" type="button">
                            <i class="fas fa-search"></i>
                          </button>
                        </div>
                    </div><br>
                    @if ($date == date('d/m/Y'))
                        <button style="float: right; margin-bottom: 10px" type="button" class="btn btn-primary" data-toggle="modal" data-target="#billAdd">Thêm lịch đặt</button>
                    @endif
                </div>
                </div>
                <table class="table table-bordered" style="margin-top: 20px">
                  <thead>
                    <tr>
                      <th scope="col">STT</th>
                      <th scope="col">SĐT</th>
                      <!-- <th scope="col">Thợ</th> -->
                      <th scope="col">Khách hàng</th>
                      <th scope="col">Thời gian hẹn</th>
                      <th scope="col">Dịch vụ + Thợ</th>
                    </tr>
                  </thead>
                  <tbody class="order-list">
                    @php $stt = 0; @endphp
                    @foreach ($orderList as $order)
                        <tr 
                            style="cursor: pointer; 
                                @if ($order->status == config('config.order.status.check-in')) 
                                    {{ 'background: #4c9d2f; color: #fff;' }} 
                                @elseif ($order->status == config('config.order.status.check-out')) 
                                    {{ 'background: #007bff; color: #fff;' }} 
                                @endif" 
                            value="{{ $order->id }}" class="list-order" id="order{{ $order->id }}">
                            <th scope="row">{{ $order->id }}</th>
                            <td>{{ $order->customer->phone }}</td>
                            <td>
                               
                                @if ($order->customer->full_name == '')
                                    <span>
                                        <i>Chưa có thông tin</i>
                                    </span>
                                @else
                                    <span style="font-weight: bold;">
                                        {{ $order->customer->full_name }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                {{ $order->time->time }}
                            </td>
                            <td>
                                @foreach ($order->orderDetail as $orderDetail)
                                    @if ($orderDetail->employee_id != '')
                                        <p>
                                            <span style="font-weight: bold;">
                                                »
                                            </span> {{ $orderDetail->service->name }} + {{ $orderDetail->employee->full_name }}
                                        </p>
                                    @else
                                        <p>
                                            <span style="font-weight: bold;">
                                                »
                                            </span> {{ $orderDetail->service->name }} + <i>Chưa chọn</i>
                                        </p>
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                  </tbody>
                </table>
            </div>
            
        </div>
    </div>
    <div class="col-lg-6" id="right">
        
    </div>
</div>
<div class="modal fade" id="billAdd">
    <div class="modal-dialog">
        <div class="modal-content">
      <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Thêm đơn đặt</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
          <!-- Modal body -->
            <div class="modal-body">
                <form onsubmit = "return validateAddOrder()" method="post" action="{{ route('order.add') }}">
                    @csrf
                    <table class="add-bill" style="width: 100%">
                        <tr>
                            <td>Số điện thoại</td>
                            <td>:</td>
                            <td>
                                <input id="phone" required="required" placeholder="Nhập SĐT..." type="text" class="form-control" name="phone">
                            </td>
                        </tr>
                        <tr>
                            <td>Tên khách hàng</td>
                            <td>:</td>
                            <td>
                                <input placeholder="Nhập tên khách hàng..." type="text" required="required" class="form-control" name="full_name">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Dịch vụ
                            </td>
                            <td>
                                :
                            </td>
                            <td>
                                <table>
                                    <tr>
                                        <td style="width: 30%">
                                            <input id="cut" value="{{ config('config.service.cut') }}" type="checkbox" name="service[]"> Cắt
                                        </td>
                                        <td style="width: 70%">
                                            <select id="cut-stylist" name="employee[]" class="form-control">
                                                <option value="0">Chọn thợ</option>
                                                @foreach ($stylist as $stylist)
                                                    <option value="{{ $stylist->id }}">
                                                        {{ $stylist->full_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input id="wash" value="{{ config('config.service.wash') }}" type="checkbox" name="service[]"> Gội
                                        </td>
                                        
                                        <td>
                                            <select id="cut-skinner" name="employee[]" class="form-control">
                                                <option value="0">Chọn thợ</option>
                                                @foreach ($skinner as $skinner)
                                                    <option value="{{ $skinner->id }}">
                                                        {{ $skinner->full_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Thời gian phục vụ
                            </td>
                            <td>
                                :
                            </td>
                            <td>
                                <select id="time-id" name="time_id" class="form-control">
                                    <option value="0">
                                        Chọn thời gian
                                    </option>
                                    @foreach ($time as $time)
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
