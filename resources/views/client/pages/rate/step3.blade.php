@extends('client.pages.rate.layouts.index')

@section('content')
    <script type="text/javascript">
        $(function(){
            $('.checkbox').click(function(){
                if ($(this).find('.comment').is(":checked")) {
                    $(this).find('.check').show();
                    comment = $(this).find('.comment').val();
                    billId = $('#bill-id').val();
                    // $.get('danh-gia/gop-y/them/' + billId + '?message=' + comment);
                } else {
                    comment = $(this).find('.comment').val();
                    billId = $('#bill-id').val();
                    // $.get('danh-gia/gop-y/xoa/' + billId + '?message=' + comment);
                    $(this).find('.check').hide();
                }
            })
            // setTimeout(function(){
            //    window.location.href='rate';
            // }, 5000);
        })
    </script>
    <style type="text/css">
        .comment{
            opacity: 0;
        }
        label {
            font-weight: bold;
        }
        table tr td{
            padding: 5px;
        }
        p{
            margin-bottom: 0px;
            font-size: 30px;
        }
        .checkbox{
            width: 35px; height: 35px; 
            border: 1px solid #ccc; 
            position: relative;
        }
        .checkbox i {
            position: absolute; 
            top: 4px; 
            left: 4px; 
            font-size: 25px; 
            color: #000; 
            display: none;
        }
    </style>
    <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
        <form method="post" action="{{ route('rate.finish') }}">
            @csrf
            <center>
                <h2>30SHINE NÊN CẢI THIỆN ĐIỀU GÌ <br>ĐỂ ANH HÀI LÒNG HƠN?</h2>
                <center>
                    <p style="margin-top: 30px; font-weight: bold; margin-bottom: 30px">Bước 2/2</p>
                </center>
                <input type="hidden" id="bill-id" value="{{ $bill->id }}" name="">
                <table>
                    <tr>
                        <td style="width: 50%">
                            <label>
                                <table>
                                    <tr>
                                        <td>
                                            <div class="checkbox">
                                                <input class="comment" data='0' value="Tất cả đều tốt, không có góp ý gì;" type="checkbox" name="comment[]">
                                                <i id="check1" class="fas fa-check check"></i>
                                            </div>
                                        </td>
                                        <td>
                                            <p style="padding-left: 10px">Tất cả đều tốt, không có góp ý gì</p>
                                        </td>
                                    </tr>
                                </table>
                            </label>
                        </td>
                        <td style="width: 50%">
                            <label>
                                <table>
                                    <tr>
                                        <td>
                                            <div class="checkbox">
                                                <input class="comment" data='0' type="checkbox" value="Chất lượng cắt và kiểu tóc;" name="comment[]">
                                                <i id="check1" class="fas fa-check check"></i>
                                            </div>
                                        </td>
                                        <td>
                                            <p style="padding-left: 10px">Chất lượng cắt và kiểu tóc;</p>
                                        </td>
                                    </tr>
                                </table>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 50%">
                            <label>
                                <table>
                                    <tr>
                                        <td>
                                            <div class="checkbox">
                                                <input class="comment" data='0' value="Thái độ phục vụ;" type="checkbox" name="comment[]">
                                                <i id="check1" class="fas fa-check check"></i>
                                            </div>
                                        </td>
                                        <td>
                                            <p style="padding-left: 10px">Thái độ phục vụ</p>
                                        </td>
                                    </tr>
                                </table>
                            </label>
                        </td>
                        <td style="width: 50%">
                            <label>
                                <table>
                                    <tr>
                                        <td>
                                            <div class="checkbox">
                                                <input class="comment" data='0' value="Thời gian chờ đợi;" type="checkbox" name="comment[]">
                                                <i id="check1" class="fas fa-check check"></i>
                                            </div>
                                        </td>
                                        <td>
                                            <p style="padding-left: 10px">Thời gian chờ đợi</p>
                                        </td>
                                    </tr>
                                </table>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 50%">
                            <label>
                                <table>
                                    <tr>
                                        <td>
                                            <div class="checkbox">
                                                <input class="comment" data='0' value="Nhân viên bớt làm ồn trong khi phục vụ;" type="checkbox" name="comment[]">
                                                <i id="check1" class="fas fa-check check"></i>
                                            </div>
                                        </td>
                                        <td>
                                            <p style="padding-left: 10px">Nhân viên bớt làm ồn trong khi phục vụ</p>
                                        </td>
                                    </tr>
                                </table>
                            </label>
                        </td>
                        <td style="width: 50%">
                            <label>
                                <table>
                                    <tr>
                                        <td>
                                            <div class="checkbox">
                                                <input class="comment" data='0' value="Cảm thấy bị làm phiền bởi việc tư vấn dịch vụ/bán hàng;" type="checkbox" name="comment[]">
                                                <i id="check1" class="fas fa-check check"></i>
                                            </div>
                                        </td>
                                        <td>
                                            <p style="padding-left: 10px">Cảm thấy bị làm phiền bởi việc tư vấn dịch vụ/bán hàng</p>
                                        </td>
                                    </tr>
                                </table>
                            </label>
                        </td>
                    </tr>
                </table>
                <button class="btn btn-primary" style="margin-top: 20px; font-size: 30px">
                    XÁC NHẬN
                </button>
                <!-- <a href="{{ route('rate.finish') }}" class="btn btn-primary" style="margin-top: 20px; font-size: 30px">
                    XÁC NHẬN
                </a> -->
            </center>
        </form>
    </div>
@endsection
