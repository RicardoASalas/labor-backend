<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'comp_name', 'email', 'password', 'phone', 'avatar_url', 'website', 'description', 'cif'
    ];

    public function offers()
    {
        return $this->hasMany('App\Models\Offer');
    }
    
}
