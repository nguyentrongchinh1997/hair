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
<div class="row">
    <div class="container">
        <div class="row order">
            <div class="col-lg-12">
                <!-- <center> -->
                    <form onsubmit="return validateForm()" method="post" action="{{ route('order') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <h2 style="text-align: center;"><i class="far fa-clock"></i> ĐẶT LỊCH</h2>
                        <br>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row label-input">
                                    <label>
                                        <b>NHẬP SĐT:</b>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-12 phone">
                                <input type="text" id="phone" placeholder="* VD: 096xxxxxxx" name="phone">
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="label-input">
                                    <label>
                                        <b>CHỌN DỊCH VỤ:</b>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                @foreach ($serviceList as $service)
                                <table>
                                    <tr>
                                        <td style="width: 10%">
                                            <label onclick="pickService({{ $service->id }})" style="width: 100%">
                                                <input @if ($service->id == config('config.employee.type.skinner')) {{ 'checked' }} @endif style='display: none' type="checkbox" class="service{{ $service->id }}" name="service" value="{{ $service->id }}">
                                                <div style="width: 20px; height: 20px; border: 1px solid #ccc; position: relative;">
                                                    <i id="check{{ $service->id }}" style="position: absolute; top: 3px; left: 3px; font-size: 13px; color: #000;@if ($service->id != config('config.employee.type.skinner')) {{ 'display: none' }} @endif;" class="fas fa-check check"></i>
                                                </div>
                                            </label>
                                        </td>
                                        <td style="width: 20%">
                                            @if ($service->id == 1)
                                            <img src="{{ asset('/image/cat_toc.png') }}" width="64px">
                                            @elseif ($service->id == 2)
                                            <img src="{{ asset('/image/goi_dau.png') }}" width="64px">
                                            @endif
                                        </td>
                                        <td style="width: 30%; font-size: 25px">
                                            {{ mb_strtoupper($service->name, 'UTF-8') }}
                                        </td>
                                        <td style="width: 40%; text-align: right; font-size: 18px; font-weight: bold;">
                                            <span>
                                                {{ number_format($service->price) }}<sup>đ</sup>
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                                @endforeach
                            </div>
                        </div><br>
                        <div class="row stylist">
                            <div class="col-lg-12">
                                <div class="row label-input">
                                    <label>
                                        <b>CHỌN STYLIST (nếu muốn):</b>
                                    </label>
                                </div>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="rio-promos" style="margin: 0px">
                                    @foreach ($listStylist as $stylist)
                                        <div style="padding: 10px 0px" onclick="pickStylist({{ $stylist->id }})">
                                            <input style="display: none;" class="radio-stylist stylist{{ $stylist->id }}" type="radio" value="{{ $stylist->id }}" name="employee">
                                            <img class="avatar avatar{{ $stylist->id }}" src="{{ asset('/image/default.png') }}">
                                            <p>
                                                {{ $stylist->full_name }}
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row label-input">
                                    <label>
                                        <b>CHỌN GIỜI CẮT</b>
                                    </label>
                                </div>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row time-option">
                                    @foreach ($time as $time)
                                        <div class="col-lg-3" style="padding: 5px">
                                        @if (strtotime($time->time) < strtotime(date('H:i')))
                                            <div id="pick{{ $time->id }}" class="row expired" style="background: #fff;">
                                        @else
                                            <div id="pick{{ $time->id }}" onclick="pick({{ $time->id }})" class="row expiry" style="background: #fff;">
                                        @endif
                                                <input style="display: none;" 
                                                    @if (strtotime($time->time) < strtotime(date('H:i')))
                                                        {{ 'disabled' }}
                                                    @endif 
                                                type="radio" class="time" id="checked{{ $time->id }}" value="{{ $time->id }}" name="time">
                                                <p style="font-size: 25px">{{ $time->time }}</p>
                                                <p style="font-size: 14px">
                                                    @if (strtotime($time->time) < strtotime(date('H:i')))
                                                        {{ 'Hết chỗ' }}
                                                    @else
                                                        {{ 'Còn chỗ' }} 
                                                    @endif
                                                </p>
                                                
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12" style="margin-top: 10px">
                                <input class="book" type="submit" value="ĐẶT LỊCH" name="">
                            </div>
                        </div>
                        
                    </form>
                <!-- </center> -->
                
            </div>
        </div>
        
    </div>
</div>
@endsection