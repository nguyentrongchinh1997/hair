<h2 style="text-align: center;">
    CHI TIẾT
    <input type="hidden" id="bill_id" value="{{ $bill->id }}" class="id-order" name="">
    <input type="hidden" id="employee_id" value="{{ $bill->order->employee_id }}" class="customer-id">
    <input type="hidden" id="price_total" value="{{ $moneyServiceTotal }}" name="">
</h2>
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

    $('.add-sale').click(function(){
        bill_id = $('#bill_id').val();
        sale_detail = $('#sale_detail').val();
        sale = $('#sale').val();
        if (sale_detail == '') {
            alert('Cần điền nội dung giảm giá');
        } else if (sale == '') {
            alert('Cần điền số tiền cần giảm');
        } else {
            $.get('admin/hoa-don/giam-gia/cap-nhat/' + sale + '/' + sale_detail + '/' + bill_id);
            alert('Cập nhập thành công');
        }
    })
</script>
<div class="row">
    <div class="col-lg-12">
    <table style="width: 100%">
        <tr>
            <td style="width: 30%">
                Tên khách hàng
            </td>
            <td style="width: 2%">
                :
            </td>
            <td style="font-weight: bold;">
                {{ $bill->customer->full_name }}
            </td>
        </tr>
        <tr>
            <td>Số dư</td>
            <td>:</td>
            <td style="font-weight: bold;">
                {{ number_format($bill->customer->balance) }}<sup>đ</sup>
                <input type="hidden" value="{{ $bill->customer->balance }}" id="balance" name="">
            </td>
        </tr>
        @if ($bill->status == config('config.order.status.check-out'))
            <tr>
                <td>Đã thanh toán</td>
                <td>:</td>
                <td style="font-weight: bold;">
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
        @if ($bill->status == config('config.order.status.check-out'))
            <tr>
                <td>Giảm giá (vnd)</td>
                <td>:</td>
                <td style="font-weight: bold;">
                    {{ number_format($bill->sale) }}<sup>đ</sup>
                </td>
            </tr>
        @else
            <tr>
                <td>
                    Giảm giá (vnd)
                </td>
                <td>:</td>
                <td>
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
                    <input class="add-sale btn btn-primary" value="Thêm Sale" name="">
                </td>
            </tr>
        @endif
    </table>
</div>
<div class="col-lg-12">
    @if ($bill->status != config('config.order.status.check-out'))
        <button style="float: right;" type="button" class="add-service btn btn-primary" data-toggle="modal" data-target="#myModal">Thêm dịch vụ</button>
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
                                            $('#total-all').val(priceTotal);
                                            $('.total-service').html(addCommas(priceTotal));
                                            $('#list-service').append('<tr id="row' + data +'">' + '<td>'+ nameService + '</td>' + '<td>'+ nameEmployee + '</td>' + '<td style="text-align: right"><input type="hidden" value="'+ servicePrice +'" id="price'+ data +'">'+ addCommas(servicePrice) + '<sup>đ</sup></td>' + '<td><i onclick="xoa('+ data +')" style="cursor: pointer; color: red" class="fas fa-times" id="close'+ data +'"></i>' + '</td>' + '</tr>');
                                        });
                                    }
                                    if (serviceDif != '' && priceDif != '' && percentDif != '') {
                                        var convertPrice = priceDif.replace(/[,]/g,'');
                                        $.get('admin/hoa-don/dich-vu-khac/them/' + bill_id + '/' + serviceDif + '/' + employeeId + '/' + priceDif + '/' + percentDif, function(data){
                                            $('#total-all').val(priceTotal);
                                            $('.total-service').html(addCommas(priceTotal));
                                            $('#list-service').append('<tr id="row' + data +'">' + '<td>'+ serviceDif + '</td>' + '<td>'+ nameEmployee + '</td>' + '<td style="text-align: right"><input type="hidden" value="'+ convertPrice +'" id="price'+ data +'">'+ priceDif + '<sup>đ</sup></td>' + '<td><i onclick="xoa('+ data +')" style="cursor: pointer" class="fas fa-times" id="close'+ data +'"></i>' + '</td>' + '</tr>');
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
                                        $('.total-service').html(addCommas(parseInt(priceTotal) - parseInt(data)));
                                        $('#row' + id).remove();
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
<!--                             <td>
                                <input type="text" id="price-dif" id="formattedNumberField" placeholder="giá" class="form-control" name="">
                            </td> -->
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
                <!-- Modal footer -->
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
    <table class="tong-gia">
        <tr>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td  style="font-size: 20px; display: none;">
                <b style="padding-right: 20px">Tổng:</b>
                <span class="total-service">
                    
                </span><sup>đ</sup>
                <script type="text/javascript">
                    $('.total-service').html(addCommas($('#total-all').val()));
                </script>
            </td>
        </tr>
    </table>
</div>
<div class="row" style="display: none;">
    <table>
        <tr>
            <td>Tong</td>
            <td>:</td>
            <td>
                <input type="text" id="total" value="{{ $moneyServiceTotal }}" name="">
                <span id="tong-test"></span>
            </td>
        </tr>
    </table>
</div>
<div class="col-lg-12" style="margin-top: 20px">
    <center>
        <center>
            <script type="text/javascript">
                $('.rate').click(function(){
                    billId = $('.rate').attr('data');
                    $.get('danh-gia/noi-dung/' + billId);
                    alert('Đợi khách đánh giá');
                })
            </script>
            @if ($bill->status != config('config.order.status.check-out'))
                <h2 class="btn btn-primary" data-toggle="modal" data-target="#rate">Thanh toán</h2>
            @endif
        </center>

    </center>
    <div class="modal fade" id="rate">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title">Thanh toán dịch vụ</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body">
                    <input type="hidden" value="{{ $bill->status}}" id="trang-thai" name="">
                    <form method="post" action="{{ route('bill.pay', ['id' => $bill->id]) }}">
                        </style>
                        <table>
                            <tr>
                                <td style="width: 30%">
                                    @if ($bill->status == config('config.order.status.check-out'))
                                        <span>Đã thanh toán</span>
                                    @else
                                        <span>Cần thành toán</span>
                                    @endif
                                </td>
                                <td style="width: 10%">:</td>
                                <td id="tong-gia" style="width: 60%; color: #007bff; font-size: 30px; font-weight: bold;">
                                    @if ($bill->status == config('config.order.status.check-out'))
                                        {{ number_format($moneyServiceTotal - $bill->sale) }}<sup>đ</sup>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Đánh giá của khách
                                </td>
                                <td style="padding: 0px 10px">:</td>
                                <td class="rate-customer" style="font-weight: bold;">

                                    <script>
                                        billID = $('#bill_id').val();
                                        trang_thai = $('#trang-thai').val();

                                        if (trang_thai != 2) {
                                            var rate_customer = setInterval(function (){
                                            $('.rate-customer').load("admin/hoa-don/khach-hang/danh-gia/" + billID).fadeIn("slow");
                                            }, 1000);
                                            var comment_customer = setInterval(function (){
                                            $('.comment-customer').load("admin/hoa-don/khach-hang/binh-luan/" + billID).fadeIn("slow");
                                            }, 1000);
                                            var tong_gia = setInterval(function (){
                                            $('#tong-gia').load("admin/hoa-don/tong-gia/" + billID).fadeIn("slow");
                                            }, 1000);
                                        }
                                    </script>
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
                                <td style="padding: 0px 10px">:</td>
                                <td class="comment-customer" style="font-weight: bold;">
                                    @if ($bill->rate_id != '')
                                        <span>{{ $bill->comment }}</span>
                                    @else
                                        <i>Khách chưa góp ý</i>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>
                                    <form method="post" action="{{ route('bill.pay', ['id' => $bill->id]) }}">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" id="total-all" value="{{ $moneyServiceTotal }}" name="price_service">
                                        <input type="submit" value="Kết thúc" class="btn btn-primary" name="">
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>
                                    
                                    <a style="color: #fff" data="{{ $bill->id }}" class="rate btn btn-primary">Cho khách đánh giá</a>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="tong" class="row">
    
</div>
