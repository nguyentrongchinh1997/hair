<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BillDetail extends Model
{
    protected $table = 'bill_detail';
    protected $fillable = [
        'bill_id', 
        'service_id', 
        'employee_id',
        'money',
        'other_service',
    ];

    public function bill()
    {
    	return $this->belongsTo(Bill::class);
    }

    public function service()
    {
    	return $this->belongsTo(Service::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
