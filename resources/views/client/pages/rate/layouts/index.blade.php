<!DOCTYPE html>
<html>
    <head>
        <title>Đánh giá của khách hàng</title>
        <base href="{{ asset('/') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/font/fontawesome-free-5.10.0-web/css/all.css') }}">
        <script src="{{ asset('/js/jquery.min.js') }}"></script>
        <!-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> -->
        <style type="text/css">
            .row{
                margin: 0px !important;
            }
        </style>
        <script>
            function startTime() {
              var today = new Date();
              var h = today.getHours();
              var m = today.getMinutes();
              var s = today.getSeconds();
              m = checkTime(m);
              s = checkTime(s);
              document.getElementById('txt').innerHTML =
              h + ":" + m + ":" + s;
              var t = setTimeout(startTime, 500);
            }
            function checkTime(i) {
              if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
              return i;
            }
        </script>
    </head>
    <body onload="startTime()">
        @include('client.pages.rate.layouts.header')
        @yield('content')
    </body>
</html>
