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
    // $('.add-sale').click(function(){
    //     bill_id = $('#bill_id').val();
    //     sale_detail = $('#sale_detail').val();
    //     sale = $('#sale').val();
    //     if (sale_detail == '') {
    //         alert('Cần điền nội dung quà tặng');
    //     } else if (sale == '') {
    //         alert('Cần điền số tiền muốn tặng');
    //     } else {
    //         $.get('admin/hoa-don/giam-gia/cap-nhat/' + bill_id + '?sale=' + sale + '&saleDetail=' + sale_detail , function(data){
    //             if (data == '') {
    //                 alert('Hóa đơn được hoàn thành. Bạn không được thêm quà tặng.')
    //             } else {
    //                 alert('Cập nhập thành công');
    //             }
    //         });
    //     }
    // })
</script>
<style type="text/css">
    .header-order tr td{
        padding: 0px !important;
    }
</style>
<div class="col-lg-12 detail-order">
    <div class="row">
        <div class="col-lg-6">
            <p style="font-weight: bold;">
                CHI TIẾT ĐƠN {{ $bill->id }}
            </p>
            <p>
                @php 
                    $date = date_create($bill->date)
                @endphp
                {{ date_format($date, 'd/m/Y') }}
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
                            <span style="color: red">Đợi thanh toán</span>
                        @elseif($bill->status == config('config.order.status.check-out'))
                            <span style="color: green">Hoàn thành</span>
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
        <table style="width: 100%">
            @if ($bill->status == config('config.order.status.check-out'))
                <tr>
                    <td style="width: 40%">Đã thanh toán</td>
                    <td style="width: 10%">:</td>
                    <td style="font-weight: bold; width: 50%">
                        {{ number_format($bill->total) }}<sup>đ</sup>
                        <input type="hidden" value="{{ $bill->customer->balance }}" id="balance" name="">
                    </td>
                </tr>
                <tr>
                    <td>
                        Đánh giá khách hàng
                    </td>
                    <td>
                        :
                    </td>
                    <td style="font-weight: bold;">
                        {{ $bill->rate->name }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Góp ý khách hàng
                    </td>
                    <td>
                        :
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
                        {{ number_format($service->price) }}<sup>d</sup>
                        <input type="hidden" id="hidden{{ $service->id }}" value="0" name="">
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="col-lg-12">
        @if ($bill->status != config('config.order.status.check-out'))
            <button style="float: right; margin-bottom: 20px; height: 50px" type="button" class="add-service btn btn-primary" data-toggle="modal" data-target="#myModal">
                THÊM DỊCH VỤ
            </button>
            <button style="float: left; margin-bottom: 20px; height: 50px; background: #FF9800; border: 0px" type="button" class="add-service btn btn-primary" data-toggle="modal" data-target="#service-other">
                THÊM DỊCH VỤ KHÁC
            </button>
        @endif
        <div class="modal fade" id="service-other">
            <div class="modal-dialog">
              <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title">DỊCH VỤ KHÁC</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <table>
                        <tr>
                            <td>
                                Tên dịch vụ
                            </td>
                            <td>
                                :
                            </td>
                            <td>
                                <input type="text" id="service-dif" placeholder="Nhập tên dịch vụ..." class="form-control" name="">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Chọn thợ chính
                            </td>
                            <td style="padding: 15px 15px">:</td>
                            <td>
                                @foreach ($employeeList as $employee)
                                    <input type="hidden" id="name-employee-other{{ $employee->id }}" value="{{ $employee->full_name }}" name="">
                                @endforeach
                                <select onchange="employeeForServiceOther()" id="employeeForServiceOther" class="option-employee form-control">
                                    <option value="0">Chọn thợ chính</option>
                                    @foreach ($employeeList as $employee)
                                        <option @if ($employee->id == $bill->order->employee_id) {{ 'selected' }} @endif value="{{ $employee->id }}">
                                            {{ $employee->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Chọn thợ phụ
                            </td>
                            <td style="padding: 15px 15px">:</td>
                            <td>
                                @foreach ($employeeList as $employee)
                                    <input type="hidden" id="name-assistant-other{{ $employee->id }}" value="{{ $employee->full_name }}" name="">
                                @endforeach
                                <select onchange="employeeAssistantForServiceOther()" id="employee-assistant-for-service-other" class="option-employee form-control">
                                    <option value="0">Chọn thợ phụ</option>
                                    @foreach ($employeeList as $employee)
                                        <option @if ($employee->id == $bill->order->employee_id) {{ 'selected' }} @endif value="{{ $employee->id }}">
                                            {{ $employee->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Giá dịch vụ
                            </td>
                            <td>
                                :
                            </td>
                            <td>
                                <input type="text" id="price-dif" id="formattedNumberField" placeholder="Điền giá dịch vụ..." class="form-control" name="">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Chiết khấu (%)
                            </td>
                            <td>:</td>
                            <td>
                                <input type="number" id="percent-dif" placeholder="chiết khấu phần trăm" name="" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="padding: 15px 15px"></td>
                            <td>
                                <button data-dismiss="modal" style="font-weight: normal; float: left; height: 50px; width: 50%; font-size: 23px; background: #007bff; color: #fff; opacity: 1;" id="add-other-service" class="close btn btn-primary">
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
                                var serviceDif = $('#service-dif').val();
                                var priceDif = $('#price-dif').val();
                                var percentDif = $('#percent-dif').val();
                                var employeeId = employeeForServiceOther();
                                var assistantId = employeeAssistantForServiceOther();
                                var nameEmployee = $('#name-employee-other' + employeeId).val();
                                var nameAssistant = $('#name-assistant-other' + assistantId).val();
                                if (serviceDif == '') {
                                    alert('Cần điền tên dịch vụ');
                                } else if (priceDif == '') {
                                    alert('Cần điền giá dịch vụ'); 
                                } else if (percentDif == '') {
                                    alert('Cần điền % chiết khấu'); 
                                } else if (employeeId == 0) {
                                    alert('Cần chọn thợ chính');
                                } else {
                                    var convertPrice = priceDif.replace(/[,]/g,'');
                                    $.get('admin/hoa-don/dich-vu-khac/them/' + bill_id + '/' + serviceDif + '/' + employeeId + '/' + assistantId + '/' + priceDif + '/' + percentDif, function(data){
                                        if (data != '') {
                                            if (assistantId == 0) {
                                                nameAssistant = '';
                                            }
                                            $('#list-service').append(data);
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
                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title">THÊM DỊCH VỤ</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <table>
                        <tr>
                            <td>
                                Dịch vụ
                            </td>
                            <td style="padding: 15px 15px">
                                :
                            </td>
                            <td>
                                @foreach ($serviceList as $service)
                                    <input data="{{ $service->price }}" type="hidden" id="name-service{{ $service->id }}" value="{{ $service->name }}" name="">
                                @endforeach
                                <select class="option-service form-control">
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
                            <td style="padding: 15px 15px">:</td>
                            <td>
                                @foreach ($employeeList as $employee)
                                    <input type="hidden" id="name-employee{{ $employee->id }}" value="{{ $employee->full_name }}" name="">
                                @endforeach
                                <select onchange="optionEmployee()" id="option-employee" class="option-employee form-control">
                                        <option value="0">Chọn thợ chính</option>
                                    @foreach ($employeeList as $employee)
                                        <option @if ($employee->id == $bill->order->employee_id) {{ 'selected' }} @endif value="{{ $employee->id }}">
                                            {{ $employee->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Chọn thợ phụ
                            </td>
                            <td style="padding: 15px 15px">:</td>
                            <td>
                                @foreach ($employeeList as $employee)
                                    <input type="hidden" id="name-assistant{{ $employee->id }}" value="{{ $employee->full_name }}" name="">
                                @endforeach
                                <select onchange="optionAssistant()" class="assistant form-control">
                                        <option value="0">Chọn thợ phụ</option>
                                    @foreach ($employeeList as $employee)
                                        <option @if ($employee->id == $bill->order->employee_id) {{ 'selected' }} @endif value="{{ $employee->id }}">
                                            {{ $employee->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
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
                                    var pricePrimary = $('#total-all').val();
                                    var serviceId = $('.option-service').val();
                                    var employeeId = optionEmployee();
                                    var assistantId = optionAssistant();
                                    var nameService = $('#name-service' + serviceId).val();
                                    var servicePrice = $('#name-service' + serviceId).attr("data");
                                    var nameEmployee = $('#name-employee' + employeeId).val();
                                    var nameAssistant = $('#name-assistant' + assistantId).val();
                                    var serviceDif = $('#service-dif').val();
                                    var bill_id = $('#bill_id').val();
                                    var priceDif = $('#price-dif').val();
                                    var percentDif = $('#percent-dif').val();

                                    if (serviceId != 0 && employeeId != 0) {
                                        var priceChange = parseInt(pricePrimary) + parseInt(servicePrice);
                                        $.get('admin/hoa-don/dich-vu/them/' + bill_id + '/' + serviceId + '/' + employeeId + '/' + assistantId + '/' + servicePrice, function(data){
                                            if (data != '') {
                                                if (assistantId == 0) {
                                                    nameAssistant = '';
                                                }
                                                $('#list-service').append(data);
                                            } else {
                                                alert('Hóa đơn đã được thanh toán, bạn không thể thêm dịch vụ.');
                                            }
                                        });
                                    } else {
                                        alert('Cần điền đầy đủ thông tin');
                                    }
                                })
                                
                                function xoa(id)
                                {
                                    // price = $('#price' + id).val();
                                    priceTotal = $('#total-all').val();
                                    // $('#total-all').val(parseInt(priceTotal) - parseInt(price));
                                    $.get('admin/hoa-don/xoa/dich-vu/' + id, function(data){
                                        $('#total-all').val(parseInt(priceTotal) - parseInt(data));
                                        if (data != '') {
                                            $('.total-service').html(addCommas(parseInt(priceTotal) - parseInt(data)));
                                            $('#row' + id).remove();
                                        } else {
                                            alert('Hóa đơn đã hoàn thành, bạn không được phép xóa.');
                                        }
                                        
                                    })
                                    
                                }
                            </script>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="padding: 15px 15px"></td>
                            <td>
                                <button data-dismiss="modal" style="font-weight: normal; float: left; height: 50px; width: 50%; font-size: 23px; background: #007bff; color: #fff; opacity: 1;" id="add-service" class="close btn btn-primary">
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
        <table id="list-service">
            <tr>
                <th>Dịch vụ</th>
                <th>Thợ chính</th>
                <th>Thợ phụ</th>
                <th>Giá</th>
            </tr>
            @foreach ($serviceListUse as $service)
                <tr>
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
                    <td style="text-align: right;">
                        {{ number_format($service->money) }}<sup>đ</sup>
                    </td>
                </tr>
            @endforeach
        </table>
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
                        <input type="text" placeholder="0" value="{{ $bill->sale }}" id="sale" class="form-control" name="">
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
                        <input type="text" value="{{ $bill->sale_detail }}" class="form-control" placeholder="Nội dùng giảm giá" id="sale_detail" name="">
                    </td>
                </tr>
            @endif

            <!-- @if ($bill->status != config('config.order.status.check-out'))
                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        <input style="background: #ccc; border: 1px solid #ccc;" class="add-sale btn btn-primary" value="Thêm quà tặng" name="">
                    </td>
                </tr>
            @endif -->
        </table>
    </div>
    <div class="col-lg-12" style="margin-top: 20px">
        <center>
            @if ($bill->status != config('config.order.status.check-out'))
                <!-- <h2 class="btn btn-primary pay" data-toggle="modal" data-target="#rate">Thanh toán</h2> -->
                <h2 style="width: 100%" data-toggle="modal" data-target="#rate" class="rate pay btn btn-primary">Thanh toán</h2>
                <script type="text/javascript">
                    $('.pay').click(function(){
                        billId = $('#bill_id').val();
                        sale_detail = $('#sale_detail').val();
                        sale = $('#sale').val();
                        $.get('danh-gia/noi-dung/' + billId);
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
            @endif
        </center>
        <div class="modal fade" id="rate">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Thanh toán dịch vụ</h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body" id="modal-body">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
