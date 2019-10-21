<tr style="background: #fcf8e3; font-weight: bold;">
    <td class="tong" colspan="8" style="text-align: right; color: #007bff; font-size: 18px">
        
    </td>
    <td>
        
    </td>
</tr>
@php $stt = 0; $totalAll = 0; @endphp
@foreach ($employeeList as $employee)
    <tr style="cursor: pointer;" onclick="employeeDetail({{ $employee->id }})" class="employee" id="employee{{ $employee->id }}">
        <td scope="row">{{ ++$stt }}</td>
        <td>
            <img src='{{ asset("upload/images/employee/$employee->image") }}' width="50px">
        </td>
        
        <td>
            {{ $employee->full_name }}
        </td>
        <td>
            {{ substr($employee->phone, 0, 4) }}.{{ substr($employee->phone, 4, 3) }}.{{ substr($employee->phone, 7) }}
        </td>
        <td>
            {{ $employee->service->name }}
        </td>
        <td style="text-align: center;">
            <span style="{{($employee->status == config('config.employee.status.doing')) ? 'color: #4c9d2f; font-weight: bold;' : 'color: red; font-weight: bold;' }}">
                {{
                    ($employee->status == config('config.employee.status.doing')) ? 'Đang làm việc' : 'Đã nghỉ làm' 
                }}
            </span>
        </td>
        <td style="text-align: right;">
            @php 
                $commisionTotal = 0;
            @endphp
            @foreach ($employee->employeeCommision as $commision)
                @if ($commision->billDetail->bill->status == config('config.order.status.check-out'))
                    @php
                        $commisionTotal = $commisionTotal + $commision->percent/100 * $commision->billDetail->money
                    @endphp
                @endif
            @endforeach
            {{ number_format($commisionTotal) }}<sup>đ</sup>
        </td>
        <td style="text-align: right; font-weight: bold;">
            @if ($type == 'month')
                {{ number_format($commisionTotal + $employee->salary) }}<sup>đ</sup>
            @elseif ($type == 'between')
                {{ number_format($commisionTotal) }}<sup>đ</sup>
            @endif
        </td>
        <td style="text-align: center;">
            <button style="border: 1px solid #ccc; outline: none;" onclick="editEmployee({{ $employee->id }})" type="button" class="button-control" data-toggle="modal" data-target="#edit">
                <i class="far fa-edit"></i>
            </button>
        </td>
    </tr>
        @if ($type == 'month')
            @php 
                $totalAll = $totalAll +  ($commisionTotal + $employee->salary);
            @endphp
        @elseif ($type == 'between')
            @php
                $totalAll = $totalAll +  $commisionTotal;
            @endphp
        @endif
    
@endforeach
    <tr>
        <td id="tong" style="display: none;" colspan="7">
            {{ number_format($totalAll) }}<sup>đ</sup>
        </td>
    </tr>
<script type="text/javascript">
    $('.tong').html($('#tong').html());
</script>


