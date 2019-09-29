@extends('admin.layouts.index')
<style type="text/css">
    .btn-light{
        border: 1px solid #ced4da !important;
        outline: none;
    }
    table tr td {
        padding: 10px;
    }
</style>
@section('content')
    <div class="row" style="padding-left: 40px; margin-top: 40px">
        <div class="col-lg-12">
            @if (session('thongbao'))
                <div class="alert alert-success">
                    {{ session('thongbao') }}
                </div>
            @endif
        </div>
        
        <div class="col-lg-8">
            <button style="float: right; margin-bottom: 20px" type="button" class="btn btn-primary button-control" data-toggle="modal" data-target="#cart">Thêm thẻ</button>
            <table class="list-table" style="margin-top: 20px">
                <thead>
                    <tr style="background: #BBDEFB">
                        <th scope="col">STT</th>
                        <th scope="col">Tên thẻ</th>
                        <th scope="col">Dịch vụ áp dụng</th>
                    </tr>
                </thead>
                <tbody class="order-list">
                    @php $stt = 0; @endphp
                    @foreach ($cardList as $card)
                        <tr>
                            <td style="width: 5%">{{ ++$stt }}</td>
                            <td>
                                {{ $card->card_name }}
                            </td>
                            <td>
                                @foreach ($card->cardDetail as $service)
                                    {{ $service->service->name }}<span style="color: red">
                                        (giảm {{ $service->percent }}%)
                                    </span><br>
                                @endforeach
                            </td>
                            <!-- <td style="text-align: center;">
                                <button type="button" onclick="extension({{ $card->id }})" class="btn btn-primary" data-toggle="modal" data-target="#cart-extension">Gia hạn</button>
                                <div class="modal fade" id="cart-extension">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">GIA HẠN THẺ</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body extension">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td> -->
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="cart">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Thêm thẻ hội viên</h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form onsubmit="return validateCard()" method="post" action="{{ route('card.add') }}">
                        @csrf
                        <table style="width: 100%">
                            <tr>
                                <td>
                                    Tên thẻ
                                </td>
                                <td>
                                    <input id="card-name" type="text" class=" input-control form-control" name="card_name">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Giá thẻ
                                </td>
                                <td>
                                    <input class="form-control input-control " type="text" id="formattedNumberField" name="price">
                                </td>
                            </tr>
                        </table><br>
                        <label style="padding: 10px 10px 10px 0px; font-weight: bold;">Chọn dịch vụ</label>
                        <div class="row" style="max-height: 300px; overflow: auto;">
                            <table style="width: 100%">
                                @foreach ($serviceList as $service)
                                    <tr>
                                        <td>
                                            <input onclick="cardService({{ $service->id }})" id="card-service{{ $service->id }}" class="service" value="{{ $service->id }}" type="checkbox" name="service[]"> {{ $service->name }}
                                        </td>
                                        <td>
                                            <input disabled="disabled" id="card-service-percent{{ $service->id }}" type="number" class="input-control form-control" placeholder="Nhập % chiết khấu {{ $service->name }}" name="percent[]">
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        
                        <div class="col-lg-12" style="margin-top: 30px">
                            <center>
                                <button class="btn btn-primary" type="submit">XÁC NHẬN</button>
                            </center>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection