<!DOCTYPE html>
<html>
    <head>
        <title>Trang quản trị Admin</title>
        <base href="{{ asset('/') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/font/fontawesome-free-5.10.0-web/css/all.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/admin/style.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/admin/choosen.css') }}">  
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">

    </head>
    <body>
        <header>
            <div class="row menu">
                <div class="col-lg-12">
                    <ul>
                        <a href="{{ route('order.list') }}">
                            <li @if(Request::is('admin/dat-lich/danh-sach')) {{"class=menu-active"}} @endif>
                                LỊCH ĐẶT
                            </li>
                        </a>
                        <a href="{{ route('bill.list') }}">
                            <li @if(Request::is('admin/hoa-don/danh-sach')) {{"class=menu-active"}} @endif>
                                HÓA ĐƠN
                            </li>
                        </a>
                        <a href="{{ route('service.list') }}">
                            <li @if(Request::is('admin/dich-vu/danh-sach')) {{"class=menu-active"}} @endif>
                                DỊCH VỤ
                            </li>
                        </a>
                        <a href="{{ route('customer.list') }}">
                            <li @if(Request::is('admin/khach-hang/danh-sach')) {{"class=menu-active"}} @endif>
                                QL.KHÁCH HÀNG
                            </li>
                        </a>
                        <a href="{{ route('employee.list') }}">
                            <li @if(Request::is('admin/nhan-vien/danh-sach')) {{"class=menu-active"}} @endif>
                                QL.NHÂN VIÊN
                            </li>
                        </a>
                        <a href="{{ route('rate.list') }}">
                            <li @if(Request::is('admin/danh-gia/danh-sach')) {{"class=menu-active"}} @endif>
                                ĐÁNH GIÁ
                            </li>
                        </a>
                        <a href="{{ route('card.list') }}">
                            <li @if(Request::is('admin/the/danh-sach')) {{"class=menu-active"}} @endif>
                                QL.THẺ
                            </li>
                        </a>
                        <a href="{{ route('expense.list') }}">
                            <li @if(Request::is('admin/chi-tieu/danh-sach')) {{"class=menu-active"}} @endif>
                                QL.THU-CHI
                            </li>
                        </a>

                        @if (auth()->check())
                            <a style="float: right;" href="{{ route('logout') }}">
                                <li>
                                    Đăng xuất
                                </li>
                            </a>
                            <a style="float: right;">
                                <li>
                                    {{ auth()->user()->name }}
                                </li>
                            </a>
                        @elseif (auth('employees')->check())
                            <a style="float: right;" href="{{ route('logout') }}">
                                <li>
                                    Đăng xuất
                                </li>
                            </a>
                            <a style="float: right;">
                                <li>
                                    {{ auth('employees')->user()->full_name }}
                                </li>
                            </a>
                        @endif
                    </ul>
                </div>
            </div>
        </header>
        