<tr id="row{{ $data->id }}"> 
    <td>{{ $data->service->name }}</td> 
    <td>{{ $data->employee->full_name }}</td>
    <td>
        @if ($data->assistant_id != '')
            {{ $data->employeeAssistant->full_name }}
        @endif
    </td>
    <td style="text-align: right">
        {{ number_format($data->money) }}<sup>đ</sup>
    </td>
    <td>
        <i onclick="xoa({{ $data->id }})" style="cursor: pointer; color: red" class="fas fa-times" id="close{{ $data->id }}"></i>
    </td>
</tr>
