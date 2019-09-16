@php $stt = 0; @endphp
@foreach ($customerList as $customer)
    <tr class="list-customer" onclick="customerDetail({{ $customer->id }})" id="customer{{ $customer->id }}" style="cursor: pointer;">
        <th scope="row">{{ ++$stt }}</th>
        <td>
            {{ $customer->full_name }}
        </td>
        <td>
            {{ $customer->phone }}
        </td>
        <td>
            {{ date('d/m/Y', strtotime($customer->birthday)) }}
        </td>
    </tr>
@endforeach
