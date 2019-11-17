@extends('client.mobile.employees.layouts.index')
    
@section('content')
<div class="row" style="margin-top: 92px !important; margin-bottom: 100px !important">
<!-- Lương hôm nay -->
    <div class="col-12 tab" id="today" style="text-align: center; padding: 15px 5px;">
        <!-- <h4>CHÚC MỪNG</h4> -->
        <h5 style="font-weight: bold;">
            Bảng Xếp Hạng Tháng {{ date('m/Y', strtotime($date)) }}
        </h5><br>
        @php $stt = 0; @endphp
        @foreach ($salaryList as $employee)
            <div class="row" style="box-shadow: 0 1px 6px 0 rgba(32,33,36,0.28); margin-bottom: 10px !important">
                <div class="col-12">
                    <table>
                        <tr>
                            <th style="color: #ffd800; width: 5%">
                                {{ ++$stt }}
                            </th>
                            <td style="width: 20%">
                                @php $image = $employee->employee->image; @endphp
                                <img style="width: 50px; border-radius: 100px" src='{{ asset("upload/images/employee/$image") }}'>
                            </td>
                            <td style="text-align: left;">
                                {{ $employee->employee->full_name }}
                            </td>
                            <td style="text-align: right; font-weight: bold;">
                                {{ number_format($employee->money) }} Đ
                            </td>
                        </tr>
                    </table>
                    
                </div>
            </div>
        @endforeach
        
    </div>
<!-- end -->
</div>
<style type="text/css">
    table tr td{
        border: 0px !important;
    }
</style>

@endsection
