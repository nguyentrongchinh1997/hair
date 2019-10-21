@if ($customer->count() == 0)
    <tr>
        <td colspan="9" style="text-align: center; font-size: 20px">
            <i>Không có kết quả</i>
        </td>
    </tr>
@else
    @php $stt = 0; @endphp
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
                        <span>
                            Còn {{ $member->number }} lần
                        </span>
                    @endif
                </td>
                <td style="text-align: center;">
                    <a onclick="return deleteMembership()" style="color: red" href="{{ route('membership.delete', ['id' => $member->id]) }}">
                        <i class="fas fa-times"></i>
                    </a>
                    <!-- <button type="button" onclick="extension({{ $member->id }})" class="btn btn-primary button-control" data-toggle="modal" data-target="#cart-extension">Gia hạn</button>
                    <div class="modal fade" id="cart-extension">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title">Gia hạn thẻ</h3>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body extension">
                                    
                                </div>
                            </div>
                        </div>
                    </div> -->
                </td>
            </tr>
        @endforeach
    @endforeach
@endif