<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
		"username", "password",
		"email", "name", "sector", "description",
		"phone", "email", "website",
		"avatar_url", "cif",
		"isCompany", "uid"
			
	];
	
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */	
    protected $hidden = [
		// "password"
	];
	
	
	
    public function offers()
    {
        return $this->hasMany('App\Models\Offer');
	}
    
    
}
