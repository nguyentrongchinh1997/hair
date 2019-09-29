@php $stt = 0; @endphp
@foreach ($employeeList as $employee)
    <tr style="cursor: pointer;" onclick="employeeDetail({{ $employee->id }})" class="employee" id="employee{{ $employee->id }}">
        <th scope="row">{{ ++$stt }}</th>
        <td>
<!--             <a href="{{ route('salary.list', ['id' => $employee->id]) }}">
                {{ $employee->full_name }}
            </a> -->
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
        <td style="color: #007bff; font-weight: bold; text-align: right;">
            @php 
                $commisionTotal = 0;
            @endphp
            @foreach ($employee->employeeCommision as $commision)
                @php
                    $commisionTotal = $commisionTotal + $commision->percent/100 * $commision->billDetail->money
                @endphp
            @endforeach
            {{ number_format($commisionTotal) }}<sup>đ</sup>
        </td>
        <td>
            <button onclick="editEmployee({{ $employee->id }})" type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit">
                Sửa
            </button>
        </td>
    </tr>
@endforeach
