@extends('client.mobile.customers.layouts.index')

@section('content')
    <div class="row history">
        <div class="container" style="margin-top: 100px; padding: 0px;">
            <div class="col-12">
                <p>Thẻ hội viên</p>

                @if ($card == '')
                    <i>Bạn chưa làm thẻ hội viên</i>
                @else
                    <p>
                        <b>Loại thẻ:</b> {{ $card->card_name }}
                    </p>
                    <p>
                        <b>Giá trị:</b> {{ number_format($card->price) }} Đ
                    </p>
                    <p>
                        <b>Ngày đăng ký:</b> {{ date('d-m-Y', strtotime($card->start_time)) }}
                    </p>
                    <p>
                        <b>Ngày hết hạn:</b> {{ date('d-m-Y', strtotime($card->end_time)) }}
                    </p>
                    <p>
                        <b>Dịch vụ ưu đãi</b>: 
                        @foreach ($card->cardDetail as $service)
                            {{ $service->service->name }},
                        @endforeach
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection
