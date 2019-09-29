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
                            <select name="month" id="month" class="form-control input-control">
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
                            <select name="year" id="year" class="form-control input-control">
                                @for ($i = 2019; $i <= date('Y'); $i++)
                                    <option @if ($i == $year) {{ 'selected' }} @endif value="{{ $i }}">Năm
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </td>
                        <td>
                            <button class="btn btn-primary input-control" value="month" name="pick-month" type="submit">
                                XEM
                            </button>
                        </td>
                    </tr>
                </table>
            </form>
            
        </div>
        <div class="col-lg-9">
            <form method="post" action="{{ route('expense.month') }}">
                @csrf
                <table style="width: 50%">
                    <tr>
                        <label style="font-weight: bold;">
                            Thống kê theo ngày
                        </label>
                    </tr>
                    <tr>
                        <td>
                            <input value="@if (isset($dateLimit)){{$dateLimit}}@endif" name="date_limit" type="text" placeholder="dd/mm/yyyy - dd/mm/yyyy" id="demo-2" class="form-control form-control-sm date-pick"/>
                        </td>
                        
                        <td>
                            <button class="btn btn-primary input-control" type="submit" value="day" name="pick-day">
                                XEM
                            </button>
                            
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <hr>
    <div class="row" style="padding: 0px 40px;">
        <div class="col-lg-6 expense">
            <div class="row">
                <div class="col-lg-6 chi tab expense-active" value="chi">
                    <p style="margin-bottom: 0px">Chi</p>
                </div>
                <div class="col-lg-6 thu tab" value="thu">
                    <p style="margin-bottom: 0px">Thu</p>
                </div>
            </div>
            <div class="row list-expense" id="chi" style="border: 1px solid #e5e5e5; padding: 15px; height: 420px; overflow: auto;">
                <table class="list-table">
                    <tr>
                        <td colspan="4" style="border: 0px">
                            <button style="float: right" type="button" class="btn btn-primary button-control" data-toggle="modal" data-target="#billAdd">Thêm chi tiêu</button><br>
                        </td>
                    </tr>
                    <tr style="background: #BBDEFB">
                        <th>STT</th>
                        <th>
                            Nội dung
                        </th>
                        <th>
                            Thời gian
                        </th>
                        <th>
                            Số tiền
                        </th>
                    </tr>
                    @php $stt = 0; $tongChi = 0; @endphp
                    @foreach ($expenseList as $expense)
                        <tr>
                            <td style="text-align: center; width: 5%">{{ ++$stt }}</td>
                            <td>
                                {{ $expense->content }}
                            </td>
                            <td>
                                {{ date('H:i:s d/m/Y', strtotime($expense->created_at)) }}
                            </td>
                            <td style="text-align: right; font-size: 20px">
                                {{ number_format($expense->money) }}<sup>đ</sup>
                            </td>
                            @php $tongChi = $tongChi + $expense->money @endphp
                        </tr>
                    @endforeach
                        <tr>
                            <td style="text-align: right;" colspan="3">
                                TỔNG
                            </td>
                            <td style="text-align: right; font-weight: bold; font-size: 20px">{{ number_format($tongChi) }}<sup>đ</sup></td>
                        </tr>
                </table>
            </div>
            <div class="row list-expense" id="thu" style="border: 1px solid #e5e5e5; padding: 15px; height: 420px; overflow: auto;">
                <table class="list-table">
                    
                    <tr style="background: #BBDEFB">
                        <th>Mã đơn</th>
                        <th>
                            Dịch vụ
                        </th>
                        <th>
                            Thời gian
                        </th>
                        <th>
                            Tổng (vnd)
                        </th>
                    </tr>
                    @php $stt = 0; $tongThu = 0; @endphp
                    @foreach ($revenueList as $revenue)
                        <tr>
                            <td style="text-align: center; width: 5%">{{ $revenue->bill->id }}</td>
                            <td>
                                @foreach ($revenue->bill->billDetail as $service)
                                    @if ($service->service_id == '')
                                        <p>{{ $service->other_service }}</p>
                                    @else
                                        <p>{{ $service->service->name }}</p>
                                    @endif
                                    
                                @endforeach
                            </td>
                            <td>
                                {{ date('d/m/Y', strtotime($revenue->date)) }}
                            </td>
                            <td style="text-align: right;">
                                {{ number_format($revenue->bill->total) }}<sup>đ</sup>
                            </td>
                            @php $tongThu = $tongThu + $revenue->bill->total @endphp
                        </tr>
                    @endforeach
                        <tr>
                            <td style="text-align: right; font-size: 20px" colspan="3">
                                TỔNG
                            </td>
                            <td style="text-align: right; font-weight: bold; font-size: 20px">{{ number_format($tongThu) }}<sup>đ</sup></td>
                        </tr>
                </table>
            </div>
        </div>
        <div class="col-lg-4 expense-right">
            <table style="width: 100%;">
                <tr>
                    <td>Tổng Thu</td>
                    <td style="text-align: right; font-size: 25px">
                        {{ number_format($tongThu) }} Đ
                    </td>
                </tr>
                <tr>
                    <td>Tổng Chi</td>
                    <td style="text-align: right; font-size: 25px">
                        {{ number_format($tongChi) }} Đ
                    </td>
                </tr>
                <tr>
                    <td>Dư</td>
                    <td style="text-align: right; font-size: 25px">
                        {{ number_format($tongThu - $tongChi) }} Đ
                    </td>
                </tr>
            </table>
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
@endsection
