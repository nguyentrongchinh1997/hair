<tr id="row{{ $orderDetail->id }}">
    <td>
        {{ $orderDetail->service->name }}
    </td>
    <td>
        {{ $orderDetail->employee->full_name }}
    </td>
    <td>
        @if ($orderDetail->assistant_id != '')
            {{ $orderDetail->assistant->full_name }}
        @endif
    </td>
    <td style="text-align: right;">
        {{ number_format($orderDetail->service->price) }}<sup>đ</sup>
    </td>
    
    <td style="text-align: center; color: red">
        <a style="color: red" onclick="return deleteService({{ $orderDetail->id }})">
            <i style="cursor: pointer;" class="fas fa-times"></i>
        </a>
    </td>
</tr>
