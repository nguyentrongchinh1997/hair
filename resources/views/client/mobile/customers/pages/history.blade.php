@extends('client.mobile.customers.layouts.index')

@section('content')
    <div class="row history">
        <div class="container" style="margin-top: 100px; padding: 0px; margin-bottom: 100px !important">
            <div class="col-12">
                <p style="font-weight: bold;">Lịch sử tại SALON</p>
                    @foreach ($historyList as $history)
                        <table>
                            <tr>
                                <td>
                                    Ngày
                                </td>
                                <td>
                                    {{ date('d/m/Y', strtotime($history->order->date)) }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Thời gian
                                </td>
                                <td>
                                    {{ $history->order->time->time }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Đánh giá
                                </td>
                                <td>
                                    @for ($i = 1; $i <= 3; $i++)
                                        @if ($i <= $history->rate_id)
                                            <img src="{{ asset('/image/star.png') }}" style="width: 16px; margin-top: -5px">
                                        @else
                                            <img src="{{ asset('/image/star-rate.png') }}" style="width: 16px; margin-top: -5px">
                                        @endif
                                    @endfor
                                </td>
                            </tr>
                            <tr>
                                <td>Dịch vụ</td>
                                <td>
                                    @foreach ($history->billDetail as $service)
                                        @if ($service->service_id != '')
                                            {{ $service->service->name }},
                                        @else
                                            {{ $service->other_service }},
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                        </table>
                        <!-- <li>
                            <p>
                                <b>Ngày:</b> {{ date('d-m-Y', strtotime($history->order->date)) }}
                            </p>
                            <p>
                                <b>Thời gian:</b> {{ $history->order->time->time }}
                            </p>
                            <p>
                                <b>Đánh giá:</b> 
                                @for ($i = 1; $i <= 3; $i++)
                                    @if ($i <= $history->rate_id)
                                        <img src="{{ asset('/image/star.png') }}" style="width: 16px; margin-top: -5px">
                                    @else
                                        <img src="{{ asset('/image/star-rate.png') }}" style="width: 16px; margin-top: -5px">
                                    @endif
                                @endfor
                            </p>
                            <p>
                                <b>Dịch vụ: </b>
                                @foreach ($history->billDetail as $service)
                                    @if ($service->service_id != '')
                                        {{ $service->service->name }},
                                    @else
                                        {{ $service->other_service }},
                                    @endif
                                @endforeach
                            </p>
                        </li> -->
                    @endforeach
            </div>
        </div>
    </div>
@endsection