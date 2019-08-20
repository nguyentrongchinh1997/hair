<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'customer_id', 
        'employee_id', 
        'time',
    ];

    public function customer()
    {
    	return $this->belongsTo(Customer::class);
    }
}
