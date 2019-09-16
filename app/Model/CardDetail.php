<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CardDetail extends Model
{
    protected $table = 'card_details';
    protected $fillable = [
        'service_id', 
        'customer_id', 
        'card_id',
        'percent',
    ];

    public function customer()
    {
    	return $this->belongsTo(Customer::class);
    }

    public function service()
    {
    	return $this->belongsTo(Service::class);
    }

    public function card()
    {
    	return $this->belongsTo(Card::class);
    }
}
