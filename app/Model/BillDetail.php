<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BillDetail extends Model
{
    protected $table = 'bill_detail';
    protected $fillable = [
        'bill_id', 
        'service_id', 
        'employee_id',
        'money',
    ];
}
