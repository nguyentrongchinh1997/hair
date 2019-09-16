@extends('admin.layouts.index')

@section('content')
    <div class="row employee-add" style="padding-left: 40px; padding-top: 40px">
        <div class="col-lg-12">
            <h2>DANH SÁCH KHÁCH HÀNG</h2><br>
        </div>
        <div class="col-lg-6">
            <div class="offset-lg-6">
                <label>Tìm kiếm tại đây:</label>
                <div class="input-group">
                    <input type="text" id="search-customer" class="form-control" placeholder="Nhập số điện thoại...">
                    <div class="input-group-append">
                      <button class="btn btn-secondary" type="button">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                </div><br>
            </div>
        </div>
        <div class="col-lg-6"></div>
        <div class="col-lg-6">
            @if (session('thongbao'))
                <div class="alert alert-success">
                    {{ session('thongbao') }}
                </div>
            @endif
            <table class="table table-bordered">
                <thead>
                    <tr>
                      <th scope="col">STT</th>
                      <th scope="col">KHÁCH HÀNG</th>
                      <th scope="col">SĐT</th>
                      <th scope="col">NGÀY SINH</th>
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
                                {{ $customer->phone }}
                            </td>
                            <td>
                                {{ date('d/m/Y', strtotime($customer->birthday)) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-lg-6 detail-customer">
            
        </div>
        <div class="col-lg-6">
            {{ $customerList->links() }}
            <style type="text/css">
                .pagination {
                    float: right;
                }
            </style>
        </div>
    </div>
@endsection
