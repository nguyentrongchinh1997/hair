
    <div style="margin: auto; max-width: 500px">
        <!-- <h2 style="text-align: center;">HÓA ĐƠN</h2> -->
        <form method="post" action="{{ route('finish', ['id' => $billId]) }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" id="bill-id" value="{{ $billId }}">
            @if ($bill->sale_detail != '')
                <div class="row">
                    <table style="width: 100%">
                        <tr>
                            <td style="width: 40%">
                                Nội dung Sale
                            </td>
                            <td style="width: 10%">:</td>
                            <td style="width: 50%">
                                {{ $bill  ->sale_detail }}
                            </td>
                        </tr>
                    </table>
                </div>
            @endif
            <table style="width: 100%" class="update-rate">
                <tr>
                    <td style="width: 40%">
                        Đánh giá
                    </td>
                    <td style="width: 10%">:</td>
                    <td class="rate-customer" style="font-weight: bold; width: 50%">
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
                        @if ($bill->rate_id != '')
                            <span>{{ $bill->comment }}</span>
                        @else
                            <i>Khách chưa góp ý</i>
                        @endif
                    </td>
                </tr>

            </table><br>
            <table class="list-table">
                <tr style="background: #BBDEFB">
                    <th>Dịch vụ</th>
                    <th>Thợ</th>
                    <th>Giá</th>
                    <th>Ghi chú</th>
                    <th>Thẻ hội viên</th>
                </tr>
                @php $totalPrice = 0 @endphp
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
                            {{ number_format($service->sale_money) }}<sup>đ</sup>
                        </td>
                        <td></td>
                        <td>
                            @if ($service->sale_money < $service->money)
                                <span>{{ $cardName }}</span><br>
                                <span style="color: red">
                                     (đã tặng <b>{{ number_format($service->money - $service->sale_money) }}<sup>đ</sup></b>)
                                </span>
                            @endif
                        </td>
                    </tr>
                    @php $totalPrice = $totalPrice + $service->sale_money @endphp
                @endforeach
                @if ($bill->sale != 0)
                    <tr>
                        <td colspan="3" style="text-align: right;">
                            {{ number_format($bill->sale) }}<sup>đ</sup>
                        </td>
                        <td style="font-weight: bold;">Quà tặng</td>
                        <td rowspan="3"></td>
                    </tr>
                @endif
                @if ($bill->status != config('config.order.status.check-out'))
                    <tr>
                        <td colspan="3" style="text-align: right;">
                            {{ number_format($bill->customer->balance) }}<sup>đ</sup>
                        </td>
                        <td style="font-weight: bold;">Số dư</td>
                        @if ($bill->sale == 0)
                            <td rowspan="2"></td>
                        @endif
                        
                    </tr>
                    <tr>
                        @php 
                            $balance = $bill->customer->balance;
                            $total = $totalPrice - $bill->sale;
                        @endphp
                        @if ($balance >= $total)
                            <td style="text-align: right; font-size: 25px; color: #007bff; font-weight: bold;" colspan="3">0 <sup>đ</sup></td>
                        @else
                            <td style="text-align: right; font-size: 25px; color: #007bff; font-weight: bold;" colspan="3">
                                {{ number_format($total - $balance) }}<sup>đ</sup>
                            </td>
                        @endif
                        <td style="font-weight: bold;">
                            Cần thanh toán
                        </td>
                        
                    </tr>
                @endif
            </table>
            <br>
            @if ($bill->status != config('config.order.status.check-out'))
                <center>
                    <button class="btn btn-primary button-control">
                        Kết thúc
                    </button>
                    <!-- <input type="submit" value="Kết thúc" class="btn btn-primary " name=""> -->
                    
                    <a id="update-rate" style="background: #727272; border: 0px; cursor: pointer; color: #fff" class="btn btn-primary button-control">
                        Cập nhật đánh giá
                    </a>
                    <script type="text/javascript">
                        $(function(){
                            $('#update-rate').click(function(){
                                billId = $('#bill-id').val();
                                $.get('admin/hoa-don/danh-gia/' + billId, function(data){
                                    $('.update-rate').html(data);
                                })
                            })
                        })
                    </script>
                </center>
            @endif
        </form>
    </div>
