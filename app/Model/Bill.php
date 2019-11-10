<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $table = 'bills';
    protected $fillable = [
        'rate_id', 
        'customer_id',
        'order_id',
        'price', 
        'total',
        'sale',
        'sale_detail',
        'comment',
        'time_id',
        'status',
        'cashier',
        'rate_status',
        'date',
        'created_at',
        'updated_at',
        'money_transfer',
        'request',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function billDetail()
    {
        return $this->hasMany(BillDetail::class);
    }

    public function rate()
    {
        return $this->belongsTo(Rate::class);
    }

    public function employee()
    {
        return $this->belongsTo('App\Model\Employee', 'cashier', 'id');
    }

    public function time()
    {
        return $this->belongsTo(Time::class);
    }
}

