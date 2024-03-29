<form method="post" action="{{ route('service.edit', ['id' => $oldData->id]) }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <table class="list-table">
        <tr>
            <td>
                Tên dịch vụ
            </td>
            <td>
                <input type="text" class="form-control input-control" required="required" value="{{ $oldData->name }}" name="name">
            </td>
        </tr>
        <tr>
            <td>
                Giá
            </td>
            <td>
                <input type="text" value="{{ $oldData->price }}" id="format-number" class="h form-control input-control" required="required" name="price">
            </td>
        </tr>
        <tr>
            <td>
                Chiết khấu thợ chính (%)<br>
                <span style="color: red">(Khách không yêu cầu)</span>
            </td>
            <td>
                <input type="number" value="{{ $oldData->percent }}" class="form-control input-control" required="required" name="percent">
            </td>
        </tr>
        <tr>
            <td>
                Chiết khấu thợ chính (%)<br>
                <span style="color: red">(Khách yêu cầu)</span>
            </td>
            <td>
                <input type="number" value="{{ $oldData->main_request_percent }}" class="form-control input-control" required="required" name="main_request_percent">
            </td>
        </tr>
        <tr>
            <td>Chiết khấu thợ phụ (%)</td>
            <td>
                <input type="number" value="{{ $oldData->assistant_percent }}" class="form-control input-control" required="required" name="assistant_percent">
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input class="btn btn-primary button-control" value="Sửa" type="submit" name="">
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">
    $('#format-number').keyup(function(event) {
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

