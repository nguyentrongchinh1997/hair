<div class="col-lg-12">
	<label>
        <b>CHỌN STYLIST (nếu muốn):</b>
    </label>
</div>

	@foreach ($employeeList as $employee)
		<div class="col-lg-6">
			<p>
				<input type="radio" value="{{ $employee->id }}" class="employee" name="employee">
				<i class="far fa-user-circle"></i> {{ $employee->full_name }}
			</p>
		</div>
	@endforeach
@section('script')
	<link rel="stylesheet" type="text/css" href="{{ asset('/css/client/slick.css') }}">
    <script src="{{ asset('/js/client/slick.js') }}"></script>
@endsection