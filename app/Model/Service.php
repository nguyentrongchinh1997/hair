<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';
    protected $fillable = [
        'name', 
        'price',
        'percent',
        'assistant_percent',
        'main_request_percent',
    ];

    public function employee()
    {
    	return $this->hasMany(Employee::class);
    }

    public function order()
    {
    	return $this->hasMany(Order::class);
    }

    public function billDetail()
    {
        return $this->hasMany(BillDetail::class);
    }

    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function card()
    {
        return $this->belongsTo(Card::class);
    }
}
