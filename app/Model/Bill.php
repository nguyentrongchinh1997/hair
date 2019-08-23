<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $table = 'bills';
    protected $fillable = [
        'rate', 
        'customer_id',
        'order_id',
        'price', 
        'total',
        'sale',
        'sale_detail',
        'comment',
        'time',
        'status',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
