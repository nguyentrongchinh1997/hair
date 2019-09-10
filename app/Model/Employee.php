<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
	use Notifiable;
	protected $table = 'employees';

    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $fillable = [
        'full_name', 
        'phone', 
        'service_id',
        'address',
        'percent',
        'status',
        'password',
        'balance',
        'salary',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function billDetail()
    {
        return $this->hasMany(BillDetail::class);
    }

    public function bill()
    {
        return $this->hasMany('App\Model\Bill', 'cashier', 'id');
    }

    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
