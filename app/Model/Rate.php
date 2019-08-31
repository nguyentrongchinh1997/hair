<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $table = 'rates';
    protected $fillable = [
        'name',
        'percent', 
        'icon_class',
        'type',
    ];

    public function bill()
    {
    	return $this->hasMany(Bill::class);
    }
}
