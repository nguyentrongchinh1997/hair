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
                            <span style="color: red; font-size: 20px">Đợi check in</span>
                        @elseif($orderDetail->status == config('config.order.status.check-in'))
                            <span style="color: green; font-size: 20px">Đã check in</span>
                        @else
                            <span style="color: #007bff; font-size: 20px">Đã thanh toán</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div><hr>
    <div class="row">
        <div class="col-lg-12">
            <form onsubmit="return validateForm()" action="{{ route('check-in', ['id' => $orderDetail->id]) }}" method="post">
                @csrf
                <table style="width: 100%" class="order-detail list-table">
                    <tr class="update-customer-ajax">
                    @if ($orderDetail->customer->full_name == '')
                        <tr>
                            <td>Tên khách hàng</td>
                            <td>
                                <input type="text" name="full_name" placeholder="Nhập tên khách hàng" class="form-control name-customer input-control">
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td>Tên khách hàng</td>
                            <td style="font-weight: bold;">
                                {{ $orderDetail->customer->full_name }}
                            </td>
                            <input type="hidden" value="{{ $orderDetail->customer->full_name }}" name="full_name" placeholder="Nhập tên khách hàng" class="form-control name-customer input-control">
                        </tr>
                    @endif

                    @if ($orderDetail->customer->birthday == '')
                        <tr>
                            <td>
                                Ngày sinh
                            </td>
                            <td>
                                <input type="date" class="form-control birthday input-control" name="birthday">
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td>
                                Ngày sinh
                            </td>
                            <td>
                                @php
                                    $ngaySinh = date_create($orderDetail->customer->birthday)
                                @endphp
                                {{ date_format($ngaySinh, 'd/m/Y') }}
                            </td>
                        </tr>
                    @endif
                    
                    
                    <tr>
                        <td>
                            Thời gian phục vụ
                        </td>
                        <td style="font-weight: bold;">
                            {{ $orderDetail->time->time }}
                        </td>
                    </tr>
                    <tr>
                        <td>Khách yêu cầu</td>
                        <td>
                            <label style="margin-right: 10px">
                                <input
                                    @if ($orderDetail->request == config('config.request.yes')) {{'checked'}} @endif
                                type="radio" value="1" name="require"> Có
                            </label>
                            <label>
                                <input 
                                    @if ($orderDetail->request == config('config.request.no')) {{'checked'}} @endif
                                style="padding-left: 10px" value="0" type="radio" name="require"> Không
                            </label>
                            
                        </td>
                        
                    </tr>
                </table><br>
                <p class="notification" style="text-align: center; font-size: 20px; margin-bottom: 10px">
                    
                </p>
                @if ($orderDetail->status == config('config.order.status.create'))
                <button style="float: right; margin-bottom: 20px" type="button" class="button-control add-service btn btn-primary" data-toggle="modal" data-target="#myModal">
                    Thêm dịch vụ
                </button>
                @endif
                <table class="list-table" id="list-table">
                    <tr style="background: #BBDEFB">
                        <th>Dịch vụ</th>
                        <th>Thợ chính</th>
                        <th>Thợ phụ (nếu cần)</th>
                        <th>Giá</th>
                        <th>Xóa</th>
                    </tr>
                    @foreach ($orderDetail->orderDetail as $serviceOrder)
                        <tr id="row{{ $serviceOrder->id }}">
                            <td>
                                <select 
                                    @if ($orderDetail->status != config('config.order.status.create'))
                                        {{ 'disabled' }}
                                    @endif 
                                    onchange="editService({{ $serviceOrder->id }})" 
                                    id="service{{ $serviceOrder->id }}" 
                                    style="width: 100%" name="service1[]" class="chosen service form-control input-control"
                                >
                                    <option value="0">Chưa chọn</option>
                                    @foreach ($serviceList as $service)
                                        <option value="{{ $service->id }}" 
                                            @if ($service->id == $serviceOrder->service_id) 
                                                {{ 'selected' }} 
                                            @endif 
                                            value="{{ $service->id }}">
                                            {{ $service->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select 
                                    @if ($orderDetail->status != config('config.order.status.create'))
                                        {{ 'disabled' }}
                                    @endif 
                                    onchange="editEmployee({{ $serviceOrder->id }})" 
                                    id="employee{{ $serviceOrder->id }}" name="employee1[]" 
                                    class="form-control chosen input-control employee"
                                >
                                    @if ($serviceOrder->employee_id == '')
                                        <option value="0">Chọn thợ</option>
                                    @endif
                                    @foreach ($employeeList as $employee)
                                            <option  @if ($employee->id == $serviceOrder->employee_id) {{ 'selected' }}@endif value="{{ $employee->id }}">
                                                {{ $employee->full_name }}
                                            </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select 
                                    @if ($serviceOrder->service_id == 2)
                                        {{ "disabled='disabled'" }}
                                    @endif
                                    @if ($orderDetail->status != config('config.order.status.create'))
                                        {{ 'disabled' }}
                                    @endif 
                                    onchange="assistant({{ $serviceOrder->id }})" 
                                    id="assistant{{ $serviceOrder->id }}" 
                                    class="form-control chosen input-control employee"
                                >
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
                            <td id="price{{ $serviceOrder->id }}" style="text-align: right;">
                                @if ($serviceOrder->service_id != 0)
                                {{ number_format($serviceOrder->service->price) }}<sup>đ</sup>
                                @endif
                            </td>
                            
                            <td style="text-align: center; color: red">
                                @if ($orderDetail->status == config('config.order.status.create'))
                                    <a style="color: red" onclick="return deleteService({{ $serviceOrder->id }})">
                                        <i style="cursor: pointer;"  class="fas fa-times"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
                @if ($orderDetail->status == config('config.order.status.create'))
                    <center class="test" style="margin-top: 30px">
                       <!--  <input style="width: 140px; height: 40px; font-size: 20px" type="submit" value="Check-in" class="btn btn-primary" name=""> -->
                        <button style="margin-top: 30px" type="submit" class="btn btn-primary button-control">Check-in</button>
                    </center>
                @endif
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    var statusOrder = {{ $orderDetail->status }};
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
        if (serviceId == 2) {
            $('#assistant' + id).prop('disabled', true);
        } else {
            $('#assistant' + id).prop('disabled', false);
        }
        $.get('admin/dat-lich/dich-vu/sua/' + serviceId + '/' + id, function(data){
            $('#price' + id).html(data);
        });
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

<div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title">Thêm dịch vụ</h3>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <table class="service-other">
                <tr>
                    <td>
                        Dịch vụ
                    </td>
                    <td>
                        @foreach ($serviceList as $service)
                            <input data="{{ $service->price }}" class="input-control" type="hidden" id="name-service{{ $service->id }}" value="{{ $service->name }}" name="">
                        @endforeach
                        <select class="option-service form-control input-control">
                            <option value="0">Chọn dịch vụ</option>
                            @foreach ($serviceList as $service)
                                <option value="{{ $service->id }}">
                                    {{ $service->name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        Chọn thợ chính
                    </td>
                    <td>
                        @foreach ($employeeList as $employee)
                            <input type="hidden" id="name-employee{{ $employee->id }}" value="{{ $employee->full_name }}" name="">
                        @endforeach
                        <select id="option-employee" class="option-employee form-control input-control">
                                <option value="0">Chọn thợ chính</option>
                            @foreach ($employeeList as $employee)
                                    <option value="{{ $employee->id }}">
                                        {{ $employee->full_name }}
                                    </option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        Chọn thợ phụ <span style="color: red">(nếu cần)</span>
                    </td>
                    <td>
                        @foreach ($employeeList as $employee)
                            <input type="hidden" id="name-assistant{{ $employee->id }}" value="{{ $employee->full_name }}" name="">
                        @endforeach
                        <select class="assistant form-control input-control">
                                <option value="0">Chọn thợ phụ (nếu cần)</option>
                            @foreach ($employeeList as $employee)
                                    <option value="{{ $employee->id }}">
                                        {{ $employee->full_name }}
                                    </option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                
                <tr>

                </tr>
                <tr>
                    <td></td>
                    <td>
                        <button data-dismiss="modal" style="font-weight: normal; float: left; width: 50%;background: #007bff; color: #fff; opacity: 1;" id="add-service" class="close btn btn-primary button-control">
                            THÊM
                        </button>
                    </td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $('#add-service').click(function(){
            orderId = $('.id-order').val();
            serviceId = $('.option-service').val();
            employeeId = $('#option-employee').val();
            assistantId = $('.assistant').val();
            if (serviceId == 0) {
                alert('Cần chọn dịch vụ sử dụng');
            } else if (employeeId == 0) {
                alert('Cần chọn thợ chính');
            } else {
                $.get('admin/dat-lich/dich-vu/them?orderId=' + orderId + '&serviceId=' + serviceId + '&employeeId=' + employeeId + '&assistantId=' + assistantId, function(data){
                        $('.option-service, #option-employee, .assistant').val(0);
                        $('#list-table').append(data);
                });
            }
        })
        
    })
</script>
<script type="text/javascript">
    $(function(){
        $(".chosen").chosen();
    })
    
</script>
<script type="text/javascript">
    function validateForm()
    {
        var nameCustomer = $('.name-customer').val();
        var birthday = $('.birthday').val();
        var employee = document.getElementsByName('employee1[]');
        var service = document.getElementsByName('service1[]');
        for (var i = 0; i < service.length; i++) {
            var serviceValue = service[i];
            if (serviceValue.value == 0) {
                alert("Chọn thiếu dịch vụ");

                return false;
            }
        }
        for (var i = 0; i < employee.length; i++) {
            var inp = employee[i];

            if (inp.value == 0) {
                alert("chưa chọn thợ phục vụ");

                return false;
            }
        }
        if (service == 0) {
            alert('Bạn cần chọn dịch vụ');

            return false;
        } else if (nameCustomer == '') {
            alert('Cần điền tên khách hàng');

            return false;
        } else if (birthday == '') {
            alert('Cần điền ngày sinh khách hàng');

            return false;
        } else {
            return true;
        }
        return false;
    }
    // $(function(){
    //     $('.update-customer').click(function(){
    //         var birthday = $('.birthday').val();
    //         var idCustomer = $('.customer-id').val();
    //         var nameCustomer = $('.name-customer').val();
    //         if (nameCustomer == '') {
    //             alert("Cần nhập tên khách hàng");
    //         } else if (birthday == '') {
    //             alert("Cần nhập ngày sinh nhật khách hàng");
    //         } else {
    //             $.get('admin/khach-hang/cap-nhat/' + idCustomer + '/' + nameCustomer + '/' + birthday, function(data){
    //                 $('.update-customer-ajax').html(data);
    //                 $('.hidden-update-ajax').hide();
    //             });
    //         }
    //     })

    //     $('.check-in').click(function(){
    //         var idOrder = $('.id-order').val();
    //         $('#status' + idOrder + ' i').attr('class', 'fas fa-check-circle');
    //         $('#status' + idOrder + ' i').attr('style', 'color: green; font-size: 25px');
    //         if ($('.name-customer').val() == '') {
    //             alert('Cần điền tên khách hàng');
    //         } else if ($('.birthday').val() == '') {
    //             alert('Cần điền ngày sinh khách hàng');
    //         } else {
    //             $.get('admin/khach-hang/check/' + idOrder, function(data){
    //                 alert('check-in thành công');
    //                 location.reload();
    //             });
    //         }
    //     })
    // })
    
</script>