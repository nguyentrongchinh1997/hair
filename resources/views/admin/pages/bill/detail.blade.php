<script type="text/javascript">
    function addCommas(nStr)
    {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }
    $('#price-dif, #sale').keyup(function(event) {
      // skip for arrow keys
      if(event.which >= 37 && event.which <= 40) return;
      // format number
      $(this).val(function(index, value) {
        return value
        .replace(/\D/g, "")
        .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        ;
      });
    });
    $('#sale').focus(function(){
        $('#sale').val('');
    })
</script>
<style type="text/css">
    .header-order tr td{
        padding: 0px !important;
    }
</style>
<div class="col-lg-12 detail-order">
    <div class="row">
        <div class="col-lg-6">
            <p style="font-weight: bold; margin-bottom: 0px">
                CHI TIẾT ĐƠN {{ $bill->id }}
            </p>
            <p style="margin-bottom: 0px">
                @php 
                    $date = date_create($bill->date)
                @endphp
                {{ date_format($date, 'd/m/Y') }}
            </p>
            <p style="font-weight: bold;">
                SĐT: {{ substr($bill->customer->phone, 0, 4) }}.{{ substr($bill->customer->phone, 4, 3) }}.{{ substr($bill->customer->phone, 7, 3) }}
            </p>
        </div>
        <div class="col-lg-6">
            <table class="header-order" style="width: 100%">
                <tr>
                    <td>
                        Khách hàng
                    </td>
                    <td>:</td>
                    <td style="text-align: right;">
                        <span style="font-weight: bold;">
                            {{ $bill->order->customer->full_name }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        Số dư
                    </td>
                    <td>:</td>
                    <td style="text-align: right; font-weight: bold;">
                        <span>{{ number_format($bill->order->customer->balance) }}</span><sup>đ</sup>
                    </td>
                </tr>
                <tr>
                    <td>Trạng thái</td>
                    <td>:</td>
                    <td class="status-ajax" style="font-weight: bold; text-align: right;">
                        @if ($bill->status == config('config.order.status.check-in'))
                            <span style="color: red; font-weight: bold; font-size: 20px">Đợi thanh toán</span>
                        @elseif($bill->status == config('config.order.status.check-out'))
                            <span style="color: #007bff; font-weight: bold; font-size: 20px">Hoàn thành</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div><hr>
    <div class="col-lg-12">
        <input type="hidden" id="bill_id" value="{{ $bill->id }}" class="id-order" name="">
        <input type="hidden" id="employee_id" value="{{ $bill->order->employee_id }}" class="customer-id">
        <input type="hidden" id="price_total" value="{{ $moneyServiceTotal }}" name="">
        <table style="width: 100%" class="list-table">
            @if ($bill->customer->membership->count() > 0)
            <tr>
                <td style="width: 40%">Thẻ của khách</td>
                <td style="width: 50%">
                    <table style="width: 100%">
                        <tr style="background: #BBDEFB; font-weight: bold;">
                            <td>Tên thẻ</td>
                            <td>Ưu đãi</td>
                        </tr>
                        @foreach ($bill->customer->membership as $card)
                            @if ($card->status == 1)
                                <tr>
                                    <td>
                                        {{ $card->card->card_name }}
                                    </td>
                                    <td>
                                        @foreach ($card->card->cardDetail as $service)
                                            <p style="margin-bottom: 0px">
                                                {{$service->service->name }}
                                                <span>
                                                    @if ($service->number == '')
                                                        (tặng {{ $service->percent }}%)
                                                    @else
                                                        (còn {{ $card->number }} lần sử dụng)
                                                    @endif
                                                </span>
                                                
                                            </p>
                                        @endforeach
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                </td>
            </tr>
            @endif
            @if ($bill->status == config('config.order.status.check-out'))
                <tr>
                    <td style="width: 40%">Đã thanh toán</td>
                    <td style="font-weight: bold; width: 50%">
                        {{ number_format($bill->total) }}<sup>đ</sup>
                        <input type="hidden" value="{{ $bill->customer->balance }}" id="balance" name="">
                    </td>
                </tr>
                <tr>
                    <td>
                        Đánh giá khách hàng
                    </td>

                    <td style="font-weight: bold;">
                        {{ $bill->rate->name }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Góp ý khách hàng
                    </td>

                    <td style="font-weight: bold;">
                        {{ $bill->comment }}
                    </td>
                </tr>
            @endif
            @foreach ($serviceList as $service)
                <tr class="service-fee" id="service{{$service->id}}">
                    <td>
                        {{ $service->name }}
                    </td>
                    <td>:</td>
                    <td style="font-weight: bold;">
                        {{ number_format($service->price) }}<sup>đ</sup>
                        <input type="hidden" id="hidden{{ $service->id }}" value="0" name="">
                    </td>
                </tr>
            @endforeach
        </table>
    </div><br>
    <div class="col-lg-12">
        @if ($bill->status != config('config.order.status.check-out'))
            <button style="float: right; margin-bottom: 20px" type="button" class="button-control add-service btn btn-primary" data-toggle="modal" data-target="#myModal">
                Thêm dịch vụ
            </button>
            <button style="float: left; margin-bottom: 20px; background: #FF9800; border: 0px" type="button" class="add-service btn btn-primary button-control" data-toggle="modal" data-target="#service-other">
                Thêm dịch vụ khác
            </button>
        @endif
        <div class="modal fade" id="service-other">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h3 class="modal-title">Thêm dịch vụ khác</h3>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <table class="service-other">
                        <tr>
                            <td>
                                Tên dịch vụ
                            </td>
                            <td>
                                <input type="text" id="service-dif" placeholder="Nhập tên dịch vụ..." class="form-control input-control" name="">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Chọn thợ chính
                            </td>
                            <td>
                                @foreach ($employeeList as $employee)
                                    <input type="hidden" id="name-employee-other{{ $employee->id }}" value="{{ $employee->full_name }}" name="">
                                @endforeach
                                <table>
                                    <tr>
                                        <td>
                                            Chọn thợ
                                        </td>
                                        <td>
                                            <select onchange="employeeForServiceOther()" id="employeeForServiceOther" class="option-employee form-control input-control">
                                                <option value="0">Chọn thợ</option>
                                                @foreach ($employeeList as $employee)
                                                    <option @if ($employee->id == $bill->order->employee_id) {{ 'selected' }} @endif value="{{ $employee->id }}">
                                                        {{ $employee->id }}-{{ $employee->full_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label style="margin-top: 8px; font-weight: bold">
                                                Chiết khấu (%)
                                            </label>
                                        </td>
                                        <td>
                                            <input id="percent-employee" placeholder="% thợ chính" type="number" class="form-control input-control" name="">
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Chọn thợ phụ <span style="color: red">(nếu cần)</span>
                            </td>
                            <td>
                                @foreach ($employeeList as $employee)
                                    <input type="hidden" class="input-control" id="name-assistant-other{{ $employee->id }}" value="{{ $employee->full_name }}" name="">
                                @endforeach
                                <table>
                                    <tr>
                                        <td>Chọn thợ</td>
                                        <td>
                                            <select onchange="employeeAssistantForServiceOther()" id="employee-assistant-for-service-other" class="option-employee form-control input-control">
                                                <option value="0">Chọn thợ</option>
                                                @foreach ($employeeList as $employee)
                                                    <option @if ($employee->id == $bill->order->employee_id) {{ 'selected' }} @endif value="{{ $employee->id }}">
                                                            {{ $employee->id }}-{{ $employee->full_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label style="margin-top: 8px; font-weight: bold">
                                                Chiết khấu (%)
                                            </label>
                                        </td>
                                        <td>
                                            <input id="percent-assistant" placeholder="% thợ phụ" type="number" class="input-control form-control" name="">
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Giá dịch vụ
                            </td>
                            <td>
                                <input type="text" id="price-dif" id="formattedNumberField" placeholder="Điền giá dịch vụ..." class="form-control input-control" name="">
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <button data-dismiss="modal" style="font-weight: normal; float: left; width: 50%; background: #007bff; color: #fff; opacity: 1;" id="add-other-service" class="close btn btn-primary button-control">
                                    THÊM
                                </button>
                            </td>
                        </tr>
                        <script type="text/javascript">
                            function employeeForServiceOther()
                            {
                                id = $('#employeeForServiceOther').val();
                                
                                return id;
                            }
                            function employeeAssistantForServiceOther()
                            {
                                id = $('#employee-assistant-for-service-other').val();
                                
                                return id;
                            }
                            $('#add-other-service').click(function(){
                                var bill_id = $('#bill_id').val();
                                var percentAssistant = $('#percent-assistant').val(); // % thợ phụ
                                var percentEmployee = $('#percent-employee').val(); // %thợ chính
                                var serviceDif = $('#service-dif').val(); // tên dịch vụ
                                var priceDif = $('#price-dif').val();
                                // var percentDif = $('#percent-dif').val();
                                var employeeId = employeeForServiceOther();
                                var assistantId = employeeAssistantForServiceOther();
                                var nameEmployee = $('#name-employee-other' + employeeId).val();
                                var nameAssistant = $('#name-assistant-other' + assistantId).val();
                                if (serviceDif == '') {
                                    alert('Cần điền tên dịch vụ');
                                } else if (priceDif == '') {
                                    alert('Cần điền giá dịch vụ'); 
                                } else if (employeeId == 0) {
                                    alert('Cần chọn thợ chính');
                                } else if (percentEmployee == '') {
                                    alert('Cần điền % cho thợ chính');
                                } else if (assistantId != 0 && percentAssistant == '') {
                                    alert('Cần điền % cho thợ phụ');
                                } else if (assistantId == 0 && percentAssistant != '') {
                                    alert('Cần chọn thợ phụ');
                                } else {
                                    var convertPrice = priceDif.replace(/[,]/g,'');
                                    $.get('admin/hoa-don/dich-vu-khac/them?billId=' + bill_id + '&serviceName=' + serviceDif + '&employeeId=' + employeeId + '&assistantId=' + assistantId + '&money=' + priceDif + '&percentEmployee=' + percentEmployee + '&percentAssistant=' + percentAssistant, function(data){
                                        if (data != '') {
                                            if (assistantId == 0) {
                                                nameAssistant = '';
                                            }
                                            $('#service-dif, #percent-employee, #percent-assistant, #price-dif').val('');
                                            $('#list-table').append(data);
                                        } else {
                                            alert('Hóa đơn đã được thanh toán, bạn không thể thêm dịch vụ.');
                                        }
                                    });
                                }
                            })
                        </script>
                    </table>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
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
                                <select onchange="optionEmployee()" id="option-employee" class="option-employee form-control input-control">
                                        <option value="0">Chọn thợ chính</option>
                                    @foreach ($employeeList as $employee)
                                            <option @if ($employee->id == $bill->order->employee_id) {{ 'selected' }} @endif value="{{ $employee->id }}">
                                                {{ $employee->id }}-{{ $employee->full_name }}
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
                                <select onchange="optionAssistant()" class="assistant form-control input-control">
                                        <option value="0">Chọn thợ phụ (nếu cần)</option>
                                    @foreach ($employeeList as $employee)
                                            <option @if ($employee->id == $bill->order->employee_id) {{ 'selected' }} @endif value="{{ $employee->id }}">
                                                {{ $employee->id }}-{{ $employee->full_name }}
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
        <table class="list-table" id="list-table">
            <tr style="background: #BBDEFB">
                <th>Dịch vụ</th>
                <th>Thợ chính</th>
                <th>Thợ phụ</th>
                <th>Giá</th>
                <th>Thẻ sử dụng</th>
                <th>Xóa</th>
            </tr>
            @foreach ($serviceListUse as $service)
                <tr id="row{{ $service->id }}">
                    <td>
                        @if ($service->service_id != '') 
                            {{ $service->service->name }}
                        @else
                            {{ $service->other_service }}
                        @endif
                    </td>
                    <td>
                        {{ $service->employee->full_name }}
                    </td>
                    <td>
                        @if ($service->assistant_id != '')
                            {{ $service->employeeAssistant->full_name }}
                        @endif
                    </td>
                    <td id="price{{ $service->id }}" style="text-align: right;">
                        {{ number_format($service->sale_money) }}<sup>đ</sup>
                    </td>
                    <td>
                        @if ($bill->status < config('config.order.status.check-out'))
                            <select onchange="service({{ $service->id }})" id="card{{$service->id}}" class="form-control input-control">
                                <option value="0">
                                    Chọn thẻ
                                </option>
                                @php $dateNow = date('Y-m-d'); @endphp
                                @foreach ($bill->customer->membership as $membership)
                                    @if ($membership->status == 1 && ($membership->start_time == '' || strtotime($dateNow) >= strtotime($membership->start_time)) && (App\Helper\ClassHelper::checkEmptyServiceInCard($service->service->id, $membership->card->id)) > 0)
                                        <option @if ($membership->card->id == $service->card_id) {{ 'selected' }} @endif value="{{ $membership->card->id }}">
                                            {{ $membership->card->card_name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        @else
                            <span>
                                {{
                                    ($service->card_id != '' ? $service->card->card_name : '')
                                }}
                            </span>
                        @endif
                       
                        <script type="text/javascript">
                            function service(idBillDetail)
                            {
                                cardId = $('#card' + idBillDetail).val();
                                if (cardId != 0) {
                                    $.get('admin/hoa-don/kiem-tra-the/' + idBillDetail + '/' + cardId, function(data){
                                        $('#price' + idBillDetail).html(data);
                                    })
                                } else if (cardId == 0) {
                                    $.get('admin/hoa-don/khoi-phuc/' + idBillDetail, function(data){
                                        $('#price' + idBillDetail).html(data);
                                    })
                                }
                            }
                        </script>
                    </td>
                    <td style="text-align: center;">
                        @if ($bill->status < config('config.order.status.check-out'))
                            <i onclick="xoa({{ $service->id }})" style="cursor: pointer; color: red" class="fas fa-times" id="close{{ $service->id }}"></i>
                        @else
                            <i style="cursor: pointer; color: #ccc" class="fas fa-times"></i>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table><br>
        <table style="width: 100%">
            @if ($bill->status == config('config.order.status.check-out'))
                <tr>
                    <td style="width: 40%">Quà tặng (vnd)</td>
                    <td style="width: 10%">:</td>
                    <td style="font-weight: bold; width: 50%">
                        {{ number_format($bill->sale) }}<sup>đ</sup>
                    </td>
                </tr>
            @else
                <tr>
                    <td style="width: 40%">
                        Quà tặng (vnd)
                    </td>
                    <td style="width: 10%">:</td>
                    <td style="width: 50%">
                        <input type="text" placeholder="0" value="{{ $bill->sale }}" id="sale" class="form-control input-control" name="">
                    </td>
                    
                </tr>
            @endif

            @if ($bill->status == config('config.order.status.check-out'))
                <tr>
                    <td>Nội dung giảm giá</td>
                    <td>:</td>
                    <td style="font-weight: bold;">
                        {{ ($bill->sale_detail == '') ? 'không có' : $bill->sale_detail }}
                    </td>
                </tr>
            @else
                <tr>
                    <td>
                        Nội dung giảm giá
                    </td>
                    <td>:</td>
                    <td>
                        <input type="text" value="{{ $bill->sale_detail }}" class="input-control form-control" placeholder="Nội dùng giảm giá" id="sale_detail" name="">
                    </td>
                </tr>
            @endif
        </table>
    </div>
    <div class="col-lg-12" style="margin-top: 20px">
        <center>
            @if ($bill->status != config('config.order.status.check-out'))
                <!-- <h2 class="btn btn-primary pay" data-toggle="modal" data-target="#rate">Thanh toán</h2> -->
                <h2 style="width: 100%" data-toggle="modal" data-target="#rate" class="rate pay btn btn-primary">Thanh toán</h2>
                
            @endif
        </center>
        <div class="modal fade" id="rate">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                      <h3 class="modal-title">Thanh toán dịch vụ</h3>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body" id="modal-body">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('.pay').click(function(){
        billId = $('#bill_id').val();
        sale_detail = $('#sale_detail').val();
        sale = $('#sale').val();
        // $.get('danh-gia/noi-dung/' + billId);
        $.get('admin/hoa-don/cap-nhat/thu-ngan/' + billId);
        
        if (sale == '') {
            sale = 0;
        }
        if (sale_detail == '') {
            sale_detail = 0;
        }
        $.get("admin/hoa-don/thanh-toan/" + billId + '?sale=' + sale + '&saleDetail=' + sale_detail, function(data){
            $('#modal-body').html(data);
        });
        // window.open("admin/hoa-don/thanh-toan/" + billId, "_blank", "width=500, height=600");
    })
</script>
<script type="text/javascript">
    function optionEmployee()
    {
        var id = $('#option-employee').val();

        return id;
    }
    function optionAssistant()
    {
        var id = $('.assistant').val();

        return id;
    }
    stt = 0;
    $('#formattedNumberField').keyup(function(event) {
      // skip for arrow keys
      if(event.which >= 37 && event.which <= 40) return;

      // format number
      $(this).val(function(index, value) {
        return value
        .replace(/\D/g, "")
        .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        ;
      });
    });
    $('#add-service').click(function(){
        var serviceId = $('.option-service').val();
        var employeeId = optionEmployee();
        var assistantId = optionAssistant();
        var bill_id = $('#bill_id').val();
        if (serviceId == 0) {
            alert('Cần chọn dịch vụ sử dụng');
        } else if (employeeId == 0) {
            alert('Cần chọn thợ chính');
        } else {
            $.get('admin/hoa-don/dich-vu/them?billId=' + bill_id + '&serviceId=' + serviceId + '&employeeId=' + employeeId + '&assistantId=' + assistantId, function(data){
                    $('.option-service, #option-employee, .assistant').val(0);
                    $('#list-table').append(data);
            });
        }
    })
    
    function xoa(id)
    {
        if (confirm('Bạn có muốn xóa dịch vụ này không?')) {
            priceTotal = $('#total-all').val();
            $.get('admin/hoa-don/xoa/dich-vu/' + id, function(data){
                $('#total-all').val(parseInt(priceTotal) - parseInt(data));
                if (data != '') {
                    $('.total-service').html(addCommas(parseInt(priceTotal) - parseInt(data)));
                    $('#row' + id).remove();
                } else {
                    alert('Hóa đơn đã hoàn thành, bạn không được phép xóa.');
                }  
            })   
        } else {
            return false;
        }
        
    }
</script>