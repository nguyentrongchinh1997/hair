@extends('client.mobile.customers.layouts.index')

@section('content')
    <div class="row history">
        <div class="container" style="margin-top: 100px; padding: 0px; margin-bottom: 100px !important">
            <div class="col-12">
                <p style="font-weight: bold;">Thẻ hội viên</p>
                @if ($card == '')
                    <i>Bạn chưa làm thẻ hội viên</i>
                @else
                    <table class="card-membership">
                        <tr>
                            <td>
                                Loại thẻ
                            </td>
                            <td>
                                {{ $card->card->card_name }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Giá trị
                            </td>
                            <td>
                                {{ number_format($card->card->price) }}<sup>đ</sup>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Ngày đăng ký
                            </td>
                            <td>
                                {{ date('d/m/Y', strtotime($card->start_time)) }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Ngày hết hạn
                            </td>
                            <td>
                                {{ date('d/m/Y', strtotime($card->end_time)) }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Dịch vụ ưu đãi
                            </td>
                            <td>
                                @foreach ($card->card->cardDetail as $service)
                                    {{ $service->service->name }},
                                @endforeach
                            </td>
                        </tr>
                    </table>
                    <!-- <p>
                        <b>Loại thẻ:</b> 
                    </p>
                    <p>
                        <b>Giá trị:</b> 
                    </p>
                    <p>
                        <b>Ngày đăng ký:</b> {{ date('d-m-Y', strtotime($card->start_time)) }}
                    </p>
                    <p>
                        <b>Ngày hết hạn:</b> 
                    </p>
                    <p>
                        <b>Dịch vụ ưu đãi</b>: 
                        @foreach ($card->card->cardDetail as $service)
                            {{ $service->service->name }},
                        @endforeach
                    </p> -->
                @endif
            </div>
        </div>
    </div>
@endsection
