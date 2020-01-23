<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'name', 'email', 'level', 'is_tested'
    ];

    public function offers()
    {
        return $this->belongsToMany('App\Models\Offer', 'skills_offers', 'skill_id', 'offer_id');
    }
    public function employees()
    {
        return $this->belongsToMany('App\Models\Employee', 'skills_employees', 'skill_id','emp_id');
    }
}
