<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $table = 'salaries';
    protected $fillable = [
        'employee_id', 
        'money',
        'date',
    ];

    public function employee()
    {
    	return $this->belongsTo(Employee::class);
    }
}
