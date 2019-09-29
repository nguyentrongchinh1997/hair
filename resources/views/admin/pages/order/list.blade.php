@extends('admin.layouts.index')

@section('content')
<div class="row" style="padding-left: 40px; margin-top: 20px">
    <div class="col-lg-6 left">
        <div class="col-lg-12" style="background: #fafafa; border: 1px solid #e5e5e5; padding: 0px;height: 100%">
            <div class="col-lg-12" style="margin-bottom: 20px">
                @if (session('thongbao'))
                    <div class="alert alert-success">
                        {{ session('thongbao') }}
                    </div>
                @endif
            </div>
            <div class="col-lg-12" style="margin-bottom: 20px">
                <form method="post" action="{{ route('order.post.list') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <h3>Xem thời gian</h3>
                    <table>
                        <tr>
                            <td>
                                <select id="day" name="day" class="input-control form-control">
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
                                <select id="month" name="month" class="input-control form-control">
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
                                <select id="year" name="year" class="input-control form-control">
                                    @for ($i = 2019; $i <= date('Y'); $i++)
                                        <option @if ($i == $year) {{'selected'}} @endif value="{{ $i }}">Năm
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </td>
                            <td style="padding-left: 10px">
                                <button type="submit" class="btn btn-primary input-control">Xem thời gian</button>
                                <!-- <input class="btn btn-primary" type="submit" name="ok" value="XEM LỊCH" name=""> -->
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="col-lg-12">
                <div class="row" style="margin-bottom: 20px">
                    <div class="col-lg-6" style="padding-left: 0px">
                        <h3>Tìm kiếm tại đây:</h3>
                        <div class="input-group">
                            <input type="text" id="search-input" class="form-control" placeholder="Nhập số điện thoại...">
                            <div class="input-group-append">
                              <button class="btn btn-secondary" type="button">
                                <i class="fas fa-search"></i>
                              </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6" style="padding-right: 0px">
                        @if ($date == date('d/m/Y'))
                            <button style="float: right; margin-top: 30px" type="button" class="btn btn-primary button-control" data-toggle="modal" data-target="#billAdd">Thêm lịch đặt</button>
                        @endif
                    </div>
                </div>
                <div class="row" style="height: 400px; overflow: auto; margin-bottom: 20px">
                    <table class="list-table" style="padding-top: 20px">
                        <thead>
                            <tr style="background: #BBDEFB">
                              <th scope="col">STT</th>
                              <th scope="col">SĐT</th>
                              <th scope="col">Lịch hẹn</th>
                              <th scope="col">Dịch vụ</th>
                              <th scope="col">Trạng thái</th>
                            </tr>
                        </thead>
                      <tbody class="order-list">
                        @php $stt = 0; @endphp
                        @foreach ($orderList as $order)
                            <tr style="cursor: pointer;" 
                                value="{{ $order->id }}" class="list-order" id="order{{ $order->id }}">
                                <th scope="row">{{ $order->id }}</th>
                                <td>
                                    {{ substr($order->customer->phone, 0, 4) }}.{{ substr($order->customer->phone, 4, 3) }}.{{ substr($order->customer->phone, 7) }}
                                </td>
                                <td>
                                    {{ $order->time->time }}
                                </td>
                                <td>
                                    @foreach ($order->orderDetail as $orderDetail)
                                        @if ($orderDetail->employee_id != '')
                                            <p>
                                                {{ $orderDetail->service->name }} ({{ $orderDetail->employee->full_name }})
                                            </p>
                                        @else
                                            <p>
                                                <span style="font-weight: bold;">
                                                </span> {{ $orderDetail->service->name }} + <i>Chưa chọn</i>
                                            </p>
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @if ($order->status == config('config.order.status.create'))
                                        Chưa check-in
                                    @elseif ($order->status == config('config.order.status.check-in'))
                                        <span style="color: green; font-weight: bold;">
                                            Đã check-in
                                        </span>
                                        
                                    @else
                                        <span style="color: #007bff; font-weight: bold;">Hoàn thành</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                      </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
    <div class="col-lg-6" id="right">
        
    </div>
</div>
<div class="modal fade" id="billAdd">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Thêm lịch</h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form onsubmit = "return validateAddOrder()" method="post" action="{{ route('order.add') }}">
                    @csrf
                    <table class="add-bill" style="width: 100%">
                        <tr>
                            <td>Số điện thoại</td>
                            <td>
                                <input id="phone" required="required" placeholder="Nhập SĐT..." type="text" class="input-control form-control" name="phone">
                            </td>
                        </tr>
                        <tr>
                            <td>Tên khách hàng</td>
                            <td>
                                <input placeholder="Nhập tên khách hàng..." type="text" required="required" class="input-control form-control" name="full_name">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Dịch vụ
                            </td>
                            <td>
                                <table style="width: 100%">
                                    <tr>
                                        <td style="width: 30%">
                                            <input onclick="check1()" id="cut" value="{{ config('config.service.cut') }}" type="checkbox" name="service[]"> Cắt
                                        </td>
                                        <td style="width: 70%">
                                            <select disabled="disabled" id="cut-stylist" name="employee[]" class="cut input-control form-control">
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
                                            <input onclick="check2()" id="wash" value="{{ config('config.service.wash') }}" type="checkbox" name="service[]"> Gội
                                        </td>
                                        
                                        <td>
                                            <select disabled="disabled" id="cut-skinner" name="employee[]" class="wash input-control form-control">
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
                                <select id="time-id" name="time_id" class="input-control form-control">
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
                            <td>Khách yêu cầu</td>
                            <td>
                                <label style="margin-right: 10px">
                                    <input value="1" type="radio" name="require"> Có
                                </label>
                                <label>
                                    <input checked="checked" value="0" type="radio" name="require"> Không
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <button class="button-control btn btn-primary" type="submit">
                                    Thêm
                                </button>
                               
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
