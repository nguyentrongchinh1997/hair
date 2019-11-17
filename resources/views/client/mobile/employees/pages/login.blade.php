@extends('client.mobile.employees.layouts.index')
    
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12" style="margin-top: 50px">
                <div style="max-width: 500px; margin: auto;">
                    <center>
                        <img src="{{ asset('/image/logo.webp') }}">
                    </center><br><br><br>
                    <div style="max-width: 61%; margin: auto;">
                        <h6 style="font-weight: bold; text-align: center;">
                            Welcome
                        </h6>
                    </div><br>
                    @if(session('thongbao'))
                        <div class="alert alert-danger">
                            {{ session('thongbao') }}
                        </div>
                    @endif
                    <center>
                        <form action="{{ route('mobile.employee.post.login') }}" method="post" onsubmit="return validatePhone()">
                            @csrf
                            <div class="employee-login">
                                <div class="employees-phone">
                                    <input placeholder="Số điện thoại..." type="text" class="phone-mobile" name="phone">
                                </div>
                                <div class="employees-password">
                                    <input type="password" placeholder="Mật khẩu..." type="text" name="password">
                                </div>
                                <button>ĐĂNG NHẬP</button>
                            </div>
                        </form>
                        
                    </center>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 100px !important">
            <div class="col-lg-12">
                <center>
                    <a onclick="resetPassword()" style="color: #000">Quên mật khẩu?</a>
                </center>
                
            </div>
            
        </div>
    </div>
@endsection
