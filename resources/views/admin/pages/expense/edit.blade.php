<form method="post" action="{{ route('edit.post.delete', ['id' => $expense->id]) }}">
    @csrf
    <table class="add-bill" style="width: 100%">
        <tr>
            <td>Nội dung chi tiêu</td>
            <td>
                <textarea required="required" placeholder="Nội dung chi tiêu" name="content" class="form-control">{{ $expense->content }}</textarea>
            </td>
        </tr>
        <tr>
            <td>Số tiền chi tiêu</td>
            <td>
                <input value="{{ $expense->money }}" id="format-number" required="required" placeholder="Số tiền chi tiêu" type="text" class="form-control input-control" name="money">
            </td>
        </tr>
        <tr>
            <td>Chọn ngày</td>
            <td>
                <input value="{{ $expense->date }}" type="date" class="form-control input-control" name="date">
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input class="btn btn-primary button-control" type="submit" value="SỬA" name="">
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
