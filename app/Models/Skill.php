<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
		"name"
    ];

    public function ownerEmployee()
    {
        return $this->belongsToMany('App\Models\Employee', "employees_skills", "skill_id", "employee_id");
    }
    public function ownerOffer()
    {
        return $this->belongsToMany('App\Models\Offer', "offers_skills", "skill_id", "offer_id");
    }

}

