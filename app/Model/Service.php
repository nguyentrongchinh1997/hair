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
    ];

    public function employee()
    {
    	return $this->hasMany('App\Model\Employee', 'type', 'id');
    }

    public function order()
    {
    	return $this->hasMany(Order::class);
    }

    public function billDetail()
    {
        return $this->hasMany(BillDetail::class);
    }
}
