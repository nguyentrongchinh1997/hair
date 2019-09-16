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
            <h2>DANH SÁCH NHÂN VIÊN</h2>
            <input type="hidden" id="date" value="{{ $year }}-{{ $month }}" name="">
            <form method="post" action="{{ route('commision.time') }}">
                @csrf
                <table>
                    <tr>
                        <td>
                            <select name="month" class="form-control">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option @if ($i == $month) {{ 'selected' }} @endif value="@if ($i < 10) 0{{ $i }} @else {{ $i }} @endif">
                                        Tháng {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </td>
                        <td>
                            <select name="year" class="form-control">
                                @for ($i = 2019; $i <= date('Y'); $i++)
                                    <option @if ($i == $year) {{ 'selected' }} @endif value="{{ $i }}">
                                        Năm {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </td>
                        <td>
                            <input value="Xem lương" class="btn btn-primary" type="submit" name="">
                        </td>
                    </tr>
                </table>
            </form>
          <button style="float: right;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
            Thêm nhân viên
          </button><br>
          <!-- The Modal -->
            <div class="modal fade" id="myModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                          <h4 class="modal-title">Thêm nhân viên</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        
                        <!-- Modal body -->
                        <div class="modal-body">
                            <form method="post" action="{{ route('employee.add') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <table>
                                    <tr>
                                        <td>
                                            Tên nhân viên
                                        </td>
                                        <td>
                                            :
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" required="required" value="{{ old('full_name') }}" name="full_name">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Số điện thoại
                                        </td>
                                        <td>
                                            :
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" required="required" name="phone">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Làm dịch vụ
                                        </td>
                                        <td>
                                            :
                                        </td>
                                        <td>
                                            <select name="type" class="form-control">
                                                @foreach ($serviceList as $service)
                                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Địa chỉ
                                        </td>
                                        <td>
                                            :
                                        </td>
                                        <td>
                                            <input value="{{ old('address') }}" type="text" class="form-control" name="address">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Hoa hồng (%)
                                        </td>
                                        <td>
                                            :
                                        </td>
                                        <td>
                                            <input type="number" value="{{ old('percent') }}" name="percent" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Lương (vnđ)
                                        </td>
                                        <td>:</td>
                                        <td>
                                            <input id="formattedNumberField" type="text" value="{{ old('salary') }}" name="salary" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Mật khẩu đăng nhập 
                                        </td>
                                        <td>
                                            :
                                        </td>
                                        <td>
                                            <input type="password" value="{{ old('password') }}" name="password" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <input class="btn btn-primary" value="Thêm" type="submit" name="">
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
                      <h4 class="modal-title">Sửa nhân viên</h4>
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
            <div class="row" style="max-height: 500px; overflow: auto;">
                <table class="employee-list">
                    <thead>
                        <tr style="background: #BDBDBD">
                            <th scope="col">STT</th>
                            <th scope="col">TÊN</th>
                            <th scope="col">SĐT</th>
                            <th scope="col">THỢ</th>
                            <!-- <th scope="col">Địa chỉ</th> -->
                            <!-- <th scope="col">Phần trăm hưởng</th> -->
                            <th scope="col">TRẠNG THÁI</th>
                            <!-- <th scope="col">Lương cứng</th> -->
                            <th scope="col">HOA HỒNG</th>
                            <th scope="col">SỬA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $stt = 0; @endphp
                        @foreach ($employeeList as $employee)
                            <tr style="cursor: pointer;" onclick="employeeDetail({{ $employee->id }})" class="employee" id="employee{{ $employee->id }}">
                                <th scope="row">{{ ++$stt }}</th>
                                <td style="font-weight: bold;">
                                    <a href="{{ route('salary.list', ['id' => $employee->id]) }}">
                                        {{ $employee->full_name }}
                                    </a>
                                </td>
                                <td style="font-weight: bold;">
                                    {{ substr($employee->phone, 0, 4) }}.{{ substr($employee->phone, 4, 3) }}.{{ substr($employee->phone, 7) }}
                                    <!-- {{ $employee->phone }} -->
                                </td>
                                <td>
                                    {{ $employee->service->name }}
                                </td>
                                <!-- <td>
                                    {{ $employee->address }}
                                </td> -->
                                <!-- <td style="text-align: center;">
                                    {{ $employee->percent }} %
                                </td> -->
                                <td style="text-align: center;">
                                    <span style="{{($employee->status == config('config.employee.status.doing')) ? 'color: #4c9d2f; font-weight: bold;' : 'color: red; font-weight: bold;' }}">
                                        {{
                                            ($employee->status == config('config.employee.status.doing')) ? 'Đang làm việc' : 'Đã nghỉ làm' 
                                        }}
                                    </span>
                                </td>
    <!--                             <td style="text-align: right;; font-weight: bold;">
                                    {{ number_format($employee->salary) }}<sup>đ</sup>
                                </td> -->
                                <td style="color: #007bff; font-weight: bold; text-align: right;">
                                    @php 
                                        $commisionTotal = 0;
                                    @endphp
                                    @foreach ($employee->employeeCommision as $commision)
                                        @php
                                            $commisionTotal = $commisionTotal + $commision->percent/100 * $commision->billDetail->money
                                        @endphp
                                    @endforeach
                                    {{ number_format($commisionTotal) }}<sup>đ</sup>
                                </td>
                                <td>
                                    <button onclick="editEmployee({{ $employee->id }})" type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit">
                                        Sửa
                                    </button>
                                </td>
                            </tr>
                        @endforeach
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