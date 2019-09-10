<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use Notifiable;

    protected $table = 'customers';
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $fillable = [
        'full_name', 
        'phone', 
        'balance',
        'birthday',
        'password',
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

