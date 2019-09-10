@extends('client.pages.rate.layouts.index')

@section('content')
    <script type="text/javascript">
        $(function(){
            $('.checkbox').click(function(){
                if ($(this).find('.comment').is(":checked")) {
                    $(this).find('.check').show();
                    comment = $(this).find('.comment').val();
                    billId = $('#bill-id').val();
                    $.get('khach-hang/binh-luan/' + billId + '?message=' + comment);
                } else {
                    comment = $(this).find('.comment').val();
                    billId = $('#bill-id').val();
                    $.get('xoa/binh-luan/' + billId + '?message=' + comment);
                    $(this).find('.check').hide();
                }
            })
            // $('.checkbox').click(function(){
            //     $(this).find('.check').show();
            // })
            setTimeout(function(){
               window.location.href='rate';
            }, 5000);
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
        }
    </style>
    <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
        <center>
            <h2>30SHINE NÊN CẢI THIỆN ĐIỀU GÌ <br>ĐỂ ANH HÀI LÒNG HƠN?</h2>
            <input type="hidden" id="bill-id" value="{{ $bill->id }}" name="">
            <table>
                <tr>
                    <td>
                        <label>
                            <table>
                                <tr>
                                    <td>
                                        <div class="checkbox" style="width: 20px; height: 20px; border: 1px solid #ccc; position: relative;">
                                            <input class="comment " value="Tất cả đều tốt, không có góp ý gì;" type="checkbox" name="">
                                            <i id="check1" style="position: absolute; top: 3px; left: 3px; font-size: 13px; color: #000; display: none;" class="fas fa-check check"></i>
                                        </div>
                                    </td>
                                    <td>
                                        <p style="padding-left: 10px">Tất cả đều tốt, không có góp ý gì</p>
                                    </td>
                                </tr>
                            </table>
                        </label>
                    </td>
                    <td>
                        <label>
                            <table>
                                <tr>
                                    <td>
                                        <div class="checkbox" style="width: 20px; height: 20px; border: 1px solid #ccc; position: relative;">
                                            <input class="comment" type="checkbox" value="Chất lượng cắt và kiểu tóc;" name="">
                                            <i id="check1" style="position: absolute; top: 3px; left: 3px; font-size: 13px; color: #000; display: none;" class="fas fa-check check"></i>
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
                    <td>
                        <label>
                            <table>
                                <tr>
                                    <td>
                                        <div class="checkbox" style="width: 20px; height: 20px; border: 1px solid #ccc; position: relative;">
                                            <input class="comment " value="Thái độ phục vụ;" type="checkbox" name="">
                                            <i id="check1" style="position: absolute; top: 3px; left: 3px; font-size: 13px; color: #000; display: none;" class="fas fa-check check"></i>
                                        </div>
                                    </td>
                                    <td>
                                        <p style="padding-left: 10px">Thái độ phục vụ</p>
                                    </td>
                                </tr>
                            </table>
                        </label>
                    </td>
                    <td>
                        <label>
                            <table>
                                <tr>
                                    <td>
                                        <div class="checkbox" style="width: 20px; height: 20px; border: 1px solid #ccc; position: relative;">
                                            <input class="comment " value="Thời gian chờ đợi;" type="checkbox" name="">
                                            <i id="check1" style="position: absolute; top: 3px; left: 3px; font-size: 13px; color: #000; display: none;" class="fas fa-check check"></i>
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
                    <td>
                        <label>
                            <table>
                                <tr>
                                    <td>
                                        <div class="checkbox" style="width: 20px; height: 20px; border: 1px solid #ccc; position: relative;">
                                            <input class="comment " value="Nhân viên bớt làm ồn trong khi phục vụ;" type="checkbox" name="">
                                            <i id="check1" style="position: absolute; top: 3px; left: 3px; font-size: 13px; color: #000; display: none;" class="fas fa-check check"></i>
                                        </div>
                                    </td>
                                    <td>
                                        <p style="padding-left: 10px">Nhân viên bớt làm ồn trong khi phục vụ</p>
                                    </td>
                                </tr>
                            </table>
                        </label>
                    </td>
                    <td>
                        <label>
                            <table>
                                <tr>
                                    <td>
                                        <div class="checkbox" style="width: 20px; height: 20px; border: 1px solid #ccc; position: relative;">
                                            <input class="comment " value="Cảm thấy bị làm phiền bởi việc tư vấn dịch vụ/bán hàng;" type="checkbox" name="">
                                            <i id="check1" style="position: absolute; top: 3px; left: 3px; font-size: 13px; color: #000; display: none;" class="fas fa-check check"></i>
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
            <p style="color: #ff1500">Tiến trình sẽ tự động hoàn tất sau 5s</p>
        </center>
    </div>
@endsection
