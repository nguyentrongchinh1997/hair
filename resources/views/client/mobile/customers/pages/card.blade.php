@extends('client.mobile.customers.layouts.index')

@section('content')
    <div class="row history">
        <div class="container" style="margin-top: 100px; padding: 0px; margin-bottom: 100px !important">
            <div class="col-12">
                <p style="font-weight: bold;">Danh sách thẻ của bạn</p>
                @if ($membership->count() == 0)
                    <i>Bạn chưa làm thẻ hội viên</i>
                @else
                    @foreach ($membership as $card)
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
                            @if ($card->card->type == 0)
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
                                            {{ $service->service->name }}(<span style="color: red">-{{$service->percent}}%</span>),
                                        @endforeach
                                    </td>
                                </tr>

                            @else
                                <tr>
                                    <td>Ngày mua</td>
                                    <td>
                                        {{ date('d/m/Y', strtotime($card->created_at)) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Số lần còn lại</td>
                                    <td>
                                        {{ $card->number }}
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <td>Trạng thái</td>
                                <td>
                                    @if ($card->status == 0)
                                        <span style="color: red; font-weight: bold;">Hết hạn</span>
                                    @else
                                        <span style="color: #007bff; font-weight: bold;">Còn Hạn</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
