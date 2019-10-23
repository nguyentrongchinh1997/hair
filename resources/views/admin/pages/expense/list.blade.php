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
                            <div class="input-group-prepend">
                              <div class="input-group-text input-control">Từ</div>
                            </div>
                        </td>
                        <td>
                            <!-- <input value="@if (isset($dateLimit)){{$dateLimit}}@endif" name="date_limit" type="text" placeholder="dd/mm/yyyy - dd/mm/yyyy" id="demo-2" class="form-control form-control-sm date-pick"/> -->
                            <input placeholder="dd/mm/yyyy"
                                value="
                                    @if (isset($date_start))
                                        {{ $date_start }}
                                    @endif" 
                                type="text" id="demo-3_1" class="form-control form-control-sm date-pick" name="date_start">

                        </td>
                        <td>
                            <div class="input-group-prepend">
                              <div class="input-group-text input-control">Đến</div>
                            </div>
                        </td>
                        <td>
                            <input placeholder="dd/mm/yyyy" 
                            value="
                                @if (isset($date_end))
                                    {{ $date_end }}
                                @endif" 
                            type="text" id="demo-3_2" class="form-control form-control-sm date-pick" name="date_end">
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
                <div class="col-lg-4 chi tab expense-active" value="chi">
                    <p style="margin-bottom: 0px">Chi</p>
                </div>
                <div class="col-lg-4 thu tab" value="thu">
                    <p style="margin-bottom: 0px">
                        Thu <span style="font-size: 12px; font-weight: normal;">(hóa đơn)</span>
                    </p>
                </div>
                <div class="col-lg-4 thu thu2 tab" value="thu2">
                    <p style="margin-bottom: 0px">Thu<span style="font-size: 12px; font-weight: normal;"> (khoản tiền khác)</span></p>
                </div>
            </div>
        <!-- các khoản chi --> 
            <div class="row list-expense" id="chi" style="border: 1px solid #e5e5e5; padding: 15px; height: 420px; overflow: auto;">
                <table class="list-table">
                    @if (session('thongbao'))
                        <tr>
                            <td style="border: 0px" class="alert alert-success" colspan="5">
                                {{ session('thongbao') }}
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td colspan="6" style="border: 0px">
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
                            Tổng tiền
                        </th>
                        <th>
                            Xóa
                        </th>
                        <th>Sửa</th>
                    </tr>
                    @php $stt = 0; $tongChi = 0; @endphp
                    <tr style="background: #fcf8e3; font-weight: bold;">
                        <td class="tong-chi" style="text-align: right; font-size: 20px" colspan="4">

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
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
                            <td style="text-align: center;">
                                <a onclick="return deleteExpense()" href="{{ route('expense.delete', ['id' => $expense->id]) }}" style="color: red;">
                                    <i class="fas fa-times"></i>
                                </a>
                            </td>
                            <td style="text-align: center; color: #007bff">
                                <i onclick="editExpese({{ $expense->id }})" data-toggle="modal" data-target="#expense-edit" class="expense-edit fas fa-edit"></i>
                            </td>
                            @php $tongChi = $tongChi + $expense->money @endphp
                        </tr>
                    @endforeach
                        <tr style="display: none;">
                            <td style="text-align: right;" colspan="3">
                                TỔNG
                            </td>
                            <td id="tong-chi" style="text-align: right; font-weight: bold; font-size: 20px">{{ number_format($tongChi) }}<sup>đ</sup></td>
                        </tr>
                </table>
            </div>
        <!-- end -->
        <!-- khoản thu khác -->
            <div class="row list-expense" id="thu2" style="border: 1px solid #e5e5e5; padding: 15px; height: 420px; overflow: auto;">
                <table class="list-table">
                    <tr>
                        <td colspan="6" style="border: 0px">
                            <button style="float: right" type="button" class="btn btn-primary button-control" data-toggle="modal" data-target="#thu-nhap">Thêm</button><br>
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
                            Tổng tiền
                        </th>
                        <th>Sửa</th>
                        <th>Xóa</th>
                    </tr>
                    @php $stt = 0; $tongThu2 = 0; @endphp
                        <tr style="background: #fcf8e3; font-weight: bold;">
                            <td class="tong-thu" style="text-align: right; font-size: 20px" colspan="4">
                                
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                    @foreach ($otherRevenueList as $expense)
                        <tr>
                            <td style="text-align: center; width: 5%">{{ ++$stt }}</td>
                            <td>
                                {{ $expense->content }}
                            </td>
                            <td>
                                {{ date('H:i d/m/Y', strtotime($expense->created_at)) }}
                            </td>
                            <td style="text-align: right; font-size: 20px">
                                {{ number_format($expense->money) }}<sup>đ</sup>
                            </td>
                            
                            <td style="text-align: center; color: #007bff">
                                @if (auth()->user()->level == 2)
                                    <i onclick="editExpese({{ $expense->id }})" data-toggle="modal" data-target="#expense-edit" class="expense-edit fas fa-edit"></i>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                @if (auth()->user()->level == 2)
                                    <a onclick="return deleteExpense()" style="color: red" href="{{ route('expense.delete', ['id' => $expense->id]) }}">
                                        <i class="fas fa-times"></i>
                                    </a>
                                @endif
                            </td>
                            @php $tongThu2 = $tongThu2 + $expense->money @endphp
                        </tr>
                    @endforeach
                        <tr style="display: none;">
                            <td style="text-align: right;" colspan="3">
                                TỔNG
                            </td>
                            <td id="tong-thu" style="text-align: right; font-weight: bold; font-size: 20px">{{ number_format($tongThu2) }}<sup>đ</sup></td>
                        </tr>
                </table>
            </div>
        <!-- end -->
        <!-- khoản thu từ hóa đơn -->
            <div class="row list-expense" id="thu" style="border: 1px solid #e5e5e5; padding: 15px; height: 420px; overflow: auto;">
                <table class="list-table">
                    <tr style="background: #BBDEFB">
                        <th>STT</th>
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
                    <tr style="background: #fcf8e3; font-weight: bold;">
                        <td class="tong" style="text-align: right; font-size: 20px" colspan="5">

                        </td>
                    </tr>
                    @foreach ($revenueList as $bill)
                        <tr>
                            <td style="text-align: center; width: 5%">{{ ++$stt }}</td>
                            <td>
                                @foreach ($bill->billDetail as $billDetail)
                                    @if ($billDetail->service_id == '')
                                        <p>{{ $billDetail->other_service }}</p>
                                    @else
                                        <p>{{ $billDetail->service->name }}</p>
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                {{ date('d/m/Y', strtotime($bill->date)) }}
                            </td>
                            <td style="text-align: right;">
                                {{ number_format($bill->total) }}<sup>đ</sup>
                            </td>
                            @php $tongThu = $tongThu + $bill->total @endphp
                        </tr>
                    @endforeach
                        <tr style="display: none;">
                            <td style="text-align: right; font-size: 20px" colspan="3">
                                TỔNG
                            </td>
                            <td id="tong" style="text-align: right; font-weight: bold; font-size: 20px">{{ number_format($tongThu) }}<sup>đ</sup></td>
                        </tr>
                </table>
            </div>
        <!-- end -->
        </div>
        <div class="col-lg-4 expense-right">
            <table style="width: 100%;">
                <tr>
                    <td style="font-size: 18px">Tổng Thu<br><span style="color: red">(hóa đơn)</span></td>
                    <td style="text-align: right; font-size: 25px">
                        {{ number_format($tongThu) }}<sup>đ</sup>
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 18px">Tổng thu<br><span style="color: red">(khoản tiền khác)</span></td>
                    <td style="text-align: right; font-size: 25px">
                        {{ number_format($tongThu2) }}<sup>đ</sup>
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 18px">
                        Tổng thu <br> <span style="color: red">(tất cả)</span>
                    </td>
                    <td style="text-align: right; font-size: 25px">
                        {{ number_format($tongThu2 + $tongThu) }}<sup>đ</sup>
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 18px">Tổng Chi</td>
                    <td style="text-align: right; font-size: 25px">
                        {{ number_format($tongChi) }}<sup>đ</sup>
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 18px">Dư</td>
                    <td style="text-align: right; font-size: 25px">
                        {{ number_format($tongThu + $tongThu2 - $tongChi) }}<sup>đ</sup>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="modal fade" id="billAdd">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Thêm chi tiêu</h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
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
                                    <input id="formattedNumberField" required="required" placeholder="Số tiền chi tiêu" type="text" class="form-control input-control" name="money">
                                </td>
                            </tr>
                            <tr>
                                <td>Chọn ngày</td>
                                <td>
                                    <input value="{{ date('Y-m-d') }}" type="date" class="form-control input-control" name="date">
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <input class="btn btn-primary button-control" type="submit" value="THÊM" name="">
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
    <div class="modal fade" id="thu-nhap">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Thêm thu nhập</h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('income.add') }}">
                        @csrf
                        <table class="add-bill" style="width: 100%">
                            <tr>
                                <td>Nội dung thu</td>
                                <td>
                                    <textarea required="required" placeholder="Nội dung chi tiêu" name="content" class="form-control"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>Tổng tiền</td>
                                <td>
                                    <input required="required" placeholder="Số tiền chi tiêu" type="text" class="form-control input-control formattedNumberField" name="money">
                                </td>
                            </tr>
                            <tr>
                                <td>Chọn ngày</td>
                                <td>
                                    <input value="{{ date('Y-m-d') }}" type="date" class="form-control input-control" name="date">
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <input class="btn btn-primary button-control" type="submit" value="THÊM" name="">
                                </td>
                            </tr>
                            
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="expense-edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Sửa thu-chi</h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
