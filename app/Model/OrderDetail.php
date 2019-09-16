<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_details';
    protected $fillable = [
        'service_id', 
        'employee_id',
        'assistant_id',
        'order_id',
    ];

    public function service()
    {
    	return $this->belongsTo(Service::class);
    }

    public function employee()
    {
    	return $this->belongsTo(Employee::class);
    }

    public function order()
    {
    	return $this->belongsTo(Order::class);
    }

    public function assistant()
    {
        return $this->belongsTo('App\Model\Employee', 'assistant_id', 'id');
    }
}
