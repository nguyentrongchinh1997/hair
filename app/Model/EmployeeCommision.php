<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class EmployeeCommision extends Model
{
    protected $table = 'employee_commisions';
	protected $fillable = [
        'employee_id', 
        'bill_detail_id', 
        'percent',
        'date',
        'created_at',
    ];

    public function employee()
    {
    	return $this->belongsTo(Employee::class);
    }

    public function billDetail()
    {
    	return $this->belongsTo(BillDetail::class);
    }
}
