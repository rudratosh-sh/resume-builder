<?php

namespace App\Models\MongoDB;

use Jenssegers\Mongodb\Eloquent\Model;

class Cover extends Model
{
    protected $fillable = [
        'personal_profile',
        'company_profile',
        'greeting',
        'introduction',
        'why_this_company',
        'intention',
        'good_fit_thoughts',
        'future_goals',
        'final_thoughts',
        'custom_section',
        'user_id'
    ];

    protected $connection = 'mongodb';
}
