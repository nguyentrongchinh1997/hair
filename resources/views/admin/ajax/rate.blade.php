<tr>
    <td style="width: 40%">
        Đánh giá
    </td>
    <td style="width: 10%">:</td>
    <td class="rate-customer" style="font-weight: bold; width: 50%">
        @if ($bill->rate_id != '')
            <span>{{ $bill->rate->name }}</span>
        @else
            <i>Khách chưa đánh giá</i>
        @endif
    </td>
</tr>
<tr>
    <td>
        Góp ý của khách
    </td>
    <td>:</td>
    <td class="comment-customer" style="font-weight: bold;">
        @if ($bill->rate_id != '')
            <span>{{ $bill->comment }}</span>
        @else
            <i>Khách chưa góp ý</i>
        @endif
    </td>
</tr>