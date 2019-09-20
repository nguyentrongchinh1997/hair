<form onsubmit="return validateEmployeeAdd()" method="post" action="{{ route('employee.edit', ['id' => $oldData->id]) }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <table class="view-employee-add">
        <tr>
            <td>
                Tên nhân viên
                <input type="hidden" value="{{ $oldData->id }}" name="id">
            </td>
            <td>
                <input type="text" class="form-control" required="required" value="{{ $oldData->full_name }}" name="full_name">
            </td>
        </tr>
        <tr>
            <td>
                Số điện thoại
            </td>
            <td>
                <input type="text" class="form-control" required="required" value="{{ $oldData->phone }}" name="phone">
            </td>
        </tr>
        <tr>
            <td>
                Làm dịch vụ
            </td>
            <td>
                <select name="service_id" class="form-control">
                    <option @if ($oldData->service_id == config('config.employee.type.skinner')) {{ 'selected' }} @endif value="2">Gội</option>
                    <option @if ($oldData->service_id == config('config.employee.type.stylist')) {{ 'selected' }} @endif value="1">Cắt</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                Địa chỉ
            </td>
            <td>
                <input value="{{ $oldData->address }}" type="text" class="form-control" name="address">
            </td>
        </tr>
        <tr>
            <td>
                Lương cứng (vnđ)
            </td>
            <td>
                <input id="format-number" type="text" value="{{ $oldData->salary }}" name="salary" class="form-control">
            </td>
        </tr>
        <tr>
            <td>
                Trạng thái
            </td>
            <td>
                <select class="form-control" name="status">
                    <option @if ($oldData->status == config('config.employee.status.doing')) {{ 'selected' }} @endif value="1">
                        Đang làm
                    </option>
                    <option @if ($oldData->status == config('config.employee.status.leave')) {{ 'selected' }} @endif value="0">
                        Nghỉ làm
                    </option>
                </select>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input class="btn btn-primary" value="Sửa" type="submit" name="">
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