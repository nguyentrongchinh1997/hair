@extends('client.pages.rate.layouts.index')

@section('content')
<script type="text/javascript">
    setTimeout(function(){
        var href = 'danh-gia';
       window.location.href = href;
   },10000);
</script>
<div class="container">
    <div class="col-xs-12 col-sm-12 col-lg-12">
        <h2 style="text-align: center;">
            MỜI ANH {{ mb_strtoupper($bill->order->customer->full_name, 'UTF-8') }}
        </h2>
        <h4 style="text-align: center;">XÁC NHẬN LẠI THÔNG TIN HÓA ĐƠN GIÚP CHÚNG EM</h4>
        <table style="width: 100%; background: #F9FBE7;">
            <tr>
                <td style="text-align: center; padding: 10px">Anh vui lòng chỉ thanh toán đúng số tiền<br>
                    <span  style="color: red; font-weight: bold; font-size: 30px">
                        {{ number_format($sum) }} Đ
                    </span>
                </td>
                <td style="text-align: right; padding: 10px">
                    <a class="btn btn-primary" href="danh-gia/?step=2"><i class="fas fa-check"></i> XÁC NHẬN ĐÚNG</a>
                </td>
            </tr>
        </table><br>
        <p style="color: orange; text-align: center;">
            Nếu chưa đúng anh vui lòng báo lễ tân để chỉnh sửa giúp em nhé
        </p>
        <table style="width: 100%">
            @php $stt = 0; @endphp
            @foreach ($billDetail as $bill)
                <tr>
                    <td>
                        {{ ++$stt }}.
                        @if ($bill->service_id == '') 
                            {{ $bill->other_service }}
                        @else
                            {{ $bill->service->name }}
                        @endif
                    </td>
                    <td style="text-align: right;">
                        {{ number_format($bill->money) }} Đ
                    </td>
                </tr>
            @endforeach
        </table>
        
    </div>
</div>
@endsection
