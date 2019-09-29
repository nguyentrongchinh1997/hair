@foreach ($orderList as $order)
    @foreach ($order->order as $o)
        <tr style="cursor: pointer;
            value="{{ $o->id }}" class="list-order" id="order{{ $o->id }}">
            <td>
                {{ $o->id }}
            </td>
            
            <td>
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
                    Chưa check-in
                @elseif ($o->status == config('config.order.status.check-in'))
                    Đã check-in
                @else
                    Hoàn thành
                @endif
            </td>
        </tr>
    @endforeach
@endforeach
<script type="text/javascript">
    $(document).ready(function(){
        $('.list-order').click(function() {
            $('.list-order').removeClass('active');
            $(this).addClass('active');
            var orderId = $(this).attr('value');
            $.get('admin/dat-lich/chi-tiet/' + orderId, function(data){
              $('#right').html(data);
            });
        });
    })
</script>
