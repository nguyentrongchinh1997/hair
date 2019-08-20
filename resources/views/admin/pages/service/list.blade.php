@extends('admin.layouts.index')

@section('content')
    <div class="row employee-add" style="padding-left: 40px; padding-top: 40px">
        <div class="col-lg-8">
            <h3>Danh sách dịch vụ</h3>
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
            <button style="float: right;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
            Thêm dịch vụ
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
                    <form method="post" action="{{ route('service.add') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <table>
                            <tr>
                                <td>
                                    Tên dịch vụ
                                </td>
                                <td>
                                    :
                                </td>
                                <td>
                                    <input type="text" class="form-control" required="required" value="{{ old('name') }}" name="name">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Giá
                                </td>
                                <td>
                                    :
                                </td>
                                <td>
                                    <input type="text" id="formattedNumberField" class="form-control" required="required" name="price">
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
                    <th scope="col">Tên dịch vụ</th>
                    <th scope="col">Giá</th>
                    <th scope="col">Sửa</th>
                </tr>
              </thead>
              <tbody>
                @php $stt = 0; @endphp
                @foreach ($serviceList as $service)
                    <tr>
                        <th scope="row">{{ ++$stt }}</th>
                        <td>
                            {{ $service->name }}
                        </td>
                        <td>
                            {{ number_format($service->price) }}<sup>đ</sup>
                        </td>
                        <td>
                            <a href="{{ route('service.edit', ['id' => $service->id]) }}">
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