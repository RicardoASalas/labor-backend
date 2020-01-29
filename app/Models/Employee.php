<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
//use Illuminate\Foundation\Auth\Employee as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Employee extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		"username", "password",
		"name", "surname", "description",
		"email", "phone", "website",
		"avatar_url", "cv_url",
		"province", "city",
		"nif",
		"is_company", "uid"
		
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
		"password"
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function offers()
    {
        return $this->belongsToMany('App\Models\Offer', 'employees_offers', 'employee_id', 'offer_id');
    }
    public function skills()
    {
        return $this->belongsToMany('App\Models\Skill', 'offer_skills', 'employee_id', 'skill_id');
    }
    

}


