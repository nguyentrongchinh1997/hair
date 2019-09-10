<!DOCTYPE html>
<html>
    <head>
        <title>Login Salon</title>
        <base href="{{ asset('/') }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/mobile/mobile.css') }}">
        <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('/font/fontawesome-free-5.10.0-web/css/all.css') }}" crossorigin="anonymous">
        <script src="{{ asset('/js/jquery.min.js') }}"></script>
        <script src="{{ asset('/js/bootstrap/js/bootstrap.min.js') }}"></script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-lg-12" style="margin-top: 50px">
                    <div style="max-width: 500px; margin: auto;">
                        <center>
                            <img src="{{ asset('/image/logo.webp') }}">
                        </center><br><br><br>
                        <div style="max-width: 61%; margin: auto;">
                            <h6 style="font-weight: bold;">TRẢI NGHIỆM TIỆN ÍCH CÙNG 30SHINE</h6>
                            <p>
                                <i class="fas fa-check"></i> Đặt lịch nhanh chóng
                            </p>    
                            <p>
                                <i class="fas fa-check"></i> Đăng nhập dễ dàng, không lo quên mật khẩu
                            </p>
                        </div>
                        <center>
                            <button class="login" data-toggle="modal" data-target="#myModal">
                                Đăng nhập bằng số điện thoại
                            </button>
                            <p style="margin-top: 30px">
                                Copyright 2019 30Shine, Inc. All Rights Reserved
                            </p>
                        </center>
                    </div>
                      <!-- The Modal -->
                      <div class="modal fade" id="myModal" style="background: #fff">
                        <div class="modal-dialog">
                            <div class="modal-content" style="border: 0px">
                                <!-- Modal Header -->
                                <div class="modal-header" style="border: 0px">
            <!--                         <div class="col-xs-1 col-lg-1">
                                        <script type="text/javascript">
                                            $(function(){
                                                $('.exit').click(function(){
                                                    $('.modal').removeClass('show');
                                                    $('.modal-backdrop').removeClass('show');
                                                    $('body').attr('class', '');
                                                })
                                            })
                                        </script>
                                        <span class="exit">x</span>
                                        <button style="margin: 0px" type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div> -->
                                    <!-- <div class="col-xs-11 col-lg-11"> -->
                                        <h4 class="modal-title">Nhập số điện thoại</h4>
                                        <button style="margin: 0px" type="button" class="close" data-dismiss="modal">&times;</button>
                                    <!-- </div> -->
                                
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <form>
                                        <input class="phone" type="text" name=""><br>
                                        <input class="submit" type="submit" value="Tiếp" name="">
                                    </form>
                                </div>
                            </div>
                        </div>
                      </div>
                </div>
            </div>
        </div>
    </body>
</html>