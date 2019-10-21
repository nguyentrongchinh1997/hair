<!DOCTYPE html>
<html>
    <head>
        <title>Trang quản trị Admin</title>
        <base href="{{ asset('/') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/client/style.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/client/responsive.css') }}">
        <link rel="stylesheet" href="{{ asset('/font/fontawesome-free-5.10.0-web/css/all.css') }}" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
        <script src="{{ asset('/js/jquery.min.js') }}"></script>
        <script src="{{ asset('/js/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('/js/client/client.js') }}"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/client/slick.css') }}">
        <script src="{{ asset('/js/client/slick.js') }}"></script>
    </head>
    <body>
        <header>
            @if (auth('customers')->check())
                @if (session('thongbao'))
                    <div class="row notification-book">
                        <i class="fas fa-times"></i>
                        <p>
                            {{ session('thongbao') }}
                        </p>
                    </div>
                @endif
            @endif
            <div class="row top-header">
                <div class="container">
                    <center>
                        <img src="{{ asset('/image/logo.webp') }}">
                    </center>
                </div>
            </div>
            <div class="row menu-mobile">
                <div class="container">
                    <i class="fas fa-bars nav-bar"></i>
                    <div class="list-menu-mobile">
                        <ul>
                            <a style="line-height: 50px; color: #fff">
                                <i class="far fa-window-close exit" style="float: left; padding-left: 20px"></i>
                                <li style="font-size: 20px; background: #353535; text-align: right; padding-right: 40px">Menu</li>
                            </a>
                            <a href="">
                                <li>TRANG CHỦ</li>
                            </a>
                            @if (auth('customers')->check())
                                <a href="">
                                    <li>SỐ DƯ: {{ number_format(auth('customers')->user()->balance) }}<sup>đ</sup></li>
                                </a>
                                <a>
                                    <li>{{ auth('customers')->user()->full_name }} | <span><a style="color: #727272" href="logout">ĐĂNG XUẤT</a></span></li>
                                </a>
                            @endif
                            
                        </ul>
                    </div>
                    
                </div>
            </div>
            <div class="row menu">
                <div class="container" style="padding: 0px">
                    <div class="col-lg-12" style="padding: 0px">
                        <ul>
                            <a href="{{ asset('/') }}">
                                <li>
                                    <i class="fas fa-home"></i> Trang chủ
                                </li>
                            </a>
                            <a href="">
                                <li>Dịch Vụ</li>
                            </a>
                            @if (auth('customers')->check())
                                <a href="logout" style="float: right;">
                                    <li style="color: #727272">Đăng xuất</li>
                                </a>
                                <a style="float: right; border-right: 1px solid #e5e5e5">
                                    <li style="color: #727272">
                                        @if (auth('customers')->user()->full_name != '')
                                        {{ auth('customers')->user()->full_name }}
                                        @else
                                            {{ substr(auth('customers')->user()->phone, 0, 4) }}.{{ substr(auth('customers')->user()->phone, 4, 3) }}.{{ substr(auth('customers')->user()->phone, 7, 3) }}
                                        @endif
                                    </li>
                                </a>
                                <a style="float: right; border-right: 1px solid #e5e5e5">
                                    <li>Số dư: {{ number_format(auth('customers')->user()->balance) }}<sup>đ</sup></li>
                                </a>
                                
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </header>
