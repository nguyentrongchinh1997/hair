<tr style="background: #fcf8e3; font-weight: bold;">
    <td colspan="3"></td>
    <td class="revenue" style="text-align: right; color: #007bff; font-size: 18px"></td>
    <td style="text-align: right; color: #007bff; font-size: 18px" class="profit"></td>
    <td style="text-align: right; color: #007bff; font-size: 18px" class="salary"></td>
    <td class="tong" style="text-align: right; color: #007bff; font-size: 18px">
        
    </td>
    <td class="cam-ve" style="text-align: right; color: #007bff; font-size: 18px"></td>
    <td></td>
</tr>
@php 
    $stt = 0; 
    $totalAll = 0; 
    $salaryTotal = 0; 
    $hoaHong = 0; 
    $revenueTotal = 0;
@endphp
@foreach ($employeeList as $employee)
    <tr style="cursor: pointer;" onclick="employeeDetail({{ $employee->id }})" class="employee" id="employee{{ $employee->id }}">
        <td scope="row">{{ ++$stt }}</td>
        <td>
            <img src='{{ asset("upload/images/employee/$employee->image") }}' width="50px">
        </td>
        <td>
            {{ $employee->full_name }}<br>
            {{ substr($employee->phone, 0, 4) }}.{{ substr($employee->phone, 4, 3) }}.{{ substr($employee->phone, 7) }}
        </td>
        <td style="text-align: right; font-weight: bold;">
            @if ($type == 'month')
                @php 
                    $revenue = \App\Helper\ClassHelper::revenueMonth($employee->id, $today);
                @endphp
            @else
                @php 
                    $revenue = \App\Helper\ClassHelper::revenueDay($employee->id, $today);
                @endphp
            @endif
            {{ number_format($revenue) }}<sup>đ</sup>
            @php 
                $revenueTotal = $revenueTotal + $revenue;
            @endphp
        </td>
        <td style="text-align: right; font-weight: bold;">
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
            @php
                $hoaHong = $hoaHong + $commisionTotal;
            @endphp
        </td>
        <td style="text-align: right; font-weight: bold;">
            @if ($type == 'between')
                @php
                    $salary = ($employee->salary/30) * $numberDays;
                @endphp
            @elseif ($type == 'month')
                @php
                    $salary = $employee->salary;
                @endphp
            @endif
            {{ number_format($salary) }}<sup>đ</sup>
            @php
                $salaryTotal = $salaryTotal + $salary;
            @endphp
        </td>
        <td style="text-align: right; font-weight: bold;">
            {{ number_format($commisionTotal + $salary) }}<sup>đ</sup>
        </td>
        <td style="text-align: right; font-weight: bold;">
            {{ number_format($commisionTotal + $salary) }}<sup>đ</sup>
        </td>
        <td style="text-align: center;">
            <button style="border: 1px solid #ccc; outline: none;" onclick="editEmployee({{ $employee->id }})" type="button" class="button-control" data-toggle="modal" data-target="#edit">
                <i class="far fa-edit"></i>
            </button>
        </td>
    </tr>
        @php 
            $totalAll = $totalAll +  ($commisionTotal + $salary);
        @endphp
    
@endforeach
    <tr style="display: none;">
        <td colspan="3"></td>
        <td id="revenue">
            {{ number_format($revenueTotal) }}<sup>đ</sup>
        </td>
        <td id="profit">
            {{ number_format($hoaHong) }}<sup>đ</sup>
        </td>
        <td id="salary">
            {{ number_format($salaryTotal) }}<sup>đ</sup>
        </td>
        <td id="tong">
            {{ number_format($totalAll) }}<sup>đ</sup>
        </td>
        <td id="cam-ve">
            {{ number_format($totalAll) }}<sup>đ</sup>
        </td>
        <td></td>
    </tr>
<script type="text/javascript">
    $('.tong').html($('#tong').html());
    $('.revenue').html($('#revenue').html());
    $('.cam-ve').html($('#cam-ve').html());
    $('.profit').html($('#profit').html());
    $('.salary').html($('#salary').html());
</script>


