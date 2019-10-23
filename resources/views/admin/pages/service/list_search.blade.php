@php $stt = 0; @endphp
@foreach ($serviceList as $service)
    <tr>
        <th scope="row">{{ ++$stt }}</th>
        <td>
            {{ $service->name }}
        </td>
        <td style="text-align: right;">
            {{ number_format($service->price) }}<sup>đ</sup>
        </td>
        <td style="text-align: center;">
            {{ $service->percent }} %
        </td>
        <td style="text-align: center;">
            {{ $service->main_request_percent }} %
        </td>
        <td style="text-align: center;">
            {{ $service->assistant_percent }} %
        </td>
        <td style="text-align: center;">
            <button onclick="editService({{ $service->id }})" type="button" class="btn btn-primary input-control" data-toggle="modal" data-target="#edit">
                <i class="far fa-edit"></i>
            </button>
        </td>
        <td style="text-align: center;">
            @if ($service->id != config('config.service.cut') && $service->id != config('config.service.wash'))
            <a onclick="return deleteService()" href="{{ route('service.delete', ['id' => $service->id]) }}" style="color: red;">
                <i class="fas fa-times"></i>
            </a>
            @endif
        </td>
    </tr>
@endforeach