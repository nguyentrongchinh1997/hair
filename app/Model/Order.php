<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'customer_id', 
        'employee_id', 
        'bill_id',
        'time_id',
        'date',
        'service_id',
        'status',
    ];

    public function customer()
    {
    	return $this->belongsTo(Customer::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function time()
    {
        return $this->belongsTo(Time::class);
    }

    public function bill()
    {
        return $this->hasOne(Bill::class);
    }
}
