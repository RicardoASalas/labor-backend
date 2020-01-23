<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $fillable = [
        'name'
    ];

    public function offers()
    {
        return $this->hasMany('App\Models\Offer');
    }
    public function employees()
    {
        return $this->hasMany('App\Models\Employee', 'id', 'province_id');
    }
}
