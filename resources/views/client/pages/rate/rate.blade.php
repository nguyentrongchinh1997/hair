@extends('client.pages.rate.layouts.index')

@section('content')
    <script type="text/javascript">
       setTimeout(function(){
           location.reload();
       },15000);

        var auto_refresh = setInterval(function (){
            $('#load-input').load("input").fadeIn("slow");
            }, 2000);
        var billId = $('#bill-id').val();
        if (billId != '') {
            setTimeout(function(){
                var href = 'danh-gia?step=1';
               window.location.href = href;
           },3000);
            // var auto_refresh = setInterval(function (){
            // $('#load_tweets').load("xac-nhan/hoa-don/?bill_id=" + billId).fadeIn("slow");
            // }, 3000);
        }
    </script>
    <div id="load-input">
        <input type="hidden" id="bill-id" value="@if(isset($bill)){{ $bill->id }}@else {{ '' }}@endif" name="">
    </div>
    <div id="load_tweets">
        <center>
            <img src="https://cdn1.mywork.com.vn/company-logo-medium/201702/5dc078b451f4.jpg">
        </center>
    </div>
@endsection
