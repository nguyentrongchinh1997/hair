
    @php $stt = 0; @endphp
    @foreach ($orderList as $order)
        @foreach ($order->order as $o)
            <tr>
                <td>
                    {{ ++$stt }}
                </td>
                <td>
                    {{ 
                        ($o->customer->full_name == '') ? 'Chưa điền thông tin' : $o->customer->full_name 
                    }}
                </td>
                <td>
                    {{ $o->customer->phone }}
                </td>
                <td>
                    {{ $o->employee->full_name }}
                </td>
                <td>
                    {{ $o->service->name }}
                </td>
                <td style="font-weight: bold; color: #007bff">
                    {{ number_format($o->service->price) }}<sup>đ</sup>
                </td>
                <td>
                    {{ $o->time->time }}
                </td>
                <td>
                    @php $date = date_create($o->created_at) @endphp
                    {{
                        date_format($date, 'H:i:s d/m/Y')
                    }}
                </td>
                <td>
                    @if ($o->status == config('order.status.create'))
                        <i style="color: red">Chưa check-in</i>
                    @elseif ($o->status == config('order.status.check-in'))
                        <i style="color: green">Đã check-in</i>
                    @else
                        <i style="color: #007bff">
                            Hoàn tất
                        </i>
                    @endif
                </td>
                <td>
                    @if ($o->status == config('order.status.create'))
                        <a href="">Check-in</a>
                    @elseif ($o->status == config('order.status.check-in'))
                        <a href="">Thanh toán</a>
                    @endif
                </td>
            </tr>
        @endforeach
    @endforeach
 
