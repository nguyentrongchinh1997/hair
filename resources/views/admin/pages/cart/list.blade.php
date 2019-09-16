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
            <h2>DANH SÁCH THẺ HỘI VIÊN</h2>
            @if (session('thongbao'))
                <div class="alert alert-success">
                    {{ session('thongbao') }}
                </div>
            @endif
        </div>
        
        <div class="col-lg-8">
            <button style="float: right; margin-bottom: 20px" type="button" class="btn btn-primary" data-toggle="modal" data-target="#cart">THÊM THẺ</button>
            <table class="table table-bordered" style="margin-top: 20px">
                <thead>
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Khách hàng</th>
                        <th scope="col">SĐT</th>
                        <th scope="col">Dịch vụ áp dụng</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Ngày hết hạn</th>
                        <th scope="col">Gia hạn</th>
                    </tr>
                </thead>
                <tbody class="order-list">
                    @php $stt = 0; @endphp
                    @foreach ($cardList as $card)
                        <tr>
                            <td>{{ ++$stt }}</td>
                            <td>
                                {{ $card->customer->full_name }}
                            </td>
                            <td>
                                {{ $card->customer->phone }}
                            </td>
                            <td>
                                @foreach ($card->cardDetail as $service)
                                    <p>
                                        » {{ $service->service->name }}
                                    </p>
                                @endforeach
                            </td>
                            <td style="text-align: center;">
                                @if (strtotime(date('Y-m-d')) <= strtotime($card->end_time))
                                    <span style="font-weight: bold; color: #007bff">
                                        Còn hạn
                                    </span>
                                @else
                                    <span style="font-weight: bold; color: red">Hết hạn</span>
                                @endif
                            </td>
                            <td>
                                {{ date('d/m/Y', strtotime($card->end_time)) }}
                            </td>
                            <td style="text-align: center;">
                                <button type="button" onclick="extension({{ $card->id }})" class="btn btn-primary" data-toggle="modal" data-target="#cart-extension">Gia hạn</button>
                                <div class="modal fade" id="cart-extension">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">GIA HẠN THẺ</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <!-- Modal body -->
                                            <div class="modal-body extension">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">THÊM THẺ HỘI VIÊN</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form onsubmit="return validateCard()" method="post" action="{{ route('card.add') }}">
                        @csrf
                        <table style="width: 100%">
                            <tr>
                                <td>Khách hàng</td>
                                <td>
                                    <select id="customer-id" name="customer_id" class="selectpicker form-control" data-live-search="true" data-width="fit" tabindex="-98">
                                        <option value="0">Chọn khách hàng</option>
                                        @foreach ($customerList as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->phone }} ({{ $customer->full_name }})</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Tên chương trình
                                </td>
                                <td>
                                    <input id="card-name" type="text" class="form-control" name="card_name">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Giá thẻ
                                </td>
                                <td>
                                    <input class="form-control" type="text" id="formattedNumberField" name="price">
                                </td>
                            </tr>
                            <tr>
                                <td>Thời gian bắt đầu</td>
                                <td>
                                    <input id="start-time" type="date" class="form-control" name="start_time">
                                </td>
                            </tr>
                            <tr>
                                <td>Thời gian kết thúc</td>
                                <td>
                                    <input id="end-time" type="date" class="form-control" name="end_time">
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
                                            <input disabled="disabled" id="card-service-percent{{ $service->id }}" type="number" class="form-control" placeholder="Nhập % chiết khấu {{ $service->name }}" name="percent[]">
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