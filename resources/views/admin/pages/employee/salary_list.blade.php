@extends('admin.layouts.index')

@section('content')
    <div class="row" style="padding-left: 40px; padding-top: 40px">
        <div class="col-lg-12">
            <h2>
                Bảng lương - {{ $employee->full_name }}
            </h2><hr>
            <form method="post" action="{{ route('salary.list.post', ['id' => $employee->id]) }}">
                @csrf
                <table>
                    <tr>
                        <td>
                            <select name="month" class="form-control">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option @if ($i == $month) {{ 'selected' }} @endif value="@if ($i < 10) 0{{ $i }} @else {{ $i }} @endif">
                                        Tháng {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </td>
                        <td>
                            <select name="year" class="form-control">
                                @for ($i = 2019; $i <= date('Y'); $i++)
                                    <option @if ($i == $year) {{ 'selected' }} @endif value="{{ $i }}">
                                        Năm {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </td>
                        <td>
                            <input value="Xem lương" class="btn btn-primary" type="submit" name="">
                        </td>
                    </tr>
                </table>
            </form><br>
            <div class="col-lg-7" style="padding: 0px">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Dịch vụ</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Đánh giá</th>
                            <th scope="col">Chiết khấu (%)</th>
                            <th scope="col">Hoa hồng (vnd)</th>
                            <th scope="col">Ngày</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $stt = 0; $tong = 0; @endphp 
                        @foreach ($billDetail as $service)
                            @if ($service->bill->status == config('config.order.status.check-out'))
                                <tr>
                                    <th scope="row">{{ ++$stt }}</th>
                                    <td>
                                        @if ($service->service_id != '')
                                            @php 
                                                $percentService = $service->service->percent;
                                            @endphp
                                            {{ $service->service->name }}
                                        @else
                                            @php 
                                                $percentService = $service->other_service_percent;
                                            @endphp 
                                            {{ $service->other_service }}
                                        @endif
                                    </td>
                                    <td style="text-align: right; font-weight: bold;">
                                        {{ number_format($service->money) }}<sup>đ</sup>
                                    </td>
                                    <td>
                                        {{ $service->bill->rate_id }} - {{ $service->bill->rate->name }}
                                    </td>
                                    <td style="text-align: center;">
                                        @if ($service->bill->rate->type == config('config.rate.type.substract'))

                                            @php
                                                $percentRate = $service->bill->rate->percent;
                                                $percentTotal = $percentService + $service->employee->percent - $percentRate;
                                            @endphp
                                            {{ $percentTotal }}
                                        @else
                                            @php 
                                                $percentRate = $service->bill->rate->percent;
                                                $percentTotal = $percentService + $service->employee->percent + $percentRate;
                                            @endphp
                                            {{ $percentTotal }}
                                        @endif

                                        
                                    </td>
                                    <td style="text-align: right; font-weight: bold;">
                                        {{ number_format($percentTotal/100 * $service->money) }}<sup>đ</sup>
                                        @php 
                                            $tong = $tong + ($percentTotal/100 * $service->money);
                                        @endphp
                                    </td>
                                    <td>
                                        {{ date('d/m/Y', strtotime($service->date)) }}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                            <tr>
                                <td colspan="6" style="text-align: right; font-weight: bold; font-size: 20px; color: #007bff">
                                    Tổng: {{ number_format($tong) }}<sup>đ</sup>
                                </td>
                                <td></td>
                            </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
