<tr id="row{{ $billDetail->id }}"> 
    <td>{{ $billDetail->service->name }}</td> 
    <td>{{ $billDetail->employee->full_name }}</td>
    <td>
        @if ($billDetail->assistant_id != '')
            {{ $billDetail->employeeAssistant->full_name }}
        @endif
    </td>
    <td style="text-align: right">
        {{ number_format($billDetail->sale_money) }}<sup>đ</sup>
    </td>
    <td>
        @if ($billDetail->sale_money < $billDetail->money)
            tặng <b>{{ number_format($billDetail->money - $billDetail->sale_money) }}<sup>đ</sup></b><br>
            <span style="color: red">({{ $cardName }})</span>
        @endif
    </td>
    <td>
        <i onclick="xoa({{ $billDetail->id }})" style="cursor: pointer; color: red" class="fas fa-times" id="close{{ $billDetail->id }}"></i>
    </td>
</tr>
