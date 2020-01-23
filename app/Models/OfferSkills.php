<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferSkills extends Model
{
    protected $fillable = [
        'name','offer_id', 'level', 'is_tested'
    ];

    public function offer()
    {
        return $this->belongsTo('App\Models\Offer');
    }
    
}