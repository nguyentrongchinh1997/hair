<div class="col-lg-12">
	<p>
		<b>Chọn nhân viên:</b>
	</p>
	
</div>

	@foreach ($employeeList as $employee)
		<div class="col-lg-6">
			<p>
				<input type="radio" value="{{ $employee->id }}" class="employee" name="employee">
				{{ $employee->full_name }}
			</p>
		</div>
	@endforeach
