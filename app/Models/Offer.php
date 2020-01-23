<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        'comp_id', 'title', 'description', 'sector', 'experience', 'salary',
        'contract_type', 'vacants', 'city_id', 'province_id', 'promotion_level', 'is_active' 
    ];

    public function employers()
    {
        return $this->belongsToMany('App\Model\Employee', 'employees_offers', 'offer_id', 'emp_id');
    }
    public function skils()
    {
        return $this->belongsToMany('App\Model\Skill', 'skills_offers', 'offer_id', 'skill_id');
    }
    public function companie()
    {
        return $this->belongsTo('App\Model\Companie');
    }
    public function province()
    {
        return $this->belongsTo('App\Model\Province');
    }

}

