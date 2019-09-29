<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <base href="{{ asset('/') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/mobile/mobile.css') }}">
        <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('/font/fontawesome-free-5.10.0-web/css/all.css') }}" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
        <link rel="stylesheet" type="text/css" href="{{ asset('/js/datepicker/css/lightpick.css') }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="{{ asset('/js/jquery.min.js') }}"></script>
        <script src="{{ asset('/js/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('/js/mobile/mobile.js') }}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/client/slick.css') }}">
        <script src="{{ asset('/js/client/slick.js') }}"></script>
    
<!-- thư hiện lightpick -->
        <script async src="{{ asset('/js/datepicker/js/button.js') }}"></script>
        <script src="{{ asset('/js/datepicker/js/moment.min.js') }}"></script>
        <script src="{{ asset('/js/datepicker/js/lightpick.js') }}"></script>
        <script src="{{ asset('/js/datepicker/js/demo.js') }}"></script>
    <!-- end -->
    </head>
    <body>
        @if (auth('employees')->check())
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
                                        @if (auth('employees')->user()->full_name == '')
                                            {{ auth('employees')->user()->phone }}
                                        @else
                                            {{ auth('employees')->user()->full_name }}
                                        @endif
                                    </p>
                                    <p style="color: #ffd800">
                                        {{ substr(auth('employees')->user()->phone, 0, 4) }}.{{ substr(auth('employees')->user()->phone, 4, 3) }}.{{ substr(auth('employees')->user()->phone, 7, 3) }}
                                    </p>
                                </td>
                                <td style="text-align: right; text-align: center;">
                                    <a style="color: #fff" href="{{ route('mobile.employee.logout') }}"><i class="fas fa-power-off" style="font-size: 25px"></i>
                                    <br>Đăng xuất</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        @endif

