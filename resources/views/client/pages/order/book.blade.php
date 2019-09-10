@extends('client.layouts.index')

@section('content')
<div class="row">
    <div class="container">
        <div class="row order" style="margin-top: 20px !important">
            <div class="col-lg-12">
                <!-- <center> -->
                    <form onsubmit="return validateForm()" method="post" action="{{ route('client.book') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <h2 style="text-align: center;"><i class="far fa-clock"></i> ĐẶT LỊCH</h2>
                        <br>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="label-input">
                                    <label>
                                        <b>CHỌN DỊCH VỤ:</b>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row" style="margin: 10px 0px !important;">
                                    <div class="col-lg-2" style="padding-left: 0px">
                                        <label onclick="pickHair({{ $hairCut->id }})" style="width: 100%; margin: 0px">
                                            <input 
                                                style='display: none' type="checkbox" 
                                                class="service service{{ $hairCut->id }}" 
                                                name="service[]" 
                                                value="{{ $hairCut->id }}"
                                            >
                                            <div style="width: 20px; height: 20px; border: 1px solid #ccc; position: relative;">
                                                <i id="check{{ $hairCut->id }}" style="position: absolute; top: 3px; left: 3px;font-size: 13px; color: #000; display: none;" class="fas fa-check check">
                                                </i>                      
                                            </div>
                                        </label>
                                    </div>
                                    <div class="col-lg-2">
                                        <span>
                                            {{ mb_strtoupper($hairCut->name, 'UTF-8') }}
                                        </span>
                                        
                                    </div>
                                    <div class="col-lg-6">
                                        <span>
                                            {{ number_format($hairCut->price) }}<sup>đ</sup>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row stylist" style="display: none;">
                                    
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row" style="margin: 10px 0px !important;">
                                    <div class="col-lg-2" style="padding-left: 0px">
                                        <label onclick="pickSkinner({{ $wash->id }})" style="width: 100%; margin: 0px">
                                            <input 
                                                style="display: none;" type="checkbox" 
                                                class="service service-skinner{{ $wash->id }}" 
                                                name="service[]" 
                                                value="{{ $wash->id }}"
                                            >
                                            <div style="width: 20px; height: 20px; border: 1px solid #ccc; position: relative;">
                                                <i id="icon-check-skinner" style="position: absolute; top: 3px; left: 3px;font-size: 13px; color: #000; display: none;" class="fas fa-check check">
                                                </i>                      
                                            </div>
                                        </label>
                                    </div>
                                    <div class="col-lg-2">
                                        <span>
                                            {{ mb_strtoupper($wash->name, 'UTF-8') }}
                                        </span>
                                        
                                    </div>
                                    <div class="col-lg-6">
                                        <span>
                                            {{ number_format($wash->price) }}<sup>đ</sup>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row skinner" style="display: none;">
                                    
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