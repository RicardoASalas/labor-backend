<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
		"title", "description", "sector",
		"experience", "min_salary", "max_salary",
		"contract_type", "workday", "vacancy",
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
        return $this->belongsToMany('App\Model\Skills', "skills_owner", "owner_id", "skills_id");
    }

}

