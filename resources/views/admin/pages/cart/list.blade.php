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
        <div class="col-lg-6">
            @if(count($errors)>0)
                <div class="alert alert-danger">
                    @foreach($errors->all() as $err)
                        {{$err}}<br>
                    @endforeach    
                </div>
            @endif  
            @if (session('thongbao'))
                <div class="alert alert-success">
                    {{ session('thongbao') }}
                </div>
            @endif
            <button style="float: left; margin-bottom: 20px; background: #FF9800; border: 0px" type="button" class="btn btn-primary button-control" data-toggle="modal" data-target="#cart">Thêm thẻ hội viên</button>
            <button style="float: right; margin-bottom: 20px; border: 0px" type="button" class="btn btn-primary button-control" data-toggle="modal" data-target="#cart-other">Thêm thẻ dịch vụ</button>
            <table class="list-table" style="margin-top: 20px">
                <thead>
                    <tr style="background: #BBDEFB">
                        <th scope="col">STT</th>
                        <th scope="col">Tên thẻ</th>
                        <th scope="col">Dịch vụ áp dụng</th>
                        <th scope="col">Giá thẻ</th>
                        <th scope="col" style="text-align: center;">Xóa</th>
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
                                    @if ($service->percent == '')
                                        {{ $service->service->name }}<span style="color: red">
                                            (free {{ $service->number }} lần)
                                        </span><br>
                                    @else
                                    {{ $service->service->name }}<span style="color: red">
                                        (giảm {{ $service->percent }}%)
                                    </span><br>
                                    @endif
                                @endforeach
                            </td>
                            <td style="text-align: right;">
                                {{ number_format($card->price) }}<sup>đ</sup>
                            </td>
                            <td style="text-align: center;">
                                <a onclick="return deleteCard()" href="{{ route('card.delete', ['id' => $card->id]) }}" style="color: red;">
                                    <i class="fas fa-times"></i>
                                </a>
                            </td>
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
                                    <input value="{{ old('card_name') }}" required="required" id="card-name" type="text" class=" input-control form-control" name="card_name">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Giá thẻ
                                </td>
                                <td>
                                    <input value="{{ old('price') }}" required="required" class="form-control input-control " type="text" id="formattedNumberField" name="price">
                                </td>
                            </tr>
                        </table><br>
                        <label style="padding: 10px 10px 10px 0px; font-weight: bold;">Dịch vụ áp dụng</label>
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
    <div class="modal fade" id="cart-other">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Thêm thẻ dịch vụ</h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('other.card.add') }}">
                        @csrf
                        <table class="add-bill" style="width: 100%">
                            <tr>
                                <td>
                                    Tên thẻ
                                </td>
                                <td>
                                    <input placeholder="Nhập tên thẻ..." value="{{ old('card_name') }}" required="required" id="card-name" type="text" class=" input-control form-control" name="card_name">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Giá thẻ
                                </td>
                                <td>
                                    <input placeholder="Giá của thẻ" value="{{ old('price') }}" required="required" class="formattedNumberField form-control input-control " type="text" name="price">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Số lần áp dụng
                                </td>
                                <td>
                                    <input required="required" placeholder="Số lần áp dụng" type="number" class="input-control form-control" name="number">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Dịch vụ áp dụng
                                </td>
                                <td>
                                    <select name="service_id" class="form-control input-control">
                                        @foreach ($serviceList as $service)
                                            <option value="{{ $service->id }}">
                                                {{ $service->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        </table><br>
                        
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
