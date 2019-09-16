@extends('client.layouts.index')

@section('content')
<div class="row">
    <div id="demo" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ul class="carousel-indicators">
        <li data-target="#demo" data-slide-to="0" class="active"></li>
        <li data-target="#demo" data-slide-to="1"></li>
        <li data-target="#demo" data-slide-to="2"></li>
      </ul>
      
      <!-- The slideshow -->
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="https://storage.30shine.com/banner_web_summer_remix.jpg" alt="Los Angeles" width="1100" height="500">
        </div>
        <div class="carousel-item">
          <img src="https://storage.30shine.com/banner/khai_truong_20190814_w.jpg" alt="Chicago" width="1100" height="500">
        </div>
        <div class="carousel-item">
          <img src="https://storage.30shine.com/banner/20190620_Shinemember_web.jpg" alt="New York" width="1100" height="500">
        </div>
      </div>
      
      <!-- Left and right controls -->
      <a class="carousel-control-prev" href="#demo" data-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </a>
      <a class="carousel-control-next" href="#demo" data-slide="next">
        <span class="carousel-control-next-icon"></span>
      </a>
    </div>
    <div class="input-sologan">
        <form method="post" action="{{ route('post.phone') }}">
        @csrf
            <div class="input-phone" style="background: #fff">
                <div class="input-text">
                    <div class="icon">
                        <img width="40px" height="40px" src="https://v3.30shine.org/data/images/Trangchu/item_call.png" alt="Icon">
                        <img style="width:1px; height:40px; margin-left: 5px" src="https://v3.30shine.org/data/images/Trangchu/gachh.png" alt="Icon" class="right">
                        <input placeholder="* Nhập số điện thoại..." type="tel" name="phone" value=""> 
                    </div>
                </div>
                <div style="display: flex; text-align: center; margin-top: 10px;">
                    <div class="btn-booking">
                        <div>
                            <button type="submit" name="action" value="submit-phone" class="booking-text">
                                ĐẶT LỊCH GIỮ CHỖ &nbsp;<img src="https://v3.30shine.org/data/images/click1.png" alt="click" style="width: 30px; height: 30px; margin-bottom: 5px; vertical-align: middle;">
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <style type="text/css">
        .input-sologan .input-phone .btn-booking {
            padding: 10px 5px;
            width: 100%;
            color: #fff;
            background: #1b1b1b;
            cursor: pointer;
        }
        .input-phone {
            padding: 10px;
        }
        .input-sologan{
            position: absolute;
            max-width: 400px;
            bottom: 10%;
            left: 0;
            right: 0;
            z-index: 2;
            margin: 0 auto;
        }
        .input-sologan .input-phone .input-text, .input-sologan .input-phone .input-text .icon {
            display: -webkit-flex;
            display: flex;
            width: 100%;
        }
        .input-sologan .input-phone .input-text, .input-sologan .input-phone .input-text .icon ::placeholder {
            color: #727272;
            font-weight: bold;
        }
        .input-sologan .input-phone .btn-booking .booking-text {
            font-size: 30px;
            line-height: 40px;
            border: 0px;
            background: #1b1b1b;
            color: #fff;
            outline: none;
            cursor: pointer;
        }
        .input-sologan .input-phone .input-text input {
            font-weight: bold;
            outline: none;
            font-family: font_Cafeta;
            color: #1b1b1b;
            font-size: 25px;
            height: 40px;
            border-radius: 3px;
            border: none;
            width: 100%;
            padding-left: 5px;
        }
    </style>
</div>
@endsection