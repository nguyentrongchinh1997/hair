@if ($customer->count())
    @foreach ($customer as $customer)
        @foreach ($customer->order as $o)
            <tr title="Click để xem chi tiết" style="cursor: pointer;"
                value="{{ $o->id }}" class="list-order" id="order{{ $o->id }}">
                <td>
                    {{ $o->id }}
                </td>
                <td>
                    <span style="font-weight: bold;">
                        {{ ($o->customer->full_name == '') ? 'chưa có tên' : $o->customer->full_name }}
                    </span><br>
                    {{ substr($o->customer->phone, 0, 4) }}.{{ substr($o->customer->phone, 4, 3) }}.{{ substr($o->customer->phone, 7) }}
                </td>
                <td>
                    {{ $o->time->time }}
                </td>
                <td>
                    @foreach ($o->orderDetail as $orderDetail)
                        @if ($orderDetail->employee_id != '')
                            <p>
                                <span style="font-weight: bold;">
                                    »
                                </span> {{ $orderDetail->service->name }} + {{ $orderDetail->employee->full_name }}
                            </p>
                        @else
                            <p>
                                <span style="font-weight: bold;">
                                    »
                                </span> {{ $orderDetail->service->name }} + <i>Chưa chọn</i>
                            </p>
                        @endif
                    @endforeach
                </td>
                <td>
                    @if ($o->status == config('config.order.status.create'))
                        <span style="color: red; font-weight: bold;">
                            Chưa check-in
                        </span>
                    @elseif ($o->status == config('config.order.status.check-in'))
                        <span style="color: green; font-weight: bold;">
                            Đã check-in
                        </span>
                    @else
                        <span style="color: #007bff; font-weight: bold;">
                            Hoàn thành
                        </span>
                    @endif
                </td>
                <td style="text-align: center; font-size: 18px">
                    @if ($o->status == config('config.order.status.create'))
                        <a onclick="return deleteOrder()" href="{{ route('order.cancel', ['id' => $o->id]) }}" style="color: red; ">
                            <i class="far fa-trash-alt"></i>
                        </a>
                    @endif
                    <script type="text/javascript">
                        function deleteOrder()
                        {
                            if (confirm('Có chắc chắn muốn xóa đơn này?')) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    </script>
                </td>
            </tr>
        @endforeach
    @endforeach
@else
    <tr>
        <td colspan="6">
            <center>
                <i>Không có lịch đặt nào của khách</i>
            </center>
        </td>
    </tr>
@endif
<script type="text/javascript">
    $(document).ready(function(){
        $('.list-order').click(function() {
            var orderId = $(this).attr('value');
            $('.list-order').removeClass('active');
            $(this).addClass('active');
            $.get('admin/dat-lich/chi-tiet/' + orderId, function(data){
              $('#right').html(data);
            });
        });
    })
</script>
