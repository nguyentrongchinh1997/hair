@extends('client.layouts.index')

@section('content')
<div class="container" style="background-image:url('image/bg_juna.jpg') ; min-height: 800px; background-size: cover;">
    <div class="row">
    <!--     <div id="demo" class="carousel slide" data-ride="carousel">
          <ul class="carousel-indicators">
            <li data-target="#demo" data-slide-to="0" class="active"></li>
            <li data-target="#demo" data-slide-to="1"></li>
            <li data-target="#demo" data-slide-to="2"></li>
          </ul>
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
          <a class="carousel-control-prev" href="#demo" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
          </a>
          <a class="carousel-control-next" href="#demo" data-slide="next">
            <span class="carousel-control-next-icon"></span>
          </a>
        </div> -->
        @if (auth('customers')->check() && $card != '')
            <div class="d-none d-sm-none d-md-block col-lg-4" style="padding-top: 40px">
                <p style="text-align: center; font-weight: bold; font-size: 25px">THẺ CỦA BẠN</p>
                @foreach ($card as $membership)
                    <div class="card">
                        <h3 style="text-align: center; padding-top: 60px; margin-bottom: 0px; text-align: center;">JUNA HAIR</h3>
                        <p style="text-transform: uppercase; position: absolute;bottom: 0px">{{ $membership->card->card_name }}</p>
                    </div>

                @endforeach
            </div>
        @else
            <div class="col-lg-4">
            </div>
        @endif
        <div class="col-lg-4" style="padding: 0px">
            <div class="input-sologan">
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <form onsubmit="return validatePhone()" method="post" action="{{ route('post.phone') }}" style="box-shadow: 0 1px 6px 0 rgba(32, 33, 36, .28);">
                @csrf
                    <div class="input-phone" style="background: #fff">
                        <div class="input-text">
                            <div class="icon">
                                <img width="40px" height="40px" src="{{ asset('image/item_call.png') }}" alt="Icon">
                                <img style="width:1px; height:40px; margin-left: 5px" src="{{ asset('image/gachh.png') }}" alt="Icon" class="right">
                                <input id="phone" placeholder="* Nhập số điện thoại..." type="tel" name="phone" value=""> 
                            </div>
                        </div>
                        <div style="display: flex; text-align: center; margin-top: 10px;">
                            <div class="btn-booking">
                                <div>
                                    <button type="submit" name="action" value="submit-phone" class="booking-text">
                                        ĐẶT LỊCH GIỮ CHỖ &nbsp;<img src="{{ asset('image/click1.png') }}" alt="click" style="width: 30px; height: 30px; margin-bottom: 5px; vertical-align: middle;">
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @if (auth('customers')->check() && $card != '')
            <div class="col-lg-4 sale-service" style="padding-top: 40px;">
                <p style="text-align: center; font-weight: bold; font-size: 25px">ƯU ĐÃI LỚN KHI</p>
                <ul>
                    @foreach ($card as $membership) 
                        @if ($membership->card->type == config('config.card.hoi_vien'))
                            @foreach ($membership->card->cardDetail as $service)
                                <li style="margin-bottom: 20px">
                                    <table style="width: 100%">
                                        <tr>
                                            <td style="width: 10%">
                                                <div style="width: 25px; height: 25px; background: #000">
                                                    <i id="icon-check-skinner" style="color: #fff; padding-left: 5px" class="fas fa-check check"></i>                      
                                                </div>
                                            </td>
                                            <td style="padding-left: 20px; text-transform: uppercase; width: 40%">
                                                {{ $service->service->name }}
                                            </td>
                                            <td style="text-align: right;">
                                                <span style="background: #ffd800;padding: 5px 30px;border-radius: 4px;font-weight: bold;">
                                                    - {{ $service->percent }}%
                                                </span>
                                                
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                            @endforeach
                        @elseif ($membership->card->type == config('config.card.so_lan'))
                            @foreach ($membership->card->cardDetail as $service)
                                <li style="margin-bottom: 20px">
                                    <table style="width: 100%">
                                        <tr>
                                            <td style="width: 10%">
                                                <div style="width: 25px; height: 25px; background: #000">
                                                    <i id="icon-check-skinner" style="color: #fff; padding-left: 5px" class="fas fa-check check"></i>                      
                                                </div>
                                            </td>
                                            <td style="padding-left: 20px; text-transform: uppercase; width: 40%">
                                                {{ $service->service->name }}
                                            </td>
                                            <td style="text-align: right;">
                                                <span style="background: #ffd800;padding: 5px 30px;border-radius: 4px;font-weight: bold;">
                                                    Tặng {{ $service->number }} lần
                                                </span>
                                                
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                            @endforeach
                        @endif
                    @endforeach
                </ul>
            </div>
        @endif
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
                /*position: absolute;*/
                width: 100%;
                margin: auto;
                padding-top: 280px;
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
</div>
@endsection