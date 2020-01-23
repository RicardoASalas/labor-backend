<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\Employee as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Employee extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'emp_name', 'email', 'password', 'phone', 'avatar_url', 'cv_url', 'province_id', 'city_id', 'website', 'description', 'nif'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
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
        return $this->belongsToMany('App\Models\Offer', 'employees_offers', 'emp_id', 'offer_id');
    }
    public function employeeSkills()
    {
        return $this->hasMany('App\Model\EmployeeSkills');
    }
    public function province()
    {
        return $this->belongsTo('App\Models\Province');
    }
    

}


