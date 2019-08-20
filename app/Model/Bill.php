<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $table = 'bills';
    protected $fillable = [
        'rate', 
        'customer_id', 
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
}
