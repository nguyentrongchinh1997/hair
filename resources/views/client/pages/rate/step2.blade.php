@extends('client.pages.rate.layouts.index')

@section('content')
    <style type="text/css">
        .rate{
            font-size: 100px;
            padding: 0px 10px;
            color: #ccc;
            font-weight: bold;
        }
        table tr td{
            text-align: center;
            padding: 0px 20px;
        }
    </style>
    <script type="text/javascript">
        $(function(){
            setTimeout(function(){
               window.location.href='danh-gia?step=3';
            },10000);
            $('.rate').click(function(){
                $('.rate').css({"color":"#ccc"});
                $(this).css({"color":"yellow"});
                data = $(this).attr('data');
                billId = $('#bill-id').val();
                $.get('khach-hang/danh-gia/' + data + '/' + billId);
                $('#rate-result').html(data);
                $('.title-rate').show();
                setTimeout(function(){
                   window.location.href='danh-gia?step=3';
               },1500);
            })

        })
        
    </script>
    <center>
        <h2>Mời Anh <span style="color: red">{{ $bill->order->customer->full_name }}</span> Đánh Giá</h2>
        <h4>
            ĐÁNH GIÁ CHẤT LƯỢNG DỊCH VỤ GIÚP CHÚNG EM
        </h4>
        <table>

            <tr>
                @foreach ($rateList as $rate)
                    <td>
                        <i data='{{ $rate->id }}' class="rate {{ $rate->icon_class }}"></i>
                        <br><span>{{ $rate->name }}</span>
                    </td>
                @endforeach
            </tr>
        </table>
        <!-- <i data='rất tệ' class="rate far fa-sad-cry"></i>
        <i data='tệ' class="rate far fa-sad-tear"></i>
        <i data='bình thường' class="rate far fa-frown-open"></i>
        <i data='hài lòng' class="rate far fa-smile"></i>
        <i data='rất hài lòng' class="rate far fa-grin-beam"></i> -->
        <input type="hidden" id="bill-id" value="{{ $bill->id }}" name="">
        <p>
            <span class="title-rate" style="display: none;">Anh đã chọn: <span style="font-weight: bold; color: green" id="rate-result"></span></span>
        </p>
    </center>
@endsection
