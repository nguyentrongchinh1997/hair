@extends('admin.layouts.index')

@section('content')
<div class="row" style="padding-left: 40px; margin-top: 20px">
    <div class="col-lg-6 left">
        <div class="row" style="background: #f8f8f8; border: 1px solid #e5e5e5; padding: 15px">
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
<!--             <div class="col-lg-12" style="margin-bottom: 20px">
                <h4>Thống kê lịch đặt</h4>
                <table style="width: 100%">
                    <tr>
                        <td>
                            <i style="color: red; font-size: 25px" class="fas fa-exclamation-circle"></i> Đặt lịch
                        </td>
                        <td>
                            <i style="color: green; font-size: 25px" class="fas fa-check-circle"></i> Đã check-in
                        </td>
                        <td>
                            <i style="color: #2392ec; font-size: 25px" class="fas fa-thumbs-up"></i> Đã thanh toán
                        </td>
                    </tr>
                </table>
            </div> -->
            <!-- <div class="col-lg-12">
                <ul>
                    @foreach ($orderList as $order)
                        <li value="{{ $order->id }}" class="list-order" id="order{{ $order->id }}">
                            <table>
                                <tr>
                                    <td style="color: #2392ec; font-weight: 700">
                                        {{ $order->customer->phone }}
                                    </td>
                                    <td style="text-align: right; padding-right: 10px" id="status{{ $order->id }}">
                                        @if ($order->status == config('config.order.status.create'))
                                            <i style="color: red; font-size: 25px" class="fas fa-exclamation-circle"></i>
                                        @elseif ($order->status == config('config.order.status.check-in'))
                                            <i style="color: green; font-size: 25px" class="fas fa-check-circle"></i>
                                        @else
                                            <i style="color: #2392ec; font-size: 25px" class="fas fa-thumbs-up"></i>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                            
                        </li>
                    @endforeach
                </ul>
            </div> -->
            <div class="col-lg-12">
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
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th scope="col">STT</th>
                      <th scope="col">SĐT</th>
                      <th scope="col">Thợ</th>
                      <th scope="col">Khách hàng</th>
                      <th scope="col">Thời gian hẹn</th>
                    </tr>
                  </thead>
                  <tbody class="order-list">
                    @php $stt = 0; @endphp
                    @foreach ($orderList as $order)
                        <tr style="cursor: pointer;" value="{{ $order->id }}" class="list-order" id="order{{ $order->id }}">
                            <th scope="row">{{ ++$stt }}</th>
                            <td>{{ $order->customer->phone }}</td>
                            <td>{{ $order->employee->full_name }}</td>
                            <td>
                                {{ ($order->customer->full_name == '') ? 'Chưa có thông tin' : $order->customer->full_name }}
                            </td>
                          <td>
                              {{ $order->time->time }}
                          </td>
                        </tr>
                    @endforeach
                  </tbody>
                </table>
            </div>
            
        </div>
    </div>
    <div class="col-lg-6 detail-order right">
        
    </div>
</div>

<hr>
@endsection
