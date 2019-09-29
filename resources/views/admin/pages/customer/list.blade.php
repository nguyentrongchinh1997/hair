@extends('admin.layouts.index')

@section('content')
    <div class="row employee-add" style="padding-left: 40px; padding-top: 40px">
        <div class="col-lg-6">
            <div class="col-lg-12">
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
                                    {{ date('d/m/Y', strtotime($customer->birthday)) }}
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
@endsection
