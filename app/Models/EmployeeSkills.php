<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeSkills extends Model
{
    protected $fillable = [
        'name', 'emp_id', 'level', 'is_tested'
    ];

    public function employee()
    {
        return $this->belongsTo('App\Models\Employee');
    }
    
}
