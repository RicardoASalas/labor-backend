<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
		"username", "password",
		"email", "name", "sector", "description",
		"phone", "email", "website",
		"avatar_url", "cif",
		"isCompany"
			
	];
	
    protected $hidden = [
		"password"
	];
	
    public function offers()
    {
        return $this->hasMany('App\Models\Offer');
	}
    
    
}
