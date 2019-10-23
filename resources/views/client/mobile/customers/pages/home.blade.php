@extends('client.mobile.customers.layouts.index')

@section('content')
<div class="container" style="padding: 0px; margin-top: 90px; margin-bottom: 0px !important">
    <form onsubmit="return validateForm()" method="post" action="{{ route('client.book') }}">
        @csrf
        <div class="row" style="padding-top: 20px">
            <div class="col-12" style="padding: 20px 15px 40px 15px">
                <div class="row" style="position: relative;">
                    <div class="col-3" style="margin-top: 15px; width: 100%; height: 3px; background: #727272;"></div>
                    <div class="col-6">
                        <p class="pick-service"><!-- <span>1</span> -->1. CHỌN DỊCH VỤ</p>
                        <input type="hidden" value="{{ auth('customers')->user()->phone }}" name="phone">
                    </div>
                    <div class="col-3" style="margin-top: 15px; width: 100%; height: 3px; background: #727272;"></div>
                    
                </div>
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
                        <span style="font-weight: bold; margin-top: 10px; padding-left: 15px; font-size: 20px">
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
                                style="display: none;" type="checkbox" 
                                class="wash service service-skinner{{ $wash->id }}" 
                                name="service[]" 
                                value="{{ $wash->id }}"
                            >
                            <div style="width: 30px; height: 30px; border: 1px solid #ccc; position: relative;">
                                <i id="icon-check-skinner" style="display: none; position: absolute; top: 5px; left: 5px;font-size: 18px; color: #000;" class="fas fa-check check">
                                </i>                      
                            </div>
                        </label>
                    </div>
                    <div class="col-5 col-lg-2" style="padding-left: 0px">
                        <img src="{{ asset('/image/goi_dau.png') }}" width="50px">
                        <span style="font-weight: bold; font-size: 20px; padding-left: 15px">
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
                <div class="row" style="margin: 10px 0px !important;">
                    <div class="other col-2 col-sm-2 col-md-2 col-lg-2" style="padding-left: 0px">
                        <label onclick="pickOther(0)" style="width: 100%; margin-top: 12px">
                            <input 
                                style='display: none' type="checkbox" 
                                class="cut service service0"
                                name="service[]" 
                                value="0"
                            >
                            <div style="width: 30px; height: 30px; border: 1px solid #ccc; position: relative;">
                                <i id="check0" style="position: absolute; top: 3px; left: 3px;font-size: 18px; color: #000; display: none;" class="fas fa-check check">
                                </i>                      
                            </div>
                        </label>
                    </div>
                    <div class="col-2 col-sm-2 col-md-2 col-lg-2">
                        <p style="font-weight: bold; margin-top: 10px; margin-bottom: 0px; font-size: 20px">
                            KHÁC
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-12" style="padding: 40px 15px 40px 15px">
                <div class="row" style="position: relative;">
                    <div class="col-3" style="margin-top: 15px; width: 100%; height: 3px; background: #727272;"></div>
                    <div class="col-6">
                        <p class="pick-service"><!-- <span>2</span> -->2. CHỌN GIỜ</p>
                    </div>
                    <div class="col-3" style="margin-top: 15px; width: 100%; height: 3px; background: #727272;"></div>
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
            <div class="col-lg-12" style="margin-top: 50px">
                <input class="book" type="submit" value="ĐẶT LỊCH" name="">
            </div>
        </div><br><br><br>
    </form>
</div>
@endsection
