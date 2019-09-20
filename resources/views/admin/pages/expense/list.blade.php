@extends('admin.layouts.index')

@section('content')
    <div class="row" style="padding: 40px 40px 0px 40px;">
        <div class="col-lg-3">
            <form method="post" action="{{ route('expense.month') }}">
                @csrf
                <table>
                    <tr>
                        <label style="font-weight: bold;">Thống kê theo tháng</label>
                    </tr>
                    <tr>
                        <td>
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
                        <td>
                            <select name="year" id="year" class="form-control">
                                @for ($i = 2019; $i <= date('Y'); $i++)
                                    <option @if ($i == $year) {{ 'selected' }} @endif value="{{ $i }}">Năm
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </td>
                        <td>
                            <input type="submit" value="XEM" class="btn btn-primary" name="">
                        </td>
                    </tr>
                </table>
            </form>
            
        </div>
        <div class="col-lg-9">
            <form method="post" action="{{ route('expense.day') }}">
                @csrf
                <table>
                    <tr>
                        <label style="font-weight: bold;">
                            Thống kê theo ngày
                        </label>
                    </tr>
                    <tr>
                        <td style="padding-right: 10px; padding-left: 10px">
                            từ
                        </td>
                        <td>
                            <input value="@if(isset($dateFrom)){{date('Y-m-d', strtotime($dateFrom))}}@endif" type="date" class="form-control" name="date_from">
                        </td>
                        
                        <td style="padding-right: 10px; padding-left: 10px">
                            đến
                        </td>
                        <td>
                            <input value="@if(isset($dateTo)){{date('Y-m-d', strtotime($dateTo))}}@endif" type="date" class="form-control" name="date_to">
                        </td>
                        
                        <td>
                            <input type="submit" value="XEM" class="btn btn-primary" name="">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <hr>
    <div class="row" style="padding: 0px 40px;">
        <div class="col-lg-6">
            <h3>
                QUẢN LÝ CHI
            </h3>
            @if (session('thongbao'))
                <div class="alert alert-success">
                    {{ session('thongbao') }}
                </div>
            @endif
            <div class="row">
                <div class="col-lg-12">
                    <button style="float: right;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#billAdd">THÊM CHI TIÊU</button>
                </div>
            </div>
            <div class="modal fade" id="billAdd">
                <div class="modal-dialog">
                    <div class="modal-content">
                  <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">THÊM CHI TIÊU</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                      <!-- Modal body -->
                        <div class="modal-body">
                            <form method="post" action="{{ route('expense.add') }}">
                                @csrf
                                <table class="add-bill" style="width: 100%">
                                    <tr>
                                        <td>Nội dung chi tiêu</td>
                                        <td>
                                            <textarea required="required" placeholder="Nội dung chi tiêu" name="content" class="form-control"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Số tiền chi tiêu</td>
                                        <td>
                                            <input id="formattedNumberField" required="required" placeholder="Số tiền chi tiêu" type="text" class="form-control" name="money">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <input class="btn btn-primary" type="submit" value="THÊM" name="">
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
            <div class="row expense" style="margin-top: 20px; max-height: 400px; overflow: auto;">
                <table>
                    <tr style="background: #eee">
                        <th>STT</th>
                        <th>
                            NỘI DUNG
                        </th>
                        <th>
                            THỜI GIAN
                        </th>
                        <th>
                            SỐ TIỀN
                        </th>
                    </tr>
                    @php $stt = 0; $tong = 0; @endphp
                    @foreach ($expenseList as $expense)
                        <tr>
                            <td>{{ ++$stt }}</td>
                            <td>
                                {{ $expense->content }}
                            </td>
                            <td>
                                {{ date('H:i:s d/m/Y', strtotime($expense->created_at)) }}
                            </td>
                            <td style="text-align: right;">
                                {{ number_format($expense->money) }}<sup>đ</sup>
                            </td>
                            @php $tong = $tong + $expense->money @endphp
                        </tr>
                    @endforeach
                        <tr>
                            <td style="text-align: right;" colspan="3">
                                TỔNG
                            </td>
                            <td style="text-align: right; font-weight: bold;">{{ number_format($tong) }}<sup>đ</sup></td>
                        </tr>
                </table>
            </div>
        </div>
        <div class="col-lg-6">
            <h3>
                QUẢN LÝ THU
            </h3>
            <div class="row expense" style="margin-top: 20px; max-height: 400px; overflow: auto;">
                <table>
                    <tr style="background: #eee">
                        <th>STT</th>
                        <th>
                            DỊCH VỤ LÀM
                        </th>
                        <th>
                            THỜI GIAN
                        </th>
                        <th>
                            SỐ TIỀN
                        </th>
                    </tr>
                    @php $stt = 0; $tong = 0; @endphp
                    @foreach ($revenueList as $revenue)
                        <tr>
                            <td>{{ ++$stt }}</td>
                            <td>
                                @foreach ($revenue->bill->billDetail as $service)
                                    @if ($service->service_id == '')
                                        <p>» {{ $service->other_service }}</p>
                                    @else
                                        <p>» {{ $service->service->name }}</p>
                                    @endif
                                    
                                @endforeach
                            </td>
                            <td>
                                {{ date('d/m/Y', strtotime($revenue->date)) }}
                            </td>
                            <td style="text-align: right;">
                                {{ number_format($revenue->bill->total) }}<sup>đ</sup>
                            </td>
                            @php $tong = $tong + $revenue->bill->total @endphp
                        </tr>
                    @endforeach
                        <tr>
                            <td style="text-align: right;" colspan="3">
                                TỔNG
                            </td>
                            <td style="text-align: right; font-weight: bold;">{{ number_format($tong) }}<sup>đ</sup></td>
                        </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
