<?php

namespace App\Models\MongoDB;

use Jenssegers\Mongodb\Eloquent\Model;

class Resume extends Model
{
    protected $fillable = [
        'personal_profile',
        'education',
        'expertise',
        'skills_and_experience',
        'courses',
        'extra_curricular_activities',
        'languages',
        'hobbies',
        'certificates',
        'internships',
        'preferences',
        'custom_sections',
        'user_id'
    ];

    protected $connection = 'mongodb';
}
