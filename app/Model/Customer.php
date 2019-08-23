<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';
    protected $fillable = [
        'full_name', 
        'phone', 
        'balance',
        'birthday',
    ];

    public function order()
    {
    	return $this->hasMany(Order::class);
    }

    public function bill()
    {
    	return $this->hasMany(Bill::class);
    }
}

