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
    $('.add-sale').click(function(){
        bill_id = $('#bill_id').val();
        sale_detail = $('#sale_detail').val();
        sale = $('#sale').val();
        if (sale_detail == '') {
            alert('Cần điền nội dung quà tặng');
        } else if (sale == '') {
            alert('Cần điền số tiền muốn tặng');
        } else {
            $.get('admin/hoa-don/giam-gia/cap-nhat/' + bill_id + '?sale=' + sale + '&saleDetail=' + sale_detail , function(data){
                if (data == '') {
                    alert('Hóa đơn được hoàn thành. Bạn không được thêm quà tặng.')
                } else {
                    alert('Cập nhập thành công');
                }
            });
        }
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
            <button style="float: right; margin-bottom: 20px" type="button" class="add-service btn btn-primary" data-toggle="modal" data-target="#myModal">Thêm dịch vụ</button>
        @endif
        <div class="modal fade" id="myModal">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                      <h4 class="modal-title">Thêm dịch vụ</h4>
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
                                    Chọn nhân viên
                                </td>
                                <td style="padding: 15px 15px">:</td>
                                <td>
                                    @foreach ($employeeList as $employee)
                                        <input type="hidden" id="name-employee{{ $employee->id }}" value="{{ $employee->full_name }}" name="">
                                    @endforeach
                                    <select class="option-employee form-control">
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
                                        var employeeId = $('.option-employee').val();
                                        var nameService = $('#name-service' + serviceId).val();
                                        var servicePrice = $('#name-service' + serviceId).attr("data");
                                        var nameEmployee = $('#name-employee' + employeeId).val();
                                        var serviceDif = $('#service-dif').val();
                                        var bill_id = $('#bill_id').val();
                                        var priceDif = $('#price-dif').val();
                                        var percentDif = $('#percent-dif').val();
                                        if (serviceId != 0 && serviceDif != '' && priceDif != '') {
                                            priceTotal = parseInt(pricePrimary) + parseInt(servicePrice) + parseInt(priceDif.replace(/[,]/g,''));
                                        } else if (serviceId != 0 && serviceDif == '' && priceDif == '') {
                                            priceTotal = parseInt(pricePrimary) + parseInt(servicePrice);
                                        } else if (serviceId == 0 && serviceDif != '' && priceDif != '') {
                                            priceTotal = parseInt(pricePrimary) + parseInt(priceDif.replace(/[,]/g,''));
                                        }
                                        if (serviceId != 0) {
                                            var priceChange = parseInt(pricePrimary) + parseInt(servicePrice);
                                            $.get('admin/hoa-don/dich-vu/them/' + bill_id + '/' + serviceId + '/' + employeeId + '/' + servicePrice, function(data){
                                                if (data != '') {
                                                    $('#total-all').val(priceTotal);
                                                    $('.total-service').html(addCommas(priceTotal));
                                                    $('#list-service').append('<tr id="row' + data +'">' + '<td>'+ nameService + '</td>' + '<td>'+ nameEmployee + '</td>' + '<td style="text-align: right"><input type="hidden" value="'+ servicePrice +'" id="price'+ data +'">'+ addCommas(servicePrice) + '<sup>đ</sup></td>' + '<td><i onclick="xoa('+ data +')" style="cursor: pointer; color: red" class="fas fa-times" id="close'+ data +'"></i>' + '</td>' + '</tr>');
                                                } else {
                                                    alert('Hóa đơn đã được thanh toán, bạn không thể thêm dịch vụ.');
                                                }
                                            });
                                        }
                                        if (serviceDif != '' && priceDif != '' && percentDif != '') {
                                            var convertPrice = priceDif.replace(/[,]/g,'');
                                            $.get('admin/hoa-don/dich-vu-khac/them/' + bill_id + '/' + serviceDif + '/' + employeeId + '/' + priceDif + '/' + percentDif, function(data){
                                                if (data != '') {
                                                    $('#total-all').val(priceTotal);
                                                    $('.total-service').html(addCommas(priceTotal));
                                                    $('#list-service').append('<tr id="row' + data +'">' + '<td>'+ serviceDif + '</td>' + '<td>'+ nameEmployee + '</td>' + '<td style="text-align: right"><input type="hidden" value="'+ convertPrice +'" id="price'+ data +'">'+ priceDif + '<sup>đ</sup></td>' + '<td><i onclick="xoa('+ data +')" style="cursor: pointer; color: red" class="fas fa-times" id="close'+ data +'"></i>' + '</td>' + '</tr>');
                                                } else {
                                                    alert('Hóa đơn đã được thanh toán, bạn không thể thêm dịch vụ.');
                                                }

                                            });
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
                                <td>
                                    Dịch vụ khác
                                </td>
                                <td>:</td>
                                <td>
                                    <input type="text" id="service-dif" placeholder="Tên dịch vụ" class="form-control" name=""><br>
                                    <input type="text" id="price-dif" id="formattedNumberField" placeholder="giá dịch vụ" class="form-control" name=""><br>
                                    <input type="number" id="percent-dif" placeholder="chiết khấu phần trăm" name="" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td style="padding: 15px 15px"></td>
                                <td>
                                    <button id="add-service" class="btn btn-primary">
                                        Thêm
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
                <th>Thợ</th>
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

            @if ($bill->status != config('config.order.status.check-out'))
                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        <input style="background: #ccc; border: 1px solid #ccc;" class="add-sale btn btn-primary" value="Thêm quà tặng" name="">
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
                    <script type="text/javascript">
                        $('.pay').click(function(){
                            billId = $('#bill_id').val();
                            $.get('danh-gia/noi-dung/' + billId);
                            $.get('admin/hoa-don/cap-nhat/thu-ngan/' + billId);
                            $.get("admin/hoa-don/thanh-toan/" + billId, function(data){
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
                        <!-- <input type="hidden" value="{{ $bill->status}}" id="trang-thai" name="">
                        <form method="post" action="{{ route('finish', ['id' => $bill->id]) }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <table style="width: 100%">
                                <tr>
                                    <td>
                                        Đánh giá
                                    </td>
                                    <td>:</td>
                                    <td class="rate-customer" style="font-weight: bold;">
                                        @if ($bill->rate_id != '')
                                            <span>{{ $bill->rate->name }}</span>
                                        @else
                                            <i>Khách chưa đánh giá</i>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Góp ý của khách
                                    </td>
                                    <td>:</td>
                                    <td class="comment-customer" style="font-weight: bold;">
                                        @if ($bill->comment != '')
                                            <span>{{ $bill->comment }}</span>
                                        @else
                                            <i>Khách chưa góp ý</i>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Cần thanh toán</td>
                                    <td>:</td>
                                    <td>
                                        {{ number_format($payPrice) }}<sup>đ</sup>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <input type="submit" value="Kết thúc" class="btn btn-primary" name="">
                                        <a style="background: #727272; border: 0px; cursor: pointer; color: #fff" class="btn btn-primary">
                                            Cập nhật
                                        </a>
                                        
                                    </td>
                                    <td>
                                        
                                    </td>
                                </tr>
                            </table>
                        </form> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
