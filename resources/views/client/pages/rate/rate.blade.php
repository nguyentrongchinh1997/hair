@extends('client.pages.rate.layouts.index')

@section('content')
    <script type="text/javascript">
        // billId = $('#bill-id').val();
        // setTimeout(function(){
        //    location.reload();
        // },15000);
        

        // var auto_refresh = setInterval(function (){
        //     $('#load-input').load("input").fadeIn("slow");
        //     }, 2000);
        // var billId = $('#bill-id').val();
        // if (billId != '') {
        //     setTimeout(function(){
        //         var href = 'danh-gia?step=1';
        //        window.location.href = href;
        //    },3000);
        // }
    </script>
    <script type="text/javascript">
        $(function(){
            setTimeout(function(){
               location.reload();
            },3000);
            if ($('#bill-id').val() != 0) {
                window.location.href = 'danh-gia/buoc?step=1';
            }
        })
    </script>
    <div id="load-input">
        <input type="hidden" id="bill-id" value="@if(isset($bill)){{ $bill->id }}@else{{ '0' }}@endif">
    </div>
    <div id="load_tweets">
        <center>
            <img src="{{ asset('image/bg_juna.jpg') }}" width="800px">
        </center>
    </div>
@endsection
