@extends('client.layouts.index')

@section('content')
<div class="row">
    <div class="container" style="background-image: url(image/bg_juna.jpg);
    background-size: cover;">
        <div class="row order" style="margin-top: 20px !important">
            <div class="col-lg-4"></div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-4" style="padding: 0px">
                <form onsubmit="return validateForm()" method="post" action="{{ route('client.book') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="row">
                        <div class="col-lg-12" style="padding: 0px">
                            <div class="label-input">
                                <label>
                                    <b>Chọn dịch vụ:</b>
                                    <input type="hidden" value="{{ $phone }}" name="phone">
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="row" style="margin: 10px 0px !important;">
                                <div class="col-2 col-sm-2 col-md-2 col-lg-2" style="padding-left: 0px">
                                    <label onclick="pickHair({{ $hairCut->id }})" style="width: 100%; margin-top: 12px">
                                        <input 
                                            style='display: none' type="checkbox" 
                                            class="cut service service{{ $hairCut->id }}" 
                                            name="service[]" 
                                            value="{{ $hairCut->id }}"
                                        >
                                        <div style="width: 20px; height: 20px; border: 1px solid #ccc; position: relative;">
                                            <i id="check{{ $hairCut->id }}" style="position: absolute; top: 3px; left: 3px;font-size: 13px; color: #000; display: none;" class="fas fa-check check">
                                            </i>                      
                                        </div>
                                    </label>
                                </div>
                                <div class="col-2 col-sm-2 col-md-2 col-lg-2">
                                    <p style="font-weight: bold; margin-top: 10px; margin-bottom: 0px">
                                        {{ mb_strtoupper($hairCut->name, 'UTF-8') }}
                                    </p>
                                    
                                </div>
                                <div class="col-8 col-sm-8 col-md-8 col-lg-8" style="padding: 0px">
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
                        <style type="text/css">
                            button.slick-next, button.slick-next:hover{
                                top: 54%;
                                right: -20px;
                            }
                        </style>

                        <div class="col-lg-12">
                            <div class="row" style="margin: 10px 0px !important;">
                                <div class="col-2 col-sm-2 col-md-2 col-lg-2" style="padding-left: 0px">
                                    <label onclick="pickSkinner({{ $wash->id }})" style="width: 100%; margin-top: 12px">
                                        <input
                                            style="display: none;" type="checkbox" 
                                            class="wash service service-skinner{{ $wash->id }}" 
                                            name="service[]" 
                                            value="{{ $wash->id }}"
                                        >
                                        <div style="; width: 20px; height: 20px; border: 1px solid #ccc; position: relative;">
                                            <i id="icon-check-skinner" style="display: none; position: absolute; top: 3px; left: 3px;font-size: 13px; color: #000;" class="fas fa-check check">
                                            </i>                      
                                        </div>
                                    </label>
                                </div>
                                <div class="col-2 col-sm-2 col-md-2 col-lg-2">
                                    <p style="font-weight: bold; margin-bottom: 0px; margin-top: 10px">
                                        {{ mb_strtoupper($wash->name, 'UTF-8') }}
                                    </p>
                                    
                                </div>
                                <div class="col-8 col-sm-8 col-md-8 col-lg-8" style="padding: 0px">
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
                            <div class="row skinner" style="display: none; margin-bottom: 20px !important">
                                
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
                                        <div style="width: 20px; height: 20px; border: 1px solid #ccc; position: relative;">
                                            <i id="check0" style="position: absolute; top: 3px; left: 3px;font-size: 13px; color: #000; display: none;" class="fas fa-check check">
                                            </i>                      
                                        </div>
                                    </label>
                                </div>
                                <div class="col-2 col-sm-2 col-md-2 col-lg-2">
                                    <p style="font-weight: bold; margin-top: 10px; margin-bottom: 0px">
                                        KHÁC
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- </div> -->
                    <div class="row">
                        <div class="col-lg-12" style="padding: 0px">
                            <div class="row label-input">
                                <label>
                                    <b>Chọn giờ cắt</b>
                                </label>
                            </div>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row time-option">
                                @foreach ($time as $time)
                                    <div class="col-4 col-sm-3 col-md-3 col-lg-3" style="padding: 5px">
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
            </div>
            <div class="col-lg-4">
                @if ($historyList->count() > 0)
                    <h3 style="text-align: center; font-size: 18px; font-weight: bold; padding-top: 20px; margin-bottom: 20px">Lịch sử của bạn</h3>
                    <table class="table-history">
                        <tr>
                            <td style="background: #e6e6e6; text-align: center; border: 1px solid #ccc; font-weight: bold;">Dịch vụ</td>
                            <td style="background: #e6e6e6; text-align: center; border: 1px solid #ccc; font-weight: bold;">Ngày</td>
                        </tr>
                        @foreach ($historyList as $history)
                            <tr>
                                <td>
                                    @foreach ($history->bill->billDetail as $service)
                                        @if ($service->service_id == '')
                                            <p>- {{ $service->other_service }}</p>
                                        @else
                                            <p>- {{ $service->service->name }}</p>
                                        @endif
                                    @endforeach
                                </td>
                                <td style="text-align: center;">
                                    {{ date('d/m/Y', strtotime($history->date)) }}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection