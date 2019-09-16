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
        'other_service_percent',
        'money',
        'sale_money',
        'other_service',
        'date',
        'assistant_id',
        'created_at',
        'updated_at',
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

    public function employeeAssistant()
    {
        return $this->belongsTo('App\Model\Employee', 'assistant_id', 'id');
    }

    public function employeeCommision()
    {
        return $this->hasMany(BillDetail::class);
    }
}
