@extends('admin.layouts.index')

@section('content')
<div class="row employee-add" style="padding-left: 40px; padding-top: 40px">
    <div class="col-lg-6">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-6">
                    <label>Tìm kiếm tại đây:</label>
                    <div class="input-group">
                        <input type="text" id="search-customer" class="form-control" placeholder="Số điện thoại hoặc tên...">
                        <div class="input-group-append">
                          <button class="btn btn-secondary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                        </div>
                    </div><br>
                </div>
                <div class="col-lg-6">
                    <button style="margin-top: 30px; float: right;" type="button" class="btn btn-primary button-control" data-toggle="modal" data-target="#customer-add">
                        Thêm khách hàng
                        </button>
                </div>
            </div>
        </div>
        @if (count($errors) > 0)
        <div class="col-lg-12">
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">
                    {{ $error }}
                </div>
            @endforeach
        </div> 
        @endif
        <div class="col-lg-12">
            @if (session('thongbao'))
            <div class="alert alert-success">
                {{ session('thongbao') }}
            </div>
            @endif
            <table class="list-table">
                <thead>
                    <tr style="background: #BBDEFB">
                      <th scope="col">Stt</th>
                      <th scope="col">Khách hàng</th>
                      <th scope="col">SĐT</th>
                      <th scope="col">Ngày sinh</th>
                      <th scope="col">Số dư</th>
                  </tr>
                </thead>
                <tbody id="list-customer">
                    @php
                    $stt = 0;
                    @endphp
                    @foreach ($customerList as $customer)
                    <tr class="list-customer" onclick="customerDetail({{ $customer->id }})" id="customer{{ $customer->id }}" style="cursor: pointer;">
                        <th scope="row">{{ ++$stt }}</th>
                        <td>
                            {{ $customer->full_name }}
                        </td>
                        <td>
                            {{ substr($customer->phone, 0, 4) }}.{{ substr($customer->phone, 4, 3) }}.{{ substr($customer->phone, 7) }}
                        </td>
                        <td>
                            @if ($customer->birthday != '')
                            {{ date('d/m/Y', strtotime($customer->birthday)) }}
                            @endif
                        </td>
                        <td style="text-align: right; font-size: 18px">
                            {{ number_format($customer->balance) }}<sup>đ</sup>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-lg-12" style="margin-top: 20px">
            {{ $customerList->links() }}
            <style type="text/css">
                .pagination {
                    float: right;
                }
            </style>
        </div>
    </div>
    <div class="col-lg-6 detail-customer">

    </div>
</div>
<div class="modal fade" id="customer-add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <h3 class="modal-title">Thêm khách hàng</h3>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form onsubmit="return customerAdd()" enctype="multipart/form-data" action="{{ route('customer.add') }}" method="post">
                    @csrf
                    <table class="list-table">
                        <tr>
                            <td>
                                Tên khách hàng
                            </td>
                            <td>
                                <input required="required" placeholder="Nhập tên nhân viên..." type="text" class="form-control input-control" required="required" id="employee-name" name="full_name">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Số điện thoại
                            </td>
                            <td>
                                <input required="required" id="employee-phone" placeholder="Nhập số điện thoại..." type="text" class="form-control input-control" required="required" name="phone">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Ngày sinh
                            </td>
                            <td>
                                <input type="date" class="form-control input-control" name="birthday">
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <button class="btn btn-primary input-control">Thêm</button>
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
@endsection
