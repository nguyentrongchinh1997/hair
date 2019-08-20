@extends('admin.layouts.index')

@section('content')
    <div class="row employee-add" style="padding-left: 40px; padding-top: 40px">
        <div class="col-lg-10">
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
            <h3>Danh sách nhân viên</h3>
            <!-- Button to Open the Modal -->
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
                                    Loại nhân viên
                                </td>
                                <td>
                                    :
                                </td>
                                <td>
                                    <select name="type" class="form-control">
                                        <option value="0">Gội</option>
                                        <option value="1">Cắt</option>
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
                                    Hoa hồng 
                                </td>
                                <td>
                                    :
                                </td>
                                <td>
                                    <input type="number" value="{{ old('percent') }}" name="percent" class="form-control">
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
            <table class="table table-striped">
              <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Tên</th>
                    <th scope="col">Số điện thoại</th>
                    <th scope="col">Loại nhân viên</th>
                    <th scope="col">Địa chỉ</th>
                    <th scope="col">Phần trăm hưởng</th>
                    <th scope="col">Trạng thái làm việc</th>
                    <th scope="col">Sửa</th>
                </tr>
              </thead>
              <tbody>
                @php $stt = 0; @endphp
                @foreach ($employeeList as $employee)
                    <tr>
                        <th scope="row">{{ ++$stt }}</th>
                        <td style="font-weight: bold;">
                            {{ $employee->full_name }}
                        </td>
                        <td>
                            {{ $employee->phone }}
                        </td>
                        <td>
                            {{
                                ($employee->type == config('config.employee.type.skinner')) ? 'Gội' : 'Cắt' 
                            }}
                        </td>
                        <td>
                            {{ $employee->address }}
                        </td>
                        <td style="text-align: center;">
                            {{ $employee->percent }} %
                        </td>
                        <td style="text-align: center;">
                            <span style="{{($employee->status == config('config.employee.status.doing')) ? 'color: #4c9d2f; font-weight: bold;' : 'color: red; font-weight: bold;' }}">
                                {{
                                    ($employee->status == config('config.employee.status.doing')) ? 'Đang làm việc' : 'Đã nghỉ làm' 
                                }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('employee.edit', ['id' => $employee->id]) }}">
                                Sửa
                            </a>
                        </td>
                    </tr>
                @endforeach
              </tbody>
            </table>
        </div>
    </div>
@endsection