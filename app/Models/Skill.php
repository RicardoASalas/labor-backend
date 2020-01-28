<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
		"name"
    ];

    public function ownerEmployee()
    {
        return $this->belongsToMany('App\Model\Employee', "employees_skills", "skill_id", "employee_id");
    }
    public function ownerOffer()
    {
        return $this->belongsToMany('App\Model\Offer', "offers_skills", "skill_id", "offer_id");
    }

}

