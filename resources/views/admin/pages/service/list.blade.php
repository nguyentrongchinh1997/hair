@extends('admin.layouts.index')

@section('content')
    <div class="row employee-add" style="padding-left: 40px; padding-top: 40px">
        <div class="col-lg-5">
            <h2>DÁNH SÁCH DỊCH VỤ</h2>
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
                    <div class="modal-header">
                      <h4 class="modal-title">Thêm dịch vụ</h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
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
                                    <td>
                                        Chiết khấu (%)
                                    </td>
                                    <td>
                                        :
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" required="required" name="percent">
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
                    <th style="text-align: center;" scope="col">Giá</th>
                    <th style="text-align: center;" scope="col">Chiết khấu (%)</th>
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
                        <td style="text-align: right;">
                            {{ number_format($service->price) }}<sup>đ</sup>
                        </td>
                        <td style="text-align: center;">
                            {{ $service->percent }} %
                        </td>
                        <td>
                            <button onclick="editService({{ $service->id }})" type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit">
                                Sửa
                            </button>
                            <!-- <a href="{{ route('service.edit', ['id' => $service->id]) }}">
                                Sửa
                            </a> -->
                        </td>
                    </tr>
                @endforeach
              </tbody>
            </table>
            <div class="modal fade" id="edit">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Sửa dịch vụ</h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body edit-service">
                        
                    </div>
                    
                    <!-- Modal footer -->
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                    
                  </div>
                </div>
            </div>
        </div>
    </div>
@endsection