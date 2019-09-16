<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $table = 'cards';
    protected $fillable = [
        'customer_id', 
        'card_name', 
        'price',
        'start_time',
        'end_time',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function cardDetail()
    {
        return $this->hasMany(CardDetail::class);
    }
}
