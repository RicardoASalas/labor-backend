<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class Offer extends Model
{
    // protected $fillable = [
	// 	"company_id","title", "description", "sector",
	// 	"experience", "min_salary", "max_salary",
	// 	"contract_type", "workday", "vacants",
	// 	"province", "city",
	// 	"promotion_level", "is_active"
		
    // ];

    protected $fillable = [
		"company_id","title", "description", "sector",
        "experience", "min_salary", "max_salary",
         "workday", "vacants","province", "city", "is_active",
         "contract_type", "times_applied"	
    ];

	
    public function company()
    {
        return $this->belongsTo('App\Models\Company');
	}
    public function candidates()
    {
        return $this->belongsToMany('App\Models\Employee', 'employees_offers', 'offer_id', 'employee_id')->withPivot('status');
	}
	
    public function skills()
    {
        return $this->belongsToMany('App\Models\Skill', "offers_skills", "offer_id", "skill_id");
    }

}

