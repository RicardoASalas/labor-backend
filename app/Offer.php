<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        'publisher_id', 'title', 'description', 'required_skill_1', 'required_skill_2', 'required_skill_3',
        'required_skill_4', 'required_skill_5', 'required_skill_6', 'sector', 'experience', 'salary',
        'contract_type', 'vacants', 'country', 'city', 'promotion_level', 'is_active' 
    ];
}
