<h2 style="text-align: center;">
    CHI TIẾT ĐƠN {{ $orderDetail->id }}
    <input type="hidden" value="{{ $orderDetail->id }}" class="id-order" name="">
    <input type="hidden" value="{{ $orderDetail->customer->id }}" class="customer-id">
</h2>
<form onsubmit="return validateForm()" action="{{ route('check-in', ['id' => $orderDetail->id]) }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <table>
        <tr>
            <td>Ngày đặt lịch</td>
            <td>:</td>
            <td style="font-weight: bold;">
                @php 
                    $date = date_create($orderDetail->date)
                @endphp
                {{ date_format($date, 'd/m/Y') }}
            </td>
        </tr>
        <tr>
            <td>Tên dịch vụ</td>
            <td>:</td>
            <td style="font-weight: bold;">
                {{ $orderDetail->service->name }}
            </td>
        </tr>
        <tr class="update-customer-ajax">
            <script type="text/javascript">
                $(function(){
                  $('.update-customer').click(function(){
                    var birthday = $('.birthday').val();
                    var idCustomer = $('.customer-id').val();
                    var nameCustomer = $('.name-customer').val();
                    if (nameCustomer == '') {
                        alert("Cần nhập tên khách hàng");
                    } else if (birthday == '') {
                        alert("Cần nhập ngày sinh nhật khách hàng");
                    } else {
                        $.get('admin/khach-hang/cap-nhat/' + idCustomer + '/' + nameCustomer + '/' + birthday, function(data){
                            $('.update-customer-ajax').html(data);
                            $('.hidden-update-ajax').hide();
                        });
                    }
                  })

                  $('.check-in').click(function(){
                    var idOrder = $('.id-order').val();
                    $('#status' + idOrder + ' i').attr('class', 'fas fa-check-circle');
                    $('#status' + idOrder + ' i').attr('style', 'color: green; font-size: 25px');
                    if ($('.name-customer').val() == '' || $('.birthday').val() == '') {
                        alert('Cần điền tên và ngày sinh khách hàng');
                    } else {
                        $.get('admin/khach-hang/check/' + idOrder, function(data){
                            alert('check-in thành công');
                            location.reload();
                        });
                    }
                  })
                })

                function validateForm()
                {
                    var nameCustomer = $('.name-customer').val();
                    var birthday = $('.birthday').val();
                    if (nameCustomer == '' || birthday == '') {
                        alert('Cần điền tên và ngày sinh khách hàng');
                    } else {
                        return true;
                    }
                    return false
                }
            </script>
            <td>Tên khách hàng</td>
            <td>:</td>
            @if ($orderDetail->customer->full_name == '')
                <td>
                    <input type="text" name="full_name" placeholder="Nhập tên khách hàng" class="form-control name-customer">
                </td>
                <td>
                    <input type="date" class="form-control birthday" name="birthday">
                </td>
            @else
                <td style="font-weight: bold;">
                    {{ $orderDetail->customer->full_name }}
                </td>
                <td>
                    @php
                        $ngaySinh = date_create($orderDetail->customer->birthday)
                    @endphp
                    <span style="font-weight: bold;">Ngày sinh</span>: {{ date_format($ngaySinh, 'd/m/Y') }}
                </td>
            @endif
        </tr>
<!--         @if ($orderDetail->customer->birthday == '' && $orderDetail->customer->full_name == '')
            <tr class="hidden-update-ajax">
                <td></td>
                <td></td>
                <td>
                    <a class="btn btn-primary update-customer" style="color: #fff">Cập nhật</a>
                </td>
            </tr>
        @endif -->
        <tr>
            <td>Nhân viên phục vụ</td>
            <td>:</td>
            <td style="font-weight: bold;">
                {{ $orderDetail->employee->full_name }}
            </td>
        </tr>
        <tr>
            <td>
                Thời gian phục vụ
            </td>
            <td>:</td>
            <td style="font-weight: bold;">
                {{ $orderDetail->time->time }}
            </td>
        </tr>
        <tr>
            <td>
                Giá dịch vụ
            </td>
            <td>:</td>
            <td style="font-weight: bold;">
                {{ number_format($orderDetail->service->price) }}<sup>đ</sup>
            </td>
        </tr>
        <tr>
            <td>Trạng thái</td>
            <td>:</td>
            <td class="status-ajax" style="font-weight: bold;">
                @if ($orderDetail->status == config('config.order.status.create'))
                    <span>Đợi check in</span>
                @elseif($orderDetail->status == config('config.order.status.check-in'))
                    <span style="color: green">Đã check in</span>
                @else
                    <span style="color: #007bff">Đã thanh toán</span>
                @endif
            </td>
        </tr>
    </table>
    <center class="test">
        <input type="submit" value="CHECK-IN" class="btn btn-primary" name="">
    </center>
</form>