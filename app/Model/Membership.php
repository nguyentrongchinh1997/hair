<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $table = 'memberships';
	protected $fillable = [
        'customer_id', 
        'card_id', 
        'start_time',
        'end_time',
        'number',
    ];

    public function card()
    {
    	return $this->belongsTo(Card::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
