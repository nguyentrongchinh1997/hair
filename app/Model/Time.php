<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    protected $table = 'times';
    protected $fillable = [
        'time', 
    ];

    public function order()
    {
    	return $this->hasMany(Order::class);
    }
}
