<style type="text/css">
    p{
        margin-bottom: 0px;
    }
    .header-order tr td{
        padding: 0px !important;
    }
</style>
<div class="col-lg-12 detail-order right">
    <div class="row">
        <div class="col-lg-6">
            <p style="font-weight: bold;">
                CHI TIẾT ĐƠN {{ $orderDetail->id }}
            </p>
            <p>
                @php 
                    $date = date_create($orderDetail->date)
                @endphp
                {{ date_format($date, 'd/m/Y') }}
            </p>
        </div> 
        <div class="col-lg-6">
            <input type="hidden" value="{{ $orderDetail->id }}" class="id-order" name="">
            <input type="hidden" value="{{ $orderDetail->customer->id }}" class="customer-id">
            <table class="header-order" style="width: 100%">
                <tr>
                    <td style="width: 40%">
                        Khách hàng
                    </td>
                    <td style="width: 10%">:</td>
                    <td style="text-align: right; width: 50%">
                        @if ($orderDetail->customer->full_name == '')
                            <span>
                                <i>Chưa có thông tin</i>
                            </span>
                        @else
                            <span style="font-weight: bold;">
                                {{ $orderDetail->customer->full_name }}
                            </span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>
                        Số dư
                    </td>
                    <td>:</td>
                    <td style="text-align: right; font-weight: bold;">
                        <span>{{ number_format($orderDetail->customer->balance) }}</span><sup>đ</sup>
                    </td>
                </tr>
                <tr>
                    <td>Trạng thái</td>
                    <td>:</td>
                    <td class="status-ajax" style="font-weight: bold; text-align: right;">
                        @if ($orderDetail->status == config('config.order.status.create'))
                            <span style="color: red">Đợi check in</span>
                        @elseif($orderDetail->status == config('config.order.status.check-in'))
                            <span style="color: green">Đã check in</span>
                        @else
                            <span style="color: #007bff">Đã thanh toán</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div><hr>
    <div class="row" style="margin-top: 40px">
        <div class="col-lg-12">
            <form onsubmit="return validateForm()" action="{{ route('check-in', ['id' => $orderDetail->id]) }}" method="post">
                @csrf
                <table>
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
                                var employee_id = $('.employee').val();
                                if (nameCustomer == '' || birthday == '') {
                                    alert('Cần điền tên và ngày sinh khách hàng');
                                } else if (employee_id == 0) {
                                    alert('Cần chọn thợ phục vụ');
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
                            <td style="padding: 5px">
                                Ngày sinh
                            </td>
                            <td style="padding: 5px">:</td>
                            <td>
                                <input type="date" class="form-control birthday" name="birthday">
                            </td>
                        @else
                            <td style="font-weight: bold;">
                                {{ $orderDetail->customer->full_name }}
                            </td>
                            <td style="padding-left: 20px">
                                @php
                                    $ngaySinh = date_create($orderDetail->customer->birthday)
                                @endphp
                                <span style="font-weight: bold;">Ngày sinh</span>: {{ date_format($ngaySinh, 'd/m/Y') }}
                            </td>
                        @endif
                    </tr>
                    <tr>
                        <td>
                            Thời gian phục vụ
                        </td>
                        <td style="padding: 15px">:</td>
                        <td style="font-weight: bold;">
                            {{ $orderDetail->time->time }}
                        </td>
                    </tr>
                </table>
                <p class="notification" style="text-align: center; font-size: 30px">
                    
                </p>
                <table class="list-service-order">
                    <tr>
                        <th>Dịch vụ</th>
                        <th>Thợ chính</th>
                        <th>Thợ phụ (nếu cần)</th>
                        <th>Giá</th>
                        @if ($orderDetail->status == config('config.order.status.check-in'))
                            <th>Xóa</th>
                        @endif
                    </tr>
                    @foreach ($orderDetail->orderDetail as $serviceOrder)
                        <tr id="row{{ $serviceOrder->id }}">
                            <td>
                                <select onchange="editService({{ $serviceOrder->id }})" id="service{{ $serviceOrder->id }}" style="width: 100%" class="form-control">
                                    @foreach ($serviceList as $service)
                                        <option value="{{ $service->id }}" @if ($service->id == $serviceOrder->service_id) {{ 'selected' }} @endif value="{{ $service->id }}">
                                            {{ $service->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select onchange="editEmployee({{ $serviceOrder->id }})" id="employee{{ $serviceOrder->id }}" name="employee_id" class="form-control employee">
                                    @if ($serviceOrder->employee_id == '')
                                        <option value="0">Chọn thợ</option>
                                    @endif
                                    @foreach ($employeeList as $employee)
                                        <option @if ($employee->id == $serviceOrder->employee_id) {{ 'selected' }}@endif value="{{ $employee->id }}">
                                            {{ $employee->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select onchange="assistant({{ $serviceOrder->id }})" id="assistant{{ $serviceOrder->id }}" name="employee_id" class="form-control employee">
                                    <option value="0">Chọn thợ phụ</option>
                                    @foreach ($employeeList as $employee)
                                        <option 
                                        @if ($serviceOrder->assistant_id != '' && $serviceOrder->assistant_id == $employee->id)
                                            {{ 'selected' }}
                                        @endif
                                        value="{{ $employee->id }}">
                                            {{ $employee->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td style="text-align: right;">
                                {{ number_format($serviceOrder->service->price) }}<sup>đ</sup>
                            </td>
                            @if ($orderDetail->status == config('config.order.status.create'))
                                <td style="text-align: center; color: red">
                                    <a style="color: red" onclick="return deleteService({{ $serviceOrder->id }})">
                                        <i style="cursor: pointer;"  class="fas fa-times"></i>
                                    </a>
                                </td>
                            @endif
                        </tr>
                    @endforeach

                </table>
                @if ($orderDetail->status == config('config.order.status.create'))
                    <center class="test" style="margin-top: 30px">
                        <input style="width: 140px; height: 50px; font-size: 20px" type="submit" value="CHECK-IN" class="btn btn-primary" name="">
                    </center>
                @endif
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    function deleteService(serviceId)
    {
        var orderId = $('.id-order').val();
        if (confirm('Bạn có muốn xóa dịch vụ này không')) {
            $.get('admin/dat-lich/xoa/' + serviceId + '/' + orderId, function(data){
                if (data == 1) {
                    $('.notification').html('<span style="color: green; font-weight: bold">Xóa thành công</span>');
                    $('#row' + serviceId).remove();
                } else {
                    $('.notification').html('<span style="color: red; font-weight: bold">Không được xóa</span>');
                }
                
            })
            
            return true;
        }
        return false;
    }

    function editService(id)
    {
        serviceId = $('#service' + id).val();
        $.get('admin/dat-lich/dich-vu/sua/' + serviceId + '/' + id);
    }

    function editEmployee(id)
    {
        employeeId = $('#employee' + id).val();
        $.get('admin/dat-lich/nhan-vien/sua/' + employeeId + '/' + id);
    }

    function assistant(id) {
        assisatantId = $('#assistant' + id).val();
        
        $.get('admin/dat-lich/nhan-vien/cap-nhat/' + assisatantId + '/' + id);
    }
</script>