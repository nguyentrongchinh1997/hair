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
        'type',
        'address',
        'percent',
        'status',
        'password',
    ];

    public function service()
    {
        return $this->belongsTo('App\Model\Service', 'type', 'id');
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
