@extends('admin.layouts.index')

@section('content')
    <div class="row employee-add" style="padding-left: 40px; padding-top: 40px">
        <div class="col-lg-6" style="background: #fafafa; border: 1px solid #e5e5e5; padding: 15px">
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
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <input type="hidden" id="date" value="{{ $year }}-{{ $month }}" name="">
            <div class="row">
                <div class="col-lg-5" style="padding: 0px">
                    <input type="hidden" id="type" value="{{$type}}" name="">
                    <input type="hidden" id="date-search" value="@if ($type == 'month'){{ $year }}-{{$month}} @elseif ($type == 'between'){{ $date_start }}-{{ $date_end }}@endif" name="">
                    <form method="post" action="{{ route('commision.time') }}?type=month">
                        @csrf
                        <h3>Xem lương theo tháng</h3>
                        <table>
                            <tr>
                                <td>
                                    <select name="month" class="form-control input-control">
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option @if ($i == $month) {{ 'selected' }} @endif value="@if ($i < 10) 0{{ $i }} @else {{ $i }} @endif">
                                                Tháng {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </td>
                                <td>
                                    <select name="year" class="form-control input-control">
                                        @for ($i = 2019; $i <= date('Y'); $i++)
                                            <option @if ($i == $year) {{ 'selected' }} @endif value="{{ $i }}">
                                                Năm {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </td>
                                <td>
                                    <input value="Xem" class="btn btn-primary input-control" type="submit" name="">
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="col-lg-7">
                    <form method="post" action="{{ route('commision.time') }}?type=between">
                        @csrf
                        <h3>Xem lương theo ngày</h3>
                        <table style="width: 100%">
                            <tr>
                                <td>
                                    <div class="input-group-prepend">
                                      <div class="input-group-text input-control">Từ</div>
                                    </div>
                                </td>
                                <td>
                                    <input placeholder="dd/mm/yyyy" value="{{ $date_start }}" type="text" id="demo-3_1" class="form-control form-control-sm date-pick" name="date_start">
                                </td>
                                <td>
                                    <div class="input-group-prepend">
                                      <div class="input-group-text input-control">Đến</div>
                                    </div>
                                </td>
                                <td>
                                    <input placeholder="dd/mm/yyyy" value="{{ $date_end }}" type="text" id="demo-3_2" class="form-control form-control-sm date-pick" name="date_end">
                                </td>
                                <td>
                                    <input value="Xem" class="btn btn-primary input-control" type="submit">
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div><br>
            <div class="row">
                <div class="col-lg-8" style="padding: 0px">
                    <h3>Tìm kiếm tại đây:</h3>
                    <div class="input-group">
                        <input type="text" id="name-employee" class="form-control" placeholder="Nhập tên nhân viên...">
                        <div class="input-group-append">
                          <button class="btn btn-secondary" type="button">
                            <i class="fas fa-search"></i>
                          </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4" style="padding: 0px">
                    <button style="margin-top: 30px; float: right;" type="button" class="btn btn-primary button-control" data-toggle="modal" data-target="#myModal">
                    Thêm nhân viên
                    </button>
                </div>
            </div>
            <div class="modal fade" id="myModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                          <h3 class="modal-title">Thêm nhân viên</h3>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form onsubmit="return validateEmployeeAdd()" method="post" action="{{ route('employee.add') }}" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <table class="list-table">
                                    <tr>
                                        <td>
                                            Tên nhân viên
                                        </td>
                                        <td>
                                            <input placeholder="Nhập tên nhân viên..." type="text" class="form-control input-control" required="required" id="employee-name" name="full_name">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Số điện thoại
                                        </td>
                                        <td>
                                            <input id="employee-phone" placeholder="Nhập số điện thoại..." type="text" class="form-control input-control" required="required" name="phone">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Làm dịch vụ
                                        </td>
                                        <td>
                                            <select name="type" class="form-control input-control">
                                                <option value="1">Cắt</option>
                                                <option value="2">Gội</option>
                                                <!-- @foreach ($serviceList as $service)
                                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                                @endforeach -->
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Địa chỉ
                                        </td>
                                        <td>
                                            <input id="employee-address" placeholder="Nhập địa chỉ..." type="text" class="form-control input-control" name="address">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Lương (vnđ)
                                        </td>
                                        <td>
                                            <input placeholder="Nhập lương cứng nhân viên" id="formattedNumberField" type="text" name="salary" class="form-control input-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Ảnh đại diện</td>
                                        <td>
                                            <input required="required" type="file" class="form-control input-control" name="image">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Mật khẩu đăng nhập 
                                        </td>
                                        <td>
                                            <input placeholder="Nhập mật khẩu nhân viên..." type="password" id="employee-password" name="password" class="form-control input-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <input class="btn btn-primary button-control" value="Thêm" type="submit" name="">
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
            </div><br>            
            <div class="modal fade" id="edit">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h3 class="modal-title">Sửa nhân viên</h3>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body edit-employee">
                        
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                    
                  </div>
                </div>
            </div>
            <div class="row">
                <h3>
                    @if ($type == 'month')
                        Lương nhân viên tháng <span style="font-weight: bold; color: #007bff">{{ $month }}/{{ $year }}</span> :
                    @elseif ($type == 'between')
                        Lương nhân viên từ <span style="font-weight: bold; color: #007bff">{{ $date_start }}</span> đến <span style="font-weight: bold; color: #007bff">{{ $date_end }}</span>
                    @endif
                </h3>
            </div><br>
            <div class="row" style="height: 400px; overflow: auto;">
                <table class="list-table">
                    <thead>
                        <tr style="background: #BBDEFB">
                            <th scope="col">STT</th>
                            <th scope="">Ảnh</th>
                            <th scope="col">Tên</th>
                            <th scope="col">Sđt</th>
                            <th scope="col">Vị trí</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Hoa hồng</th>
                            <th scope="col">Tổng lương</th>
                            <th scope="col">Sửa</th>
                        </tr>
                    </thead>
                    <tbody id="result-search">
                        <tr style="background: #fcf8e3; font-weight: bold;">
                            <td class="tong" colspan="8" style="text-align: right; color: #007bff; font-size: 18px">
                                
                            </td>
                            <td></td>
                        </tr>
                        @php $stt = 0; $totalAll = 0; @endphp
                        @foreach ($employeeList as $employee)
                            <tr title="Click để xem chi tiết" style="cursor: pointer;" onclick="employeeDetail({{ $employee->id }})" class="employee" id="employee{{ $employee->id }}">
                                <td scope="row">{{ ++$stt }}</td>
                                <td>
                                    <img src='{{ asset("upload/images/employee/$employee->image") }}' width="50px">
                                </td>
                                <td>
                                    {{ $employee->full_name }}
                                </td>
                                <td>
                                    {{ substr($employee->phone, 0, 4) }}.{{ substr($employee->phone, 4, 3) }}.{{ substr($employee->phone, 7) }}
                                </td>
                                <td>
                                    {{ $employee->service->name }}
                                </td>
                                <td style="text-align: center;">
                                    <span style="{{($employee->status == config('config.employee.status.doing')) ? 'color: #4c9d2f; font-weight: bold;' : 'color: red; font-weight: bold;' }}">
                                        {{
                                            ($employee->status == config('config.employee.status.doing')) ? 'Đang làm việc' : 'Đã nghỉ làm' 
                                        }}
                                    </span>
                                </td>
                                <td style="text-align: right;">
                                    @php 
                                        $commisionTotal = 0;
                                    @endphp
                                    @foreach ($employee->employeeCommision as $commision)
                                        @if ($commision->billDetail->bill->status == config('config.order.status.check-out'))
                                            @php
                                                $commisionTotal = $commisionTotal + $commision->percent/100 * $commision->billDetail->money
                                            @endphp
                                        @endif
                                    @endforeach
                                    {{ number_format($commisionTotal) }}<sup>đ</sup>
                                </td>
                                <td style="text-align: right; font-weight: bold;">
                                    @if (isset($type) && $type == 'month')
                                        {{ number_format($commisionTotal + $employee->salary) }}<sup>đ</sup>
                                    @elseif (isset($type) && $type == 'between')
                                        {{ number_format($commisionTotal) }}<sup>đ</sup>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <button style="border: 1px solid #ccc; outline: none;" onclick="editEmployee({{ $employee->id }})" type="button" class="button-control" data-toggle="modal" data-target="#edit">
                                        <i class="far fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                                @if (isset($type) && $type == 'month')
                                    @php 
                                        $totalAll = $totalAll +  ($commisionTotal + $employee->salary);
                                    @endphp
                                @elseif (isset($type) && $type == 'between')
                                    @php
                                        $totalAll = $totalAll +  $commisionTotal;
                                    @endphp
                                @endif
                        @endforeach
                        <tr style="display: none;">
                            <td id="tong" colspan="7">
                                {{ number_format($totalAll) }}<sup>đ</sup>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="row">
                <div class="col-lg-12 employee-detail"></div>
            </div>
        </div>
        <div class="col-lg-10">
            <style type="text/css">
                .pagination{
                    float: right;
                }
            </style>
            
        </div>
    </div>
@endsection
