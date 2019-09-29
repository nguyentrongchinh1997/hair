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
