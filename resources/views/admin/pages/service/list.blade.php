@extends('admin.layouts.index')

@section('content')
    <div class="row employee-add" style="padding-left: 40px; padding-top: 40px">
        <div class="col-lg-7">
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
            <button style="float: right; margin-bottom: 20px" type="button" class="btn btn-primary button-control" data-toggle="modal" data-target="#myModal">
            Thêm dịch vụ
          </button><br>
          <!-- The Modal -->
            <div class="modal fade" id="myModal">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h3 class="modal-title">Thêm dịch vụ</h3>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ route('service.add') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <style type="text/css">
                                table{
                                    width: 100%;
                                }
                                table tr td:nth-child(1){
                                    background: #fafafa;
                                }
                                table tr td{
                                    border: 1px solid #e5e5e5;
                                }
                            </style>
                            <table class="list-table">
                                <tr>
                                    <td>
                                        Tên dịch vụ
                                    </td>
                                    <td>
                                        <input placeholder="Nhập tên dịch vụ..." type="text" class="form-control input-control" required="required" value="{{ old('name') }}" name="name">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Giá
                                    </td>
                                    <td>
                                        <input placeholder="Nhập giá dịch vụ..." type="text" id="formattedNumberField" class="form-control input-control" required="required" name="price">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Chiết khấu thợ chính (%)<br>
                                        <span style="color: red">(Khách không yêu cầu)</span>
                                    </td>
                                    <td>
                                        <input type="text" placeholder="Nhập %" class="form-control input-control" required="required" name="percent">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Chiết khấu thợ chính (%)<br>
                                        <span style="color: red">(Khách yêu cầu)</span>
                                    </td>
                                    <td>
                                        <input type="text" placeholder="Nhập %" class="form-control input-control" required="required" name="main_request_percent">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Chiết khấu thợ phụ (%)</td>
                                    <td>
                                        <input type="text" placeholder="Nhập %" class="form-control input-control" required="required" name="assistant_percent">
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
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                    
                  </div>
                </div>
            </div><br>
            <table class="list-table">
                  <thead>
                    <tr style="background: #BBDEFB">
                        <th scope="col">STT</th>
                        <th scope="col">Tên dịch vụ</th>
                        <th style="text-align: center;" scope="col">Giá</th>
                        <th style="text-align: center;" scope="col">
                            Thợ chính (%) <br>
                        </th>
                        <th style="text-align: center;" scope="col">
                            Thợ chính (%)<br> (yêu cầu khách) 
                        </th>
                        <th style="text-align: center;" scope="col">
                            Thợ phụ (%)
                        </th>
                        <th scope="col">Sửa</th>
                        <th scope="col">
                            Xóa
                        </th>
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
                            <td style="text-align: center;">
                                {{ $service->main_request_percent }} %
                            </td>
                            <td style="text-align: center;">
                                {{ $service->assistant_percent }} %
                            </td>
                            <td style="text-align: center;">
                                <button onclick="editService({{ $service->id }})" type="button" class="btn btn-primary input-control" data-toggle="modal" data-target="#edit">
                                    <i class="far fa-edit"></i>
                                </button>
                            </td>
                            <td style="text-align: center;">
                                @if ($service->id != config('config.service.cut') && $service->id != config('config.service.wash'))
                                <a onclick="return deleteService()" href="{{ route('service.delete', ['id' => $service->id]) }}" style="color: red;">
                                    <i class="fas fa-times"></i>
                                </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                  </tbody>
            </table><br>
            {{ $serviceList->links() }}
            <style type="text/css">
                .pagination{
                    float: right;
                }
            </style>
            <div class="modal fade" id="edit">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h3 class="modal-title">Sửa dịch vụ</h3>
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