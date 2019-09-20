@extends('client.mobile.layouts.index')

@section('content')
<div class="container" style="padding: 0px; margin-top: 90px">
    <form method="post" action="{{ route('client.book') }}">
        @csrf
    <div class="row" style="padding-top: 20px">
        <div class="col-12">
            <label style="font-weight: bold; font-size: 25px">Chọn dịch vụ</label>
            <input type="hidden" value="{{ auth('customers')->user()->phone }}" name="phone">
        </div>
        <div class="col-lg-12">
            <div class="row" style="margin: 10px 0px !important;">
                <div class="col-2 col-lg-2" style="padding-left: 0px">
                    <label onclick="pickHair({{ $hairCut->id }})" style="width: 100%; margin-top: 12px">
                        <input 
                            style='display: none' type="checkbox" 
                            class="service service{{ $hairCut->id }}" 
                            name="service[]" 
                            value="{{ $hairCut->id }}"
                        >
                        <div style="width: 30px; height: 30px; border: 1px solid #ccc; position: relative;">
                            <i id="check{{ $hairCut->id }}" style="position: absolute; top: 5px; left: 5px;font-size: 18px; color: #000; display: none;" class="fas fa-check check">
                            </i>                      
                        </div>
                    </label>
                </div>
                <div class="col-5 col-lg-2" style="padding-left: 0px">
                    <img src="{{ asset('/image/cat_toc.png') }}" width="50px">
                    <span style="font-weight: bold; margin-top: 10px; padding-left: 15px; font-size: 25px">
                        {{ mb_strtoupper($hairCut->name, 'UTF-8') }}
                    </span>
                    
                </div>
                <div class="col-5 col-lg-8" style="padding: 0px">
                    <table style="width: 100%">
                        <tr>
                            <td style="width: 30%"></td>
                            <td style="width: 30%"></td>
                            <td class="price-service">
                                {{ number_format($hairCut->price) }}<sup>đ</sup>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="row stylist" style="display: none;">
                
            </div>
        </div>
        <div class="col-lg-12">
            <div class="row" style="margin: 10px 0px !important;">
                <div class="col-2 col-lg-2" style="padding-left: 0px">
                    <label onclick="pickSkinner({{ $wash->id }})" style="width: 100%; margin-top: 12px">
                        <input
                            style="display: none;" checked type="checkbox" 
                            class="wash service service-skinner{{ $wash->id }}" 
                            name="service[]" 
                            value="{{ $wash->id }}"
                        >
                        <div style="width: 30px; height: 30px; border: 1px solid #ccc; position: relative;">
                            <i id="icon-check-skinner" style="position: absolute; top: 5px; left: 5px;font-size: 18px; color: #000;" class="fas fa-check check">
                            </i>                      
                        </div>
                    </label>
                </div>
                <div class="col-5 col-lg-2" style="padding-left: 0px">
                    <img src="{{ asset('/image/goi_dau.png') }}" width="50px">
                    <span style="font-weight: bold; font-size: 25px; padding-left: 15px">
                        {{ mb_strtoupper($wash->name, 'UTF-8') }}
                    </span>
                    
                </div>
                <div class="col-5 col-lg-8" style="padding: 0px">
                    <table style="width: 100%">
                        <tr>
                            <td style="width: 30%"></td>
                            <td style="width: 30%"></td>
                            <td class="price-service">
                                {{ number_format($wash->price) }}<sup>đ</sup>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="row skinner" style="display: none;">
                
            </div>
        </div>
        <div class="col-lg-12">
            <div class="row label-input">
                <label style="font-size: 25px; font-weight: bold;">
                    Chọn giờ
                </label>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="row time-option">
                @foreach ($time as $time)
                    <div class="col-3 col-lg-3" style="padding: 5px">
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
        <div class="col-lg-12" style="margin-top: 10px">
            <input class="book" type="submit" value="ĐẶT LỊCH" name="">
        </div>
    </div><br><br>
</form>
</div>
    <a href="{{ route('mobile.logout') }}">Đăng xuất</a>
@endsection
