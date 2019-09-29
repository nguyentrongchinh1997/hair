<!DOCTYPE html>
<html>
    <head>
        <title>Salon</title>
        <base href="{{ asset('/') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/mobile/mobile.css') }}">
        <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('/font/fontawesome-free-5.10.0-web/css/all.css') }}" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="{{ asset('/js/jquery.min.js') }}"></script>
        <script src="{{ asset('/js/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('/js/mobile/mobile.js') }}"></script>

    </head>
    <body style="@if(Request::is('mobile/dang-nhap'))@php echo 'background: #000;';@endphp@endif">
        @if (auth('customers')->check())
            @if (session('thongbao'))
                <div class="animated fadeInLeftBig row book-notification">
                    <i class="fas fa-times"></i>
                    <p>
                        {{ session('thongbao') }}
                    </p>
                </div>
            @endif
            <div class="row top-header">
                <div class="container">
                    <div class="col-12" style="padding: 10px 0px">
                        <table>
                            <tr>
                                <td style="width: 20%">
                                    <img src="{{ asset('/image/user.png') }}" style="width: 70px; border-radius: 70px">
                                </td>
                                <td style="padding-left: 20px">
                                    <p style="text-transform: uppercase;">
                                        @if (auth('customers')->user()->full_name == '')
                                            {{ auth('customers')->user()->phone }}
                                        @else
                                            {{ auth('customers')->user()->full_name }}
                                        @endif
                                    </p>
                                    <p style="color: #ffd800">Số dư: {{ auth('customers')->user()->balance }}</p>
                                </td>
                                <td style="text-align: right; text-align: center;">
                                    <a style="color: #fff" href="{{ route('mobile.logout') }}"><i class="fas fa-power-off" style="font-size: 25px"></i>
                                    <br>Đăng xuất</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        @endif
