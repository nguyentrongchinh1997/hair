<tr id="row{{ $data->id }}"> 
    <td>{{ $data->other_service }}</td> 
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
        
    </td>
    <td>
        <i onclick="xoa({{ $data->id }})" style="cursor: pointer; color: red" class="fas fa-times" id="close{{ $data->id }}"></i>
    </td>
</tr>
