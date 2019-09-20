@extends('client.mobile.layouts.index')

@section('content')
    <div class="container" style="background: #000">
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
                            <div class="modal-header" style="border: 0px">
                                <h4 class="modal-title">Nhập số điện thoại</h4>
                                <button style="margin: 0px" type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form method="post" onsubmit="return validatePhone()" action="{{ route('post.login') }}">
                                    @csrf
                                    <input class="phone-mobile phone" type="text" name="phone"><br>
                                    <input class="submit" type="submit" value="TIẾP" name="">
                                </form>
                            </div>
                        </div>
                    </div>
                  </div>
            </div>
        </div>
    </div>
@endsection