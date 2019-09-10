@extends('admin.layouts.index')

@section('content')
    <div class="row employee-add" style="padding-left: 40px; padding-top: 40px">
        <div class="col-lg-7">
            <h2>DANH SÁCH KHÁCH HÀNG</h2><br>
            @if (session('thongbao'))
                <div class="alert alert-success">
                    {{ session('thongbao') }}
                </div>
            @endif
                <button type="button" class="btn btn-primary" style="float: right; margin-bottom: 20px" data-toggle="modal" data-target="#myModal">
                    Nạp tiền
                </button>
                <!-- The Modal -->
            <div class="modal fade" id="myModal">
                <div class="modal-dialog">
                  <div class="modal-content">
                  
                    <!-- Modal Header -->
                    <div class="modal-header">
                      <h4 class="modal-title">Nạp tiền khách hàng</h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                        <form method="post" action="{{ route('customer.list') }}">
                            @csrf
                            <table>
                                <tr>
                                    <td>
                                        Chọn khách hàng
                                    </td>
                                    <td>
                                        :
                                    </td>
                                    <td>
                                        <style type="text/css">
                                            .dropdown-item.active, .dropdown-item:active {
                                                color: #000 !important;
                                            }
                                        </style>
                                        <select name="customer_id" class="selectpicker form-control" data-live-search="true" data-width="fit" tabindex="-98">
                                            @foreach ($customerList as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->phone }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Số tiền
                                    </td>
                                    <td>
                                        :
                                    </td>
                                    <td>
                                        <input required="required" id="formattedNumberField" type="text" class="form-control" name="money">
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <button class="btn btn-primary" type="submit">Nạp</button>
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
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Tên</th>
                        <th scope="col">Số điện thoại</th>
                        <th scope="col">Ngày sinh</th>
                        <th scope="col">Số dư</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $stt = 0;
                    @endphp
                    @foreach ($customerList as $customer)
                        <tr>
                            <th scope="row">
                                {{ ++$stt }}
                            </th>
                            <td>
                                {{ $customer->full_name }}
                            </td>
                            <td>
                                {{ $customer->phone }}
                            </td>
                            <td>
                                {{ date('d/m/Y', strtotime($customer->birthday)) }}
                            </td>
                            <td style="text-align: right;">
                                {{ number_format($customer->balance) }}<sup>đ</sup>
                            </td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table> 
        </div>
        <div class="col-lg-7">
            {{ $customerList->links() }}
            <style type="text/css">
                .pagination {
                    float: right;
                }
            </style>
        </div>
    </div>
@endsection