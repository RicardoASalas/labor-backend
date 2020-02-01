<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class Offer extends Model
{
    protected $fillable = [
		"company_id","title", "description", "sector",
		"experience", "min_salary", "max_salary",
		"contract_type", "workday", "vacants",
		"province", "city",
		"promotion_level", "is_active"
		
    ];

	
    public function company()
    {
        return $this->belongsTo('App\Model\Company');
	}
    public function candidates()
    {
        return $this->belongsToMany('App\Model\Employee', 'employees_offers', 'offer_id', 'employee_id');
	}
	
    public function skills()
    {
        return $this->belongsToMany('App\Model\Skill', "offers_skills", "offer_id", "skill_id");
    }

}

