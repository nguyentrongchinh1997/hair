<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $table = 'cards';
    protected $fillable = [
        'card_name', 
        'price',
    ];

    public function cardDetail()
    {
        return $this->hasMany(CardDetail::class);
    }

    public function membership()
    {
    	return $this->hasMany(Membership::class);
    }
}
