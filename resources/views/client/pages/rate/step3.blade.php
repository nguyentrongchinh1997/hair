@extends('client.pages.rate.layouts.index')

@section('content')
    <script type="text/javascript">
        $(function(){
            $('.comment').click(function(){
                if($(this).is(":checked")) {
                    comment = $(this).val();
                    billId = $('#bill-id').val();
                    $.get('khach-hang/binh-luan/' + comment + '/' + billId);
                }
            })
            setTimeout(function(){
                   window.location.href='danh-gia';
               },5000);
        })
    </script>
    <center>
    <h2>30SHINE NÊN CẢI THIỆN ĐIỀU GÌ ĐỂ ANH HÀI LÒNG HƠN?</h2>
    <input type="hidden" id="bill-id" value="{{ $bill->id }}" name="">
        <table>
            <tr>
                <td>
                    <label>
                        <input class="comment" value="Tất cả đều tốt, không có góp ý gì;" type="checkbox" name="">
                        Tất cả đều tốt, không có góp ý gì
                    </label>
                </td>
                <td>
                    <label>
                        <input class="comment" type="checkbox" value="Chất lượng cắt và kiểu tóc;" name="">
                        Chất lượng cắt và kiểu tóc
                    </label>
                </td>
            </tr>
            <tr>
                <td>
                    <label>
                        <input class="comment" value="Thái độ phục vụ;" type="checkbox" name="">
                        Thái độ phục vụ
                    </label>
                </td>
                <td>
                    <label>
                        <input class="comment" value="Thời gian chờ đợi;" type="checkbox" name="">
                        Thời gian chờ đợi
                    </label>
                </td>
            </tr>
            <tr>
                <td>
                    <label>
                        <input class="comment" value="Nhân viên bớt làm ồn trong khi phục vụ;" type="checkbox" name="">
                        Nhân viên bớt làm ồn trong khi phục vụ
                    </label>
                </td>
                <td>
                    <label>
                        <input class="comment" value="Cảm thấy bị làm phiền bởi việc tư vấn dịch vụ (bán hàng);" type="checkbox" name="">
                        Cảm thấy bị làm phiền bởi việc tư vấn dịch vụ/bán hàng
                    </label>
                </td>
            </tr>
        </table>
        <p>Tiến trình sẽ tự động hoàn tất sau 5s</p>
    </center>
@endsection
