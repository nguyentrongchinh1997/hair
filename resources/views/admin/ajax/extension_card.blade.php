<form method="post" action="{{ route('extension', ['id' => $card->id]) }}">
    @csrf
    <table class="extension" style="width: 100%">
        <tr>
        	<td style="background: #eee">
        		Khách hàng
        	</td>
        	<td>
        		{{ $card->customer->full_name }}
        	</td>
        </tr>
        <tr>
        	<td style="background: #eee">Thời gian</td>
        	<td>
        		<input class="form-control input-control" type="date" value="{{ $card->end_time }}" name="end_time">
        	</td>
        </tr>
    </table>
    <div class="col-lg-12" style="margin-top: 30px">
        <center>
            <button class="btn btn-primary" type="submit">XÁC NHẬN</button>
        </center>
    </div>
</form>