@extends('client.pages.rate.layouts.index')

@section('content')
<script type="text/javascript">
    setTimeout(function(){
        location.reload();
    },5000);
    $(function(){
        billId = $('#bill-id').val();

        if (billId == 0) {
            window.location.href = 'rate';
        }
    })
</script>
<style type="text/css">
    table tr td {
        font-size: 30px;
    }
</style>
<div class="row">
    <input type="hidden" id="bill-id" value="@if(isset($bill)){{ $bill->id }}@else{{ '0' }}@endif">
    <div id="load-input">
        
    </div>
    <div class="col-xs-12 col-sm-12 col-lg-12">
        <h2 style="text-align: center;">
            MỜI {{ mb_strtoupper($bill->customer->full_name, 'UTF-8') }}
        </h2>
        <h4 style="text-align: center;">XÁC NHẬN LẠI THÔNG TIN HÓA ĐƠN GIÚP CHÚNG EM</h4>
        <table style="width: 100%; background: #F9FBE7;">
            <tr>
                <td style="text-align: center; padding: 10px">Chị vui lòng chỉ thanh toán đúng số tiền<br>
                    <span  style="color: red; font-weight: bold; font-size: 30px">
                        {{ number_format($sum) }} Đ
                        
                    </span>
                </td>
                <td style="text-align: right; padding: 10px">
                    <a class="btn btn-primary" href="danh-gia/buoc/?step=2"><i class="fas fa-check"></i> XÁC NHẬN ĐÚNG</a>
                </td>
            </tr>
        </table><br>
        <p style="color: orange; text-align: center;">
            Nếu chưa đúng Chị vui lòng báo lễ tân để chỉnh sửa giúp em nhé
        </p>
        <table style="width: 100%">
            @php $stt = 0; @endphp
            @foreach ($billDetail as $bill1)
                <tr>
                    <td>
                        @php $sothutu = ++$stt; @endphp
                        {{ $sothutu }}.
                        @if ($bill1->service_id == '') 
                            {{ $bill1->other_service }}
                        @else
                            {{ $bill1->service->name }}
                        @endif
                    </td>
                    <td style="text-align: right;">
                        {{ number_format($bill1->sale_money) }} Đ
                    </td>
                </tr>
            @endforeach
            @if ($bill->sale != '')
                <tr>
                    <td>{{ $sothutu + 1 }}. Được tặng</td>
                    <td style="text-align: right; color: red">
                        {{ number_format($bill->sale) }} Đ
                    </td>
                </tr>
            @endif
        </table>
        
    </div>
</div>
@endsection
