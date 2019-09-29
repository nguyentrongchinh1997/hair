<!DOCTYPE html>
<html>
    <head>
        <title>Trang quản trị Admin</title>
        <base href="{{ asset('/') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/font/fontawesome-free-5.10.0-web/css/all.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/admin/style.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/admin/choosen.css') }}">  
        <link rel="stylesheet" type="text/css" href="{{ asset('/js/datepicker/css/lightpick.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
    </head>
    <body>
        <header>
            <div class="row menu">
                <div class="col-lg-12">
                    <ul>
                        <a href="{{ route('order.list') }}">
                            <li @if(Request::is('admin/dat-lich/danh-sach')) {{"class=menu-active"}} @endif>
                                Lịch đặt
                            </li>
                        </a>
                        <a href="{{ route('bill.list') }}">
                            <li @if(Request::is('admin/hoa-don/danh-sach')) {{"class=menu-active"}} @endif>
                                Hóa đơn
                            </li>
                        </a>
                        <a href="{{ route('service.list') }}">
                            <li @if(Request::is('admin/dich-vu/danh-sach')) {{"class=menu-active"}} @endif>
                                Dịch vụ
                            </li>
                        </a>
                        <a href="{{ route('customer.list') }}">
                            <li @if(Request::is('admin/khach-hang/danh-sach')) {{"class=menu-active"}} @endif>
                                QL.Khách hàng
                            </li>
                        </a>
                        <a href="{{ route('employee.list') }}">
                            <li @if(Request::is('admin/nhan-vien/danh-sach')) {{"class=menu-active"}} @endif>
                                QL.Nhân viên
                            </li>
                        </a>
                        <a href="{{ route('card.list') }}">
                            <li @if(Request::is('admin/the/danh-sach')) {{"class=menu-active"}} @endif>
                                QL.Thẻ
                            </li>
                        </a>
                        <a href="{{ route('membership.list') }}">
                            <li @if(Request::is('admin/hoi-vien/danh-sach')) {{"class=menu-active"}} @endif>
                                QL.Hội viên
                            </li>
                        </a>
                        <a href="{{ route('expense.list') }}">
                            <li @if(Request::is('admin/chi-tieu/danh-sach')) {{"class=menu-active"}} @endif>
                                QL.Thu-chi
                            </li>
                        </a>
                        <a href="{{ route('rate.list') }}">
                            <li @if(Request::is('admin/danh-gia/danh-sach')) {{"class=menu-active"}} @endif>
                                Đánh giá
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
        