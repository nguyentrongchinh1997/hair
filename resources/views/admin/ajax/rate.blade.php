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
<tr>
    <td>
        Số tiền khách chuyển khoản (nếu có)
    </td>
    <td>:</td>
    <td>
        <input id="formattedNumberField" class="form-control input-control" type="text" placeholder="Nhập số tiền..." name="money_transfer">
    </td>
</tr>
<script type="text/javascript">
    $('#formattedNumberField').keyup(function(event) {
      // skip for arrow keys
      if(event.which >= 37 && event.which <= 40) return;

      // format number
      $(this).val(function(index, value) {
        return value
        .replace(/\D/g, "")
        .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        ;
      });
    });
</script>