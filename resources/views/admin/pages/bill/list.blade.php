@extends('admin.layouts.index')

@section('content')
<div class="row" style="padding-left: 40px; margin-top: 20px">
    <div class="col-lg-6 left">
        <div class="row" style="background: #f8f8f8; border: 1px solid #e5e5e5; padding: 15px">
            <div class="col-lg-12" style="margin-bottom: 20px">
                <h2>QUẢN LÝ THANH TOÁN</h2>
                @if (session('thongbao'))
                    <div class="alert alert-success">
                        {{ session('thongbao') }}
                    </div>
                @endif
            </div>

            <div class="col-lg-12" style="margin-bottom: 20px">
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
                </form>
            </div>
            <div class="col-lg-12">
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
                </div><br>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">SĐT</th>
                            <th scope="col">Khách hàng</th>
                            <th scope="col">Thợ</th>
                            <th scope="col">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody class="order-list">
                        @php $stt = 0; @endphp
                        @foreach ($billList as $bill)
                            @if ($bill->order->date == $date)
                                <tr style="cursor: pointer;" value="{{ $bill->id }}" class="list-bill" id="bill{{ $bill->id }}">        
                                    <td>{{ ++$stt }}</td>  
                                             
                                    <td>
                                        {{ $bill->customer->phone }}
                                    </td>
                                    <td>
                                        {{ $bill->customer->full_name }}
                                    </td>    
                                    <td>
                                        {{ $bill->order->employee->full_name }}
                                    </td> 
                                    <td>
                                        @if ($bill->status == config('config.order.status.check-in'))
                                            <span style="color: red">Chưa thanh toán</span>
                                        @else
                                            <span style="color: green">Đã thanh toán</span>
                                        @endif
                                    </td>
                                </tr>
                            @endif
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
