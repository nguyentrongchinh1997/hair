<tr id="row{{ $billDetail->id }}"> 
    <td>{{ $billDetail->service->name }}</td> 
    <td>{{ $billDetail->employee->full_name }}</td>
    <td>
        @if ($billDetail->assistant_id != '')
            {{ $billDetail->employeeAssistant->full_name }}
        @endif
    </td>
    <td id="price{{ $billDetail->id }}" style="text-align: right">
        {{ number_format($billDetail->sale_money) }}<sup>đ</sup>
    </td>

    <td>
        <select onchange="service({{ $billDetail->id }})" id="card{{$billDetail->id}}" class="form-control input-control">
            <option value="0">
                Chọn thẻ
            </option>
            @foreach ($billDetail->bill->customer->membership as $card)
                @if ($card->status == 1 && (App\Helper\ClassHelper::checkEmptyServiceInCard($billDetail->service->id, $card->card->id)) > 0)
                    <option @if ($card->card->id == $billDetail->card_id) {{ 'selected' }} @endif value="{{ $card->card->id }}">
                        {{ $card->card->card_name }}
                    </option>
                @endif
            @endforeach
        </select>
    </td>

    <td style="text-align: center;">
        <i onclick="xoa({{ $billDetail->id }})" style="cursor: pointer; color: red" class="fas fa-times" id="close{{ $billDetail->id }}"></i>
    </td>
</tr>
