@php $stt = 0; @endphp
@foreach ($customerList as $customer)
    <tr class="list-customer" onclick="customerDetail({{ $customer->id }})" id="customer{{ $customer->id }}" style="cursor: pointer;">
        <th scope="row">{{ ++$stt }}</th>
        <td>
            {{ $customer->full_name }}
        </td>
        <td>
            {{ substr($customer->phone, 0, 4) }}.{{ substr($customer->phone, 4, 3) }}.{{ substr($customer->phone, 7) }}
        </td>
        <td>
            {{ date('d/m/Y', strtotime($customer->birthday)) }}
        </td>
    </tr>
@endforeach
