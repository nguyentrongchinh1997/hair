@if ($customer->count() == 0)
    <tr>
        <td colspan="11" style="text-align: center; font-size: 20px">
            <i>Không có kết quả</i>
        </td>
    </tr>
@else
    <tr style="background: #fcf8e3; font-weight: bold;">
        <td style="text-align: right;" class="tong" colspan="10">
            
        </td>
        <td>
            
        </td>
    </tr>
    @php $stt = 0; $tong = 0; @endphp
    @foreach ($customer as $customer)
        @foreach ($customer->membership as $member)
            <tr>
                <td>{{ ++$stt }}</td>
                <td>{{ $member->customer->full_name }}</td>
                <td>
                    {{ $member->customer->phone }}
                </td>
                <td>
                    {{ $member->card->card_name }}
                </td>
                <td>
                    @foreach ($member->card->cardDetail as $service)
                        @if ($service->percent == '')
                            {{ $service->service->name }}<span style="color: red">(free {{ $service->number }} lần)</span>
                        @else
                            {{ $service->service->name }} <span style="color: red">(Giảm {{ $service->percent }}%)</span><br>
                        @endif
                    @endforeach
                </td>
                <td>
                    {{ date('d/m/Y', strtotime($member->created_at)) }}
                </td>
                <td>
                    @if ($member->start_time != '')
                      {{ date('d/m/Y', strtotime($member->start_time)) }}
                    @endif
                </td>
                <td>
                    @if ($member->end_time != '')
                      {{ date('d/m/Y', strtotime($member->end_time)) }}
                    @endif
                </td>

                <td>
                    @if ($member->number == '')
                        @if (strtotime(date('Y-m-d')) <= strtotime($member->end_time))
                            <span style="color: #007bff; font-weight: bold;">Còn hạn</span>
                        @else
                            <span style="color: red; font-weight: bold;">Hết hạn</span>
                            
                        @endif
                    @else
                        <span style="color: #007bff; font-weight: bold;">
                            Còn {{ $member->number }} lần
                        </span>
                    @endif
                </td>
                <td style="text-align: right;">
                    {{ number_format($member->card->price) }}<sup>đ</sup>
                </td>
                <td style="text-align: center;">
                    <a onclick="return deleteMembership()" style="color: red" href="{{ route('membership.delete', ['id' => $member->id]) }}">
                        <i class="fas fa-times"></i>
                    </a>
                </td>
            </tr>
            @php $tong = $tong +  $member->card->price; @endphp
        @endforeach
    @endforeach
    <tr style="display: none;">
        <td id="tong" style="text-align: right;" colspan="10">
            <span style="font-size: 18px; font-weight: bold;">
                {{ number_format($tong) }}<sup>đ</sup>
            </span>
        </td>
        <td>
            
        </td>
    </tr>
@endif
<script type="text/javascript">
    $('.tong').html($('#tong').html());
</script>