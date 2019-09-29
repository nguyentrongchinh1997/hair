@extends('client.mobile.employees.layouts.index')
    
@section('content')
<div class="row history-employee" style="margin-top: 91px !important; margin-bottom: 100px !important">
    <div class="col-12" style="padding: 15px">
        <table style="width: 100%">
            <tr>
                <td style="font-weight: bold;">
                    <p>Chọn ngày</p>
                </td>
            </tr>
            <tr>
                <td>
                    <input value="{{ date('Y-m-d') }}" type="date" class="pick-date form-control" name="">
                </td>
            </tr>
        </table>
    </div>
    <div class="col-12">
        <p style="font-weight: bold;">Dánh sách khách hàng phục vụ</p>
        <table class="history-list">
            <tr style="background: #eee">
                <th>Khách hàng</th>
                <th>Dịch vụ</th>
            </tr>
            @if ($dem == 0)
                <tr>
                    <td colspan="2" style="text-align: center;">
                        <i>Không có bill nào</i>
                    </td>
                    
                </tr>
            @else
                @foreach ($history as $key => $billDetail)
                    <tr>
                        <td>
                            {{ App\Helper\ClassHelper::getCustomer($key)->customer->full_name }}
                        </td>
                        <td>
                            @foreach ($billDetail as $service)
                                @if ($service->service_id != '')
                                    {{ $service->service->name }}, 
                                @else
                                    {{ $service->other_service }}, 
                                @endif
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            @endif
        </table>
    </div>
</div>
@endsection
