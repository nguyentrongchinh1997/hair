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
        table{
            margin-top: 50px
        }
        /*@media screen and (min-width: 425px) and (max-width: 768px) {
            .rate{
                font-size: 80px;
            }
        }
        @media screen and (max-width: 425px) {
            table span{
                font-size: 13px;
            }
            .rate{
                font-size: 50px;
            }
        }*/
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
                window.location.href='danh-gia?step=3';
               //  setTimeout(function(){
               //     window.location.href='danh-gia?step=3';
               // },1500);
            })

        })
        
    </script>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <center>
            <h2>MỜI ANH <span style="color: red">{{ $bill->order->customer->full_name }}</span></h2>
            <h4>
                ĐÁNH GIÁ CHẤT LƯỢNG DỊCH VỤ GIÚP CHÚNG EM
            </h4>
            <table>
                <tr>
                    @foreach ($rateList as $rate)
                        <td>
                            <i data='{{ $rate->id }}' class="rate {{ $rate->icon_class }}"></i>
                            
                        </td>
                    @endforeach
                </tr>
                <tr>
                    @foreach ($rateList as $rate)
                        <td>
                           <span>{{ $rate->name }}</span>
                        </td>
                    @endforeach
                </tr>
            </table>
            <input type="hidden" id="bill-id" value="{{ $bill->id }}" name="">
            <p>
                <span class="title-rate" style="display: none;">Anh đã chọn: <span style="font-weight: bold; color: green" id="rate-result"></span></span>
            </p>
        </center>
    </div>
@endsection